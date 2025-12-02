<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Models\TerminalReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TerminalTable extends Component
{
    use WithPagination;

    public $filterTerminal = '';
    public $selectedDate = '';
    public $editingId = null;

    protected $listeners = [
        'dateChanged' => 'updateSelectedDate',
        'refresh' => '$refresh'
    ];

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
    
    public function edit($id)
    {
        $this->editingId = $id;
        $this->dispatch('editTerminal', id: $id);
    }
    
    public function delete($id = null)
    {
        if (!$id) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'ID tidak valid',
            ]);
            return;
        }

        try {
            $record = TerminalReport::findOrFail($id);
            $record->delete();
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
            
            // Reset editing ID and refresh the table
            $this->editingId = null;
            $this->resetPage();
            $this->dispatch('$refresh');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ]);
        }
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


