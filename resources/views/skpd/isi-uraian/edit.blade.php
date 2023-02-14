@extends('layouts.admin', ['title' => 'Edit ' . $title])

@section('content')
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">Edit {{ $title }}</div>
        <div class="card-body">
          <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin_skpd.' . $crudRoutePart . '.input', $tabelId) }}">
              <i class="fas fa-backward"></i> Back to list
            </a>
          </div>

          <form
            action="{{ route('admin_skpd.' . $crudRoutePart . '.update', $uraian->id) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- <input type="hidden" name="uraian_id" value="{{ $uraian->id }}">
            <input type="hidden" name="parent_id" value="{{ $uraian->parent_id }}"> --}}

            <div class="form-group">
              <label class="required" for="uraian">Uraian</label>
              <input class="form-control @error('uraian') is-invalid @enderror" id="uraian" name="uraian"
                type="text" value="{{ $uraian->uraian }}">
              @error('uraian')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="satuan">Satuan</label>
              <input class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan"
                type="text" value="{{ $uraian->satuan }}">
              @error('satuan')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
              <div class="form-group">
                <label class="required" for="ketersediaan_data">Ketersedian Data</label>
                <select class="form-control @error('ketersediaan_data') is-invalid @enderror" id="ketersediaan_data"
                  name="ketersediaan_data">
                  <option selected disabled hidden>Pilih Ketersediaan Data</option>
                  <option value="1" {{ $uraian->ketersediaan_data === true ? 'selected' : '' }}>Tesedia</option>
                  <option value="0" {{ $uraian->ketersediaan_data === false ? 'selected' : '' }}>Tidak Tersedia
                  </option>
                </select>
                @error('ketersediaan_data')
                  <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            @endif
            @foreach ($tahuns as $tahun)
              <div class="form-group">
                <label class="required" for="tahun_{{ $tahun }}">{{ $tahun }}</label>
                <input class="form-control @error('tahun_{{ $tahun }}') is-invalid @enderror"
                  id="tahun_{{ $tahun }}" name="tahun_{{ $tahun }}" type="text"
                  value="{{ $isi->where('tahun', $tahun)->first()->isi }}">
                @error('tahun_{{ $tahun }}')
                  <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            @endforeach

            <p class="text-danger">(*) : Isi hanya dengan angka, isi angka 0 jika tidak ada isinya!</p>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-save"></i> Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
