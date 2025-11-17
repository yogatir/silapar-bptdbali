<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardTableSwitcher extends Component
{
    public string $primaryFilter = 'pelabuhan';
    public string $secondaryFilter = '';

    public function updatedPrimaryFilter()
    {
        $this->secondaryFilter = '';
    }

    public function getShowSecondaryFilterProperty(): bool
    {
        return in_array($this->primaryFilter, ['pelabuhan', 'terminal']);
    }

    public function render()
    {
        return view('livewire.dashboard-table-switcher', [
            'primaryOptions' => [
                ['value' => 'pelabuhan', 'label' => 'Pelabuhan'],
                ['value' => 'terminal', 'label' => 'Terminal'],
                ['value' => 'laporan_harian_seksi', 'label' => 'Laporan Harian Seksi'],
                ['value' => 'laporan_personal_harian', 'label' => 'Laporan Personal Harian'],
            ],
        ]);
    }
}


