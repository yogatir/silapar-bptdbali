<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Concerns\AuthorizesRole;
use App\Models\TerminalReport;
use Livewire\Component;

class TerminalForm extends Component
{
    use AuthorizesRole;

    public $tanggal;
    public $waktu;
    public $terminal = '';
    public $kedatangan_armada = 0;
    public $kedatangan_penumpang = 0;
    public $keberangkatan_armada = 0;
    public $keberangkatan_penumpang = 0;
    public $recordId = null;
    public $editingId = null;

    public array $terminalOptions = [];

    public function mount($recordId = null): void
    {
        $this->authorizeRole([UserRole::ADMIN, UserRole::SATPEL]);
        
        $this->recordId = $recordId;
        $this->editingId = $recordId;
        $this->terminalOptions = TerminalReport::getTerminalOptions();
        
        if ($recordId) {
            $this->loadRecord($recordId);
        }
    }
    
    public function loadRecord($id)
    {
        $record = TerminalReport::findOrFail($id);
        
        $this->tanggal = $record->tanggal->format('Y-m-d');
        $this->waktu = $record->waktu;
        $this->terminal = $record->terminal;
        $this->kedatangan_armada = $record->kedatangan_armada;
        $this->kedatangan_penumpang = $record->kedatangan_penumpang;
        $this->keberangkatan_armada = $record->keberangkatan_armada;
        $this->keberangkatan_penumpang = $record->keberangkatan_penumpang;
    }

    protected function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'waktu' => ['required', 'date_format:H:i'],
            'terminal' => ['required', 'in:' . collect($this->terminalOptions)->pluck('value')->implode(',')],
            'kedatangan_armada' => ['required', 'integer', 'min:0'],
            'kedatangan_penumpang' => ['required', 'integer', 'min:0'],
            'keberangkatan_armada' => ['required', 'integer', 'min:0'],
            'keberangkatan_penumpang' => ['required', 'integer', 'min:0'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->recordId) {
            $record = TerminalReport::findOrFail($this->recordId);
            $record->update($validated);
            session()->flash('message', 'Data terminal berhasil diperbarui.');
            return redirect()->route('terminal.form');
        } else {
            TerminalReport::create($validated);
            session()->flash('message', 'Laporan terminal berhasil disimpan.');
        }

        $this->reset([
            'tanggal',
            'waktu',
            'terminal',
            'kedatangan_armada',
            'kedatangan_penumpang',
            'keberangkatan_armada',
            'keberangkatan_penumpang',
        ]);

        $this->kedatangan_armada = 0;
        $this->kedatangan_penumpang = 0;
        $this->keberangkatan_armada = 0;
        $this->keberangkatan_penumpang = 0;

        $this->terminalOptions = TerminalReport::getTerminalOptions();
    }

    public function render()
    {
        return view('livewire.terminal-form');
    }
}


