<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarianSeksi;
use App\Models\Pelabuhan;
use App\Models\TerminalReport;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function __invoke()
    {
        $stats = Cache::remember('landing.stats', now()->addMinutes(5), function () {
            return [
                'pelabuhan_total' => Pelabuhan::count(),
                'terminal_total' => TerminalReport::count(),
                'seksi_total' => LaporanHarianSeksi::count(),
            ];
        });

        $now = now()->locale('id');

        $clock = [
            'day' => $now->translatedFormat('d'),
            'month_year' => $now->translatedFormat('M Y'),
            'time' => $now->translatedFormat('H:i'),
        ];

        return view('landing', [
            'stats' => $stats,
            'clock' => $clock,
        ]);
    }
}

