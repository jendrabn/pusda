@extends('guest.layouts.app')

@section('title')
  8 Kelompok Data
@endsection

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">8 Kelompok Data</h4>
      </div>
      <div class="card-body">
        @include('guest.partials.menu_tree', ['categories' => $categories, 'resourceName' => 'delapankeldata'])
      </div>
    </div>
  </div>
@endsection
