@extends('layouts.admin-master')

@section('title')
  Uraian Form Menu Indikator
@endsection

@section('content')
  <section class="section-header">
    <h1>Uraian Form Menu Indikator</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Uraian Form Menu Indikator</div>
    </div>
  </section>

  <section class="section-body">
    <h2 class="section-title">Uraian Form Menu Indikator</h2>
    <p class="section-lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores hic obcaecati cumque in
      eveniet esse!</p>

    <div class="card">
      <div class="card-header">
        <h4>Pilih Menu Treeview</h4>
      </div>
      <div class="card-body overflow-auto">
        <div id="treeview">
          @include('admin.uraian.partials.menu_tree')
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  @include('admin.uraian.partials.scripts')
@endpush
