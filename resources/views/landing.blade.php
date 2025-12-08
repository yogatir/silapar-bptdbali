<x-guest-layout>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <div class="relative bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700 text-white">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/graphy.png')] opacity-10"></div>
        <header class="relative z-10 max-w-7xl mx-auto px-6 py-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-blue-200">BPTD Kelas II Bali</p>
                <h1 class="text-2xl font-semibold">SILAPAR</h1>
            </div>
            <nav class="flex items-center gap-6 text-sm font-medium text-blue-100">
                <a href="#tentang" class="hover:text-white">Tentang</a>
                <a href="#layanan" class="hover:text-white">Layanan</a>
                <a href="#data" class="hover:text-white">Data Publik</a>
                <a href="#kontak" class="hover:text-white">Kontak</a>
            </nav>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-sm font-semibold rounded-lg transition">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-blue-900 font-semibold rounded-lg shadow hover:bg-blue-50 transition">
                        Log in
                    </a>
                @endauth
            </div>
        </header>

        <section class="relative z-10 max-w-7xl mx-auto px-6 py-16 md:py-24 grid gap-10 md:grid-cols-2 md:items-center">
            <div>
                <p class="text-blue-200 font-semibold tracking-[0.3em] text-xs uppercase">Sistem Informasi</p>
                <h2 class="mt-4 text-4xl md:text-5xl font-bold leading-tight">
                    Transparansi Operasional Transportasi Darat Bali
                </h2>
                <p class="mt-6 text-blue-100 text-lg leading-relaxed">
                    SILAPAR menghadirkan laporan pelabuhan, terminal, dan kegiatan seksi secara real-time
                    untuk mendukung layanan publik yang akuntabel dan responsif.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#data" class="px-6 py-3 bg-amber-400 text-blue-900 font-semibold rounded-lg shadow hover:bg-amber-300 transition">
                        Lihat Data Publik
                    </a>
                    <a href="#layanan" class="px-6 py-3 border border-white/40 text-white font-semibold rounded-lg hover:bg-white/10 transition">
                        Pelajari Sistem
                    </a>
                </div>
                <dl class="mt-10 grid grid-cols-2 gap-6 text-left">
                    <div class="bg-white/10 rounded-xl p-4">
                        <dt class="text-sm text-blue-200 uppercase tracking-widest">Rekap Pelabuhan</dt>
                        <dd class="text-3xl font-bold mt-2">{{ number_format($stats['pelabuhan_total']) }}</dd>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <dt class="text-sm text-blue-200 uppercase tracking-widest">Aktivitas Terminal</dt>
                        <dd class="text-3xl font-bold mt-2">{{ number_format($stats['terminal_total']) }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white/10 backdrop-blur rounded-3xl p-6 shadow-2xl border border-white/20">
                <h3 class="text-xl font-semibold mb-4">Kenapa SILAPAR?</h3>
                <ul class="space-y-4 text-blue-100">
                    <li class="flex gap-3">
                        <span class="mt-1 size-2 rounded-full bg-amber-400"></span>
                        <span>Integrasi laporan lintas seksi, pelabuhan, dan terminal dalam satu platform.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1 size-2 rounded-full bg-amber-400"></span>
                        <span>Visibilitas publik terhadap kinerja harian untuk meningkatkan kepercayaan.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1 size-2 rounded-full bg-amber-400"></span>
                        <span>Percepatan pengambilan keputusan berbasis data lapangan.</span>
                    </li>
                </ul>
                <div class="mt-8 grid grid-cols-2 gap-4 text-center text-sm font-semibold text-blue-900">
                    <div class="bg-white rounded-2xl py-4">
                        <p class="text-3xl font-bold text-blue-900">{{ $clock['day'] }}</p>
                        <p>{{ $clock['month_year'] }}</p>
                    </div>
                    <div class="bg-white rounded-2xl py-4">
                        <p class="text-3xl font-bold text-blue-900">{{ $clock['time'] }}</p>
                        <p>WITA</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section id="tentang" class="bg-white py-16 md:py-20">
        <div class="max-w-6xl mx-auto px-6 grid gap-10 md:grid-cols-2 md:items-center">
            <div>
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest">Tentang SILAPAR</p>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">Company Profile Digital</h2>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    SILAPAR merupakan platform resmi BPTD Kelas II Bali untuk menghimpun, mengelola,
                    dan menampilkan data operasional pelabuhan, terminal, serta laporan seksi harian.
                    Sistem ini dirancang sebagai etalase digital yang memperlihatkan capaian layanan,
                    inovasi keselamatan, dan kesiapan infrastruktur transportasi darat di wilayah Bali.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Melalui dashboard publik ini, masyarakat dapat memantau performa harian, sementara
                    petugas internal memperoleh akses penuh ke modul input dan analisis setelah melakukan login.
                </p>
            </div>
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-3xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold">Misi Kami</h3>
                <ul class="mt-6 space-y-4 text-sm leading-relaxed">
                    <li>• Menjaga keterbukaan data transportasi darat.</li>
                    <li>• Menyediakan informasi real-time kepada masyarakat.</li>
                    <li>• Mendukung koordinasi lintas seksi melalui teknologi.</li>
                    <li>• Menguatkan budaya pelayanan prima di lingkungan BPTD.</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="layanan" class="bg-gray-50 py-16 md:py-20 border-t border-gray-200">
        <div class="max-w-6xl mx-auto px-6">
            <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest text-center">Layanan Utama</p>
            <h2 class="mt-4 text-3xl font-bold text-center text-gray-900">Apa yang ditawarkan SILAPAR</h2>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="bg-white rounded-2xl p-6 shadow border border-gray-100">
                    <h3 class="font-semibold text-lg text-gray-900">Monitoring Pelabuhan</h3>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                        Pergerakan kapal, penumpang, dan kendaraan dipantau per pelabuhan
                        untuk memastikan kelancaran layanan penyeberangan.
                    </p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow border border-gray-100">
                    <h3 class="font-semibold text-lg text-gray-900">Aktivitas Terminal</h3>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                        Kedatangan dan keberangkatan armada darat tercatat detail sebagai
                        dasar evaluasi kapasitas terminal.
                    </p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow border border-gray-100">
                    <h3 class="font-semibold text-lg text-gray-900">Jembatan Timbang (UPPKB)</h3>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                        Pemeriksaan kendaraan dan penindakan pelanggaran melalui jembatan timbang
                        untuk memastikan keselamatan dan kepatuhan regulasi transportasi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="data" class="py-16 md:py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-3xl mx-auto">
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest">Data Publik</p>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">Rekap Operasional Harian</h2>
                <p class="mt-4 text-gray-600">
                    Seluruh pengunjung dapat meninjau data agregat yang sama seperti di dashboard internal.
                    Gunakan menu login untuk melakukan input atau analisis lanjutan.
                </p>
            </div>

            <div class="space-y-10">
                <div class="bg-gray-50 rounded-3xl border border-gray-200 shadow-sm">
                    <div class="px-6 pt-6">
                        <h3 class="text-xl font-semibold text-gray-900">Pelabuhan</h3>
                        <p class="text-gray-600 text-sm mt-1">Data trafik kapal, penumpang, dan kendaraan.</p>
                    </div>
                    <div class="mt-4">
                        @livewire('pelabuhan-table')
                    </div>
                </div>

                <div class="bg-gray-50 rounded-3xl border border-gray-200 shadow-sm">
                    <div class="px-6 pt-6">
                        <h3 class="text-xl font-semibold text-gray-900">Terminal</h3>
                        <p class="text-gray-600 text-sm mt-1">Kedatangan dan keberangkatan armada serta penumpang.</p>
                    </div>
                    <div class="mt-4">
                        @livewire('terminal-table')
                    </div>
                </div>

                <div class="bg-gray-50 rounded-3xl border border-gray-200 shadow-sm">
                    <div class="px-6 pt-6">
                        <h3 class="text-xl font-semibold text-gray-900">Laporan UPPKB</h3>
                        <p class="text-gray-600 text-sm mt-1">Rekap pemeriksaan dan kegiatan operasional harian SATPEL.</p>
                    </div>
                    <div class="mt-4">
                        @livewire('laporan-operasional-harian-table')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="bg-blue-900 text-white py-16 md:py-20">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-200">Hubungi Kami</p>
            <h2 class="mt-4 text-3xl font-bold">BPTD Kelas II Bali</h2>
            <p class="mt-4 text-blue-100 max-w-3xl mx-auto">
                Jl. Raya Mengwitani - Terminal Tipe A Mengwi, Badung-Bali • Telp: (0361) 123-456 • Email: bptd-bali@hubdat.go.id
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="mailto:bptd-bali@hubdat.go.id" class="px-6 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-blue-50 transition">
                    Email Kami
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3 border border-white/40 font-semibold rounded-lg hover:bg-white/10 transition">
                    Masuk Sistem
                </a>
            </div>
        </div>
    </section>
</x-guest-layout>

