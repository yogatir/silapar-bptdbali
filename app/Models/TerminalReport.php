<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'waktu',
        'terminal',
        'kedatangan_armada',
        'kedatangan_penumpang',
        'keberangkatan_armada',
        'keberangkatan_penumpang',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'kedatangan_armada' => 'integer',
        'kedatangan_penumpang' => 'integer',
        'keberangkatan_armada' => 'integer',
        'keberangkatan_penumpang' => 'integer',
    ];

    public static function getTerminalOptions(): array
    {
        $terminals = config('terminal.options', []);

        return collect($terminals)->map(fn ($terminal) => [
            'value' => $terminal,
            'label' => $terminal,
        ])->values()->toArray();
    }
}


