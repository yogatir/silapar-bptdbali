<?php

namespace App\Livewire;

use App\Models\TerminalReport;
use Livewire\Component;
use Livewire\WithPagination;

class TerminalTable extends Component
{
    use WithPagination;

    public $filterTerminal = '';
    public $selectedDate = '';

    protected $listeners = ['dateChanged' => 'updateSelectedDate'];

    public function mount($filterTerminal = '', $selectedDate = '')
    {
        $this->filterTerminal = $filterTerminal;
        $this->selectedDate = $selectedDate;
    }
    
    public function updateSelectedDate($date)
    {
        $this->selectedDate = $date;
        $this->resetPage();
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
        
        if (!empty($this->selectedDate)) {
            $query->whereDate('tanggal', $this->selectedDate);
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


