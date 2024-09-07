@extends('layouts.front', ['title' => 'Home'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-4 shadow-lg">
                    <div class="card-header card-header__lg bg-white">
                        <h4 class="card-header__title">Kepala Daerah</h4>
                    </div>
                    <div class="card-body">
                        <figure class="img__wrapper border-bottom pb-3">
                            <img alt="Bupati"
                                 class="img-fluid"
                                 src="{{ asset('img/bupati.jpg') }}">
                            <figcaption>
                                <h5>Karna Suswandi</h5>
                                <p>Bupati Situbondo</p>
                            </figcaption>
                        </figure>
                        <figure class="img__wrapper">
                            <img alt="Wakil Bupati"
                                 class="img-fluid"
                                 src="{{ asset('img/wakil-bupati.jpg') }}">
                            <figcaption>
                                <h5>Khoirani</h5>
                                <p>Wakil Bupati Situbondo</p>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-header card-header__lg bg-white">
                        <h4 class="card-header__title">Sambutan Kepala Daerah</h4>
                    </div>
                    <div class="card-body">
                        <div class="greeting__text">
                            <p>Perencanaan yang baik adalah perencanaan yang didukung dan berbasis pada data. Semakin
                                lengkap dan
                                akurat data yang
                                diperoleh, maka hasil perencanaan akan semakin baik, "Garbage In Garbage Out". Pemimpin yang
                                bijaksana
                                wisdom adalah
                                pemimpin yang mampu mengambil keputusan atau menggunakan datanya untuk meningkatkan
                                kesejahteraan dan
                                martabat manusia.</p>
                            <p>Dalam Permendagri No. 54 Tahun 2010, Pemerintah Daerah diminta membuat Bank Data atau Pusat
                                Data
                                Perencanaan dan
                                Pengendalian Pembangunan Daerah (PDP3D) yang kemudian disempurnakan dalam Permendagri no 8
                                tahun 2014
                                tentang Sistem
                                Informasi Pembangunan Daerah (SIPD) sebagai bahan perencanaan dan pengendalian kegiatan
                                pembangunan.
                                Begitu besar jenis
                                dan varian data mengakibatkan kita sering mendapatkan data yang berbeda antar instansi
                                penyedia data,
                                baik dari BPS,
                                Pemerintah Daerah maupun Media, untuk itu diperlukan sistem yang akan menyimpan semua data
                                tersebut
                                dan menyajikannya
                                secara transparan dan standar.</p>
                            <p>Selama ini pemerintah daerah banyak membangun Bank Data atau Pusat Data "Data Center" bahkan
                                tiap
                                SKPD juga memiliki
                                Pusat Data SKPD, namun masing-masing pusat data ini tidak terintegrasi, sehingga sering kita
                                temui
                                duplikasi data atau
                                data yang berbeda antar SKPD. Untuk itu keberadaan Aplikasi Pusat Data atau Aplikasi PDP3D
                                yang
                                berbasis internet "web
                                based" menjadi sebuah kebutuhan dan keharusan bagi pemerintah daerah untuk melakukan
                                standarisasi data
                                dan memudahkan
                                serta mempercepat proses pembaharuan "updating" data.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header card-header__lg bg-white">
                        <h4 class="card-header__title">Pusat Data Kabupaten Situbondo</h4>
                    </div>
                    <div class="card-body">
                        <div class="about__app">
                            <p>Aplikasi yang dibangun oleh TIM PKL Fakultas Ilmu Komputer Universitas Jember sebagai pusat
                                data dan
                                informasi pembangunan, serta
                                media keterbukaan publik tentang informasi Kabupaten Situbondo.</p>
                            <ul>
                                <li>
                                    <span><i class="fa-solid fa-globe"></i></span>
                                    <span><a href="http://www.situbondokab.go.id"
                                           rel=noreferrer
                                           target="_blank">www.situbondokab.go.id</a></span>
                                </li>
                                <li>
                                    <span><i class="fab fa-twitter"></i></span>
                                    <span><a href="https://twitter.com/kominfo_sit"
                                           rel=noreferrer
                                           target="_blank">@kominfo_sit</a></span>
                                </li>
                                <li>
                                    <span><i class="fab fa-facebook-f"></i></span>
                                    <span><a href="https://www.facebook.com/Diskominfosit/"
                                           rel=noreferrer
                                           target="_blank">Kominfo
                                            Situbondo</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header card-header__lg bg-white">
                        <h4 class="card-header__title">Statistik Pengunjung Website</h4>
                    </div>
                    <div class="card-body">
                        <div class="visitor__statistic">
                            <div class="row">
                                <div class="col-lg-3 count">
                                    <h5>Hari ini</h5>
                                    <p>{{ $visitor->day_count() }}</p>
                                </div>
                                <div class="col-lg-3 count">
                                    <h5>Bulan ini</h5>
                                    <p>{{ $visitor->month_count() }}</p>
                                </div>
                                <div class="col-lg-3 count">
                                    <h5>Tahun ini</h5>
                                    <p>{{ $visitor->year_count() }}</p>
                                </div>
                                <div class="col-lg-3 count">
                                    <h5>Semua</h5>
                                    <p>{{ $visitor->all_count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
