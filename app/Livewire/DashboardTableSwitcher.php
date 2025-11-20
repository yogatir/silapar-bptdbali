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

    public function mount(): void
    {
        $this->userRole = Auth::user()->role;
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

    public function render()
    {
        return view('livewire.dashboard-table-switcher', [
            'primaryOptions' => $this->getPrimaryOptions(),
        ]);
    }
}


