@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
    @role(\App\Models\User::ROLE_ADMIN)
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_8keldata }}</h3>

                        <p>JUMLAH DATA 8 KEL.DATA</p>
                    </div>
                    <div class="icon">

                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_indikator }}</h3>

                        <p>JUMLAH DATA INDIKATOR</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_rpjmd }}</h3>

                        <p>JUMLAH DATA RPJMD</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $total_bps }}</h3>

                        <p>JUMLAH DATA BPS</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
    @endrole

    @role(\App\Models\User::ROLE_SKPD)
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ 0 }}</h3>

                        <p>ASSET ( DALAM MILYAR )</p>
                    </div>
                    <div class="icon">

                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ 0 }}</h3>

                        <p>INVESTASI ( DALAM MILYAR )</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ 0 }}</h3>

                        <p>BARANG BARU</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $total_users }}</h3>

                        <p>PENGGUNA APLIKASI</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
    @endrole
@endsection
