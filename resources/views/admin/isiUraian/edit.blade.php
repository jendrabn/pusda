@extends('layouts.admin', ['title' => 'Edit ' . $title])

@section('content')
  <div class="card">
    <div class="card-header">Edit {{ $title }}</div>
    <div class="card-body">
      <form action="{{ route('admin.' . $crudRoutePart . '.update_isi_uraian', $uraian->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- <input type="hidden" name="uraian_id" value="{{ $uraian->id }}">
        <input type="hidden" name="parent_id" value="{{ $uraian->parent_id }}"> --}}

        <div class="form-group">
          <label class="required" for="uraian">Uraian</label>
          <input type="text" name="uraian" id="uraian" class="form-control" value="{{ $uraian->uraian }}">
        </div>
        <div class="form-group">
          <label class="required" for="satuan">Satuan</label>
          <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $uraian->satuan }}">
        </div>

        <div class="form-group">
          <label class="required" for="ketersediaan_data">Ketersedian Data</label>
          <select name="ketersediaan_data" id="ketersediaan_data" class="form-control select2">
            <option selected disabled hidden>Please Select</option>
            <option value="1" {{ $uraian->ketersediaan_data == '1' ? 'selected' : '' }}>Tesedia</option>
            <option value="0" {{ $uraian->ketersediaan_data == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
          </select>
        </div>

        @foreach ($tahuns as $tahun)
          <div class="form-group">
            <label class="required" for="tahun_{{ $tahun }}">{{ $tahun }}</label>
            <input type="text" name="tahun_{{ $tahun }}" id="tahun_{{ $tahun }}" class="form-control"
              value="{{ $isi->where('tahun', $tahun)->first()->isi }}">
          </div>
        @endforeach

        <p class="text-danger">(*) : Isi hanya dengan angka, isi angka 0 jika tidak ada isinya!</p>

        <div class="form-group">
          <button type="submit" class="btn btn-danger">Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection
