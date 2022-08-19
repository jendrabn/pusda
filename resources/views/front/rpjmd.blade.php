@extends('front.layouts.app')
@section('title', 'RPJMD')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">RPJMD</h4>
      </div>
      <div class="card-body">
        @include('front.partials.menu_tree', ['categories' => $categories, 'routePart' => 'rpjmd'])
      </div>
    </div>
  </div>
@endsection
