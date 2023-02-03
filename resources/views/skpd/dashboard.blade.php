@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ 0 }}</h3>

          <p>ASSET ( DALAM MILYAR )</p>
        </div>
        <div class="icon">

          <i class="fas fa-chart-pie"></i>
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
          <i class="fas fa-chart-pie"></i>
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
          <i class="fas fa-chart-pie"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $users_count }}</h3>

          <p>PENGGUNA APLIKASI</p>
        </div>
        <div class="icon">
          <i class="fas fa-chart-pie"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>
@endsection
