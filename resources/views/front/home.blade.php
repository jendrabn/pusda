@extends('layouts.front', ['title' => 'Home'])

@section('content')
    <div class="home-page">
        <section class="home-hero">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <h1>Portal Data Terpadu Untuk Perencanaan Daerah Yang Lebih Baik</h1>
                        <p class="hero-lead">Portal resmi untuk menyajikan data pembangunan secara ringkas, terbuka, dan
                            mudah ditelusuri agar perencanaan serta evaluasi program lebih terarah.</p>
                        <div class="hero-actions">
                            <a class="btn btn-primary btn-lg"
                               href="{{ route('delapankeldata.index') }}">Jelajahi Data</a>
                            <a class="btn btn-outline-light btn-lg"
                               href="{{ route('indikator.index') }}">Indikator Kinerja</a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-panel">
                            <div class="hero-panel-head">
                                <h6>Ringkasan Pengunjung</h6>
                                <span class="status-pill">Realtime</span>
                            </div>
                            <div class="mini-stats">
                                <div class="mini-stat">
                                    <span class="mini-label">24 Jam</span>
                                    <span class="mini-value">{{ $visitor->day_count }}</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-label">30 Hari</span>
                                    <span class="mini-value">{{ $visitor->month_count }}</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-label">Tahun Berjalan</span>
                                    <span class="mini-value">{{ $visitor->year_count }}</span>
                                </div>
                                <div class="mini-stat">
                                    <span class="mini-label">Semua Waktu</span>
                                    <span class="mini-value">{{ $visitor->all_count }}</span>
                                </div>
                            </div>
                            <a class="hero-panel-link"
                               href="#statistik">Lihat detail statistik</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="section-eyebrow">Akses Cepat</span>
                        <h2>Mulai dari data yang kamu butuhkan</h2>
                        <p>Gunakan pintasan berikut untuk menemukan data utama dengan lebih cepat.</p>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <a class="quick-card"
                           href="{{ route('bps.index') }}">
                            <span class="quick-icon"><i class="fas fa-chart-line"></i></span>
                            <h3>BPS</h3>
                            <p>Statistik resmi daerah dan indikator makro.</p>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a class="quick-card"
                           href="{{ route('rpjmd.index') }}">
                            <span class="quick-icon"><i class="fas fa-road"></i></span>
                            <h3>RPJMD</h3>
                            <p>Rencana pembangunan dan target kinerja.</p>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a class="quick-card"
                           href="{{ route('delapankeldata.index') }}">
                            <span class="quick-icon"><i class="fas fa-layer-group"></i></span>
                            <h3>8 Kelompok Data</h3>
                            <p>Kelompok data sektoral yang terstruktur.</p>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a class="quick-card"
                           href="{{ route('skpd') }}">
                            <span class="quick-icon"><i class="fas fa-building"></i></span>
                            <h3>SKPD</h3>
                            <p>Data per perangkat daerah dan unit kerja.</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="section-eyebrow">Profil</span>
                        <h2>Kepala Daerah</h2>
                        <p>Pimpinan daerah yang mengarahkan pembangunan Kabupaten Situbondo.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <article class="leader-card">
                            <div class="leader-photo">
                                <img alt="Bupati"
                                     src="{{ asset('img/bupati.jpg') }}">
                            </div>
                            <div class="leader-body">
                                <span class="role-pill">Bupati Situbondo</span>
                                <h3>Yusuf Rio Wahyu Prayogo, S.Sos</h3>
                                <p class="leader-note">Memimpin arah kebijakan dan program pembangunan daerah.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-6">
                        <article class="leader-card">
                            <div class="leader-photo">
                                <img alt="Wakil Bupati"
                                     src="{{ asset('img/wakil-bupati.jpg') }}">
                            </div>
                            <div class="leader-body">
                                <span class="role-pill role-pill--secondary">Wakil Bupati Situbondo</span>
                                <h3>Ulfiyah, S.Pd.I</h3>
                                <p class="leader-note">Mendampingi koordinasi lintas perangkat daerah.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="surface">
                            <div class="surface-head">
                                <span class="section-eyebrow">Sambutan</span>
                                <h2>Sambutan Kepala Daerah</h2>
                            </div>
                            <div class="surface-body greeting-text">
                                <p>Perencanaan yang baik adalah perencanaan yang didukung dan berbasis pada data. Semakin
                                    lengkap dan akurat data yang diperoleh, maka hasil perencanaan akan semakin baik,
                                    "Garbage In Garbage Out". Pemimpin yang bijaksana adalah pemimpin yang mampu
                                    mengambil keputusan atau menggunakan datanya untuk meningkatkan kesejahteraan dan
                                    martabat manusia.</p>
                                <p>Dalam Permendagri No. 54 Tahun 2010, Pemerintah Daerah diminta membuat Bank Data atau
                                    Pusat Data Perencanaan dan Pengendalian Pembangunan Daerah (PDP3D) yang kemudian
                                    disempurnakan dalam Permendagri No. 8 Tahun 2014 tentang Sistem Informasi Pembangunan
                                    Daerah (SIPD) sebagai bahan perencanaan dan pengendalian kegiatan pembangunan. Begitu
                                    besar jenis dan varian data mengakibatkan kita sering mendapatkan data yang berbeda
                                    antar instansi penyedia data, baik dari BPS, Pemerintah Daerah maupun Media, untuk
                                    itu diperlukan sistem yang akan menyimpan semua data tersebut dan menyajikannya
                                    secara transparan dan standar.</p>
                                <p>Selama ini pemerintah daerah banyak membangun Bank Data atau Pusat Data "Data Center"
                                    bahkan tiap SKPD juga memiliki Pusat Data SKPD, namun masing-masing pusat data ini
                                    tidak terintegrasi, sehingga sering kita temui duplikasi data atau data yang berbeda
                                    antar SKPD. Untuk itu keberadaan Aplikasi Pusat Data atau Aplikasi PDP3D yang berbasis
                                    internet "web based" menjadi sebuah kebutuhan dan keharusan bagi pemerintah daerah
                                    untuk melakukan standarisasi data dan memudahkan serta mempercepat proses pembaharuan
                                    "updating" data.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="surface surface-compact">
                            <div class="surface-head">
                                <span class="section-eyebrow">Tentang</span>
                                <h2>Pusat Data Kabupaten Situbondo</h2>
                            </div>
                            <div class="surface-body about-app">
                                <p>Aplikasi yang dibangun oleh TIM PKL Fakultas Ilmu Komputer Universitas Jember sebagai
                                    pusat data dan informasi pembangunan, serta media keterbukaan publik tentang informasi
                                    Kabupaten Situbondo.</p>
                                <ul class="icon-list">
                                    <li>
                                        <span class="icon-circle"><i class="fas fa-globe"></i></span>
                                        <span><a href="http://www.situbondokab.go.id"
                                               rel=noreferrer
                                               target="_blank">www.situbondokab.go.id</a></span>
                                    </li>
                                    <li>
                                        <span class="icon-circle"><i class="fab fa-twitter"></i></span>
                                        <span><a href="https://twitter.com/kominfo_sit"
                                               rel=noreferrer
                                               target="_blank">@kominfo_sit</a></span>
                                    </li>
                                    <li>
                                        <span class="icon-circle"><i class="fab fa-facebook-f"></i></span>
                                        <span><a href="https://www.facebook.com/Diskominfosit/"
                                               rel=noreferrer
                                               target="_blank">Kominfo Situbondo</a></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section"
                 id="statistik">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="section-eyebrow">Statistik</span>
                        <h2>Pengunjung Website</h2>
                        <p>Ringkasan trafik pengunjung berdasarkan rentang waktu.</p>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-head">
                                <span class="stat-label">Hari ini</span>
                                <span class="stat-chip stat-chip--primary">24 Jam</span>
                            </div>
                            <div class="stat-value">{{ $visitor->day_count }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-head">
                                <span class="stat-label">Bulan ini</span>
                                <span class="stat-chip stat-chip--success">30 Hari</span>
                            </div>
                            <div class="stat-value">{{ $visitor->month_count }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-head">
                                <span class="stat-label">Tahun ini</span>
                                <span class="stat-chip stat-chip--warning">Tahun Berjalan</span>
                            </div>
                            <div class="stat-value">{{ $visitor->year_count }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="stat-card">
                            <div class="stat-head">
                                <span class="stat-label">Semua waktu</span>
                                <span class="stat-chip stat-chip--dark">Total</span>
                            </div>
                            <div class="stat-value">{{ $visitor->all_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="section-eyebrow">Rekomendasi</span>
                        <h2>Data Populer</h2>
                        <p>Beberapa pintasan data yang paling sering diakses pengunjung.</p>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <a class="data-card"
                           href="{{ route('indikator.index') }}">
                            <span class="data-card-icon"><i class="fas fa-bullseye"></i></span>
                            <h3>Indikator Kinerja</h3>
                            <p>Indikator utama yang dipantau secara berkala.</p>
                            <span class="data-card-link">Lihat indikator</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="data-card"
                           href="{{ route('bps.index') }}">
                            <span class="data-card-icon"><i class="fas fa-chart-pie"></i></span>
                            <h3>Statistik BPS</h3>
                            <p>Data statistik resmi untuk kebutuhan analisis.</p>
                            <span class="data-card-link">Lihat statistik</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="data-card"
                           href="{{ route('delapankeldata.index') }}">
                            <span class="data-card-icon"><i class="fas fa-th-large"></i></span>
                            <h3>Kelompok Data</h3>
                            <p>Kumpulan data sektoral yang terstruktur.</p>
                            <span class="data-card-link">Jelajahi data</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
