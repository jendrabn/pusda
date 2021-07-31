@extends('layouts.admin-master')

@section('title')
  Uraian Form Menu 8 Kel. Data
@endsection

@section('content')
  <section class="section-header">
    <h1>Uraian Form Menu 8 Kel. Data</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Uraian Form Menu 8 Kel. Data</div>
    </div>
  </section>
  <section class="section-body">
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
