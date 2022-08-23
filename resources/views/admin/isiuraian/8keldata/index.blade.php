@extends('layouts.admin')

@section('title', '8 Kel. Data')

@section('content')
  <div class="card">
    <div class="card-header text-uppercase">
      Pilih Menu Tree View
    </div>
    <div class="card-body jstreeMenu overflow-auto">
      @include('admin.isiuraian.8keldata.menu_tree')
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/isiUraian.js') }}"></script>
@endsection
