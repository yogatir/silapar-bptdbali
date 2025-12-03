<?php

namespace App\Livewire;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardTableSwitcher extends Component
{
    public string $primaryFilter = 'pelabuhan';
    public string $secondaryFilter = '';
    public string $userRole;
    public $startDate;
    public $endDate;

    protected $queryString = [
        'primaryFilter' => ['except' => 'pelabuhan'],
        'secondaryFilter' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->userRole = Auth::user()->role;
        $this->startDate = $this->startDate ?? ''; // Empty by default to show all records
        $this->endDate = $this->endDate ?? now()->format('Y-m-d'); // Default end date to today
        $this->primaryFilter = $this->primaryFilter ?? 'pelabuhan';
        $this->secondaryFilter = $this->secondaryFilter ?? '';
    }

    public function updatedPrimaryFilter(): void
    {
        $this->secondaryFilter = '';
    }

    public function getShowSecondaryFilterProperty(): bool
    {
        return in_array($this->primaryFilter, ['pelabuhan', 'terminal', 'laporan_harian_seksi'], true);
    }

    protected function getPrimaryOptions(): array
    {
        $options = [
            ['value' => 'pelabuhan', 'label' => 'Pelabuhan'],
            ['value' => 'terminal', 'label' => 'Terminal'],
            ['value' => 'laporan_harian_seksi', 'label' => 'Laporan Harian Seksi'],
            ['value' => 'laporan_operasional_harian', 'label' => 'Laporan UPPKB'],
        ];

        if ($this->userRole === UserRole::SATPEL) {
            $options = array_values(array_filter(
                $options,
                static fn (array $option) => $option['value'] !== 'laporan_harian_seksi'
            ));

            if ($this->primaryFilter === 'laporan_harian_seksi') {
                $this->primaryFilter = 'pelabuhan';
            }
        }

        if (! $this->isPrimaryFilterAvailable($options)) {
            $this->primaryFilter = 'pelabuhan';
        }

        return $options;
    }

    protected function isPrimaryFilterAvailable(array $options): bool
    {
        return collect($options)->contains(fn ($option) => $option['value'] === $this->primaryFilter);
    }

    protected $rules = [
        'startDate' => 'nullable|date|before_or_equal:endDate',
        'endDate' => 'nullable|date|after_or_equal:startDate|before_or_equal:today',
    ];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['startDate', 'endDate'])) {
            $this->validateOnly($propertyName);
            
            // If start date is after end date, adjust end date
            if ($this->startDate && $this->endDate && $this->startDate > $this->endDate) {
                $this->endDate = $this->startDate;
            }
            
            // Reset the page when dates change
            $this->resetPage();
            
            // Emit an event to let the tables know the dates have changed
            $this->dispatch('dateRangeChanged', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate
            ]);
        }
    }
    
    public function clearDates()
    {
        $this->startDate = '';
        $this->endDate = now()->format('Y-m-d');
        $this->resetPage();
        $this->dispatch('dateRangeChanged', [
            'startDate' => '',
            'endDate' => now()->format('Y-m-d')
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard-table-switcher', [
            'primaryOptions' => $this->getPrimaryOptions(),
            'maxDate' => now()->format('Y-m-d'),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'showSecondaryFilter' => $this->showSecondaryFilter,
            'secondaryFilter' => $this->secondaryFilter,
        ]);
    }
    
    public function resetPage()
    {
        // This is a helper method to reset the page when filters change
        // The actual pagination reset is handled by the table components
        $this->dispatch('resetPage');
    }
}


