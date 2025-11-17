<?php

namespace App\Livewire;

use App\Models\TerminalReport;
use Livewire\Component;
use Livewire\WithPagination;

class TerminalTable extends Component
{
    use WithPagination;

    public $filterTerminal = '';

    public function mount($filterTerminal = '')
    {
        $this->filterTerminal = $filterTerminal;
    }

    public function updatedFilterTerminal()
    {
        $this->resetPage();
    }

    public function getRecordsProperty()
    {
        $query = TerminalReport::query()
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu');

        if ($this->filterTerminal) {
            $query->where('terminal', $this->filterTerminal);
        }

        return $query->paginate(50);
    }

    public function render()
    {
        return view('livewire.terminal-table', [
            'records' => $this->records,
        ]);
    }
}


