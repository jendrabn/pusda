@extends('layouts.admin', ['title' => 'Edit ' . $title])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit {{ $title }}</h3>
        </div>
        <div class="card-body">
            <a class="btn btn-default mb-3"
               href="{{ route('admin.' . $routePart . '.input', $tabel_id) }}">
                Back to list
            </a>

            <form action="{{ route('admin.' . $routePart . '.update', $uraian->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                {{-- <input type="hidden" name="uraian_id" value="{{ $uraian->id }}">
            <input type="hidden" name="parent_id" value="{{ $uraian->parent_id }}"> --}}

                <div class="form-group">
                    <label class="required"
                           for="uraian">Uraian</label>
                    <input autofocus
                           class="form-control @error('uraian') is-invalid @enderror"
                           id="uraian"
                           name="uraian"
                           type="text"
                           value="{{ $uraian->uraian }}">
                    @error('uraian')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required"
                           for="satuan">Satuan</label>
                    <input class="form-control @error('satuan') is-invalid @enderror"
                           id="satuan"
                           name="satuan"
                           type="text"
                           value="{{ $uraian->satuan }}">
                    @error('satuan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                    <div class="form-group">
                        <label class="required"
                               for="ketersediaan_data">Ketersedian Data</label>
                        <select class="form-control @error('ketersediaan_data') is-invalid @enderror"
                                id="ketersediaan_data"
                                name="ketersediaan_data">
                            <option selected
                                    value="">---</option>
                            <option {{ $uraian->ketersediaan_data === true ? 'selected' : '' }}
                                    value="1">Tesedia</option>
                            <option {{ $uraian->ketersediaan_data === false ? 'selected' : '' }}
                                    value="0">Tidak Tersedia
                            </option>
                        </select>
                        @error('ketersediaan_data')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                @foreach ($tahuns as $tahun)
                    <div class="form-group">
                        <label class="required"
                               for="tahun_{{ $tahun }}">{{ $tahun }}</label>
                        <input class="form-control @error('tahun_{{ $tahun }}') is-invalid @enderror"
                               id="tahun_{{ $tahun }}"
                               name="tahun_{{ $tahun }}"
                               type="text"
                               value="{{ $isi->where('tahun', $tahun)->first()->isi }}">
                        @error('tahun_{{ $tahun }}')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <p class="text-danger">(*) : Isi hanya dengan angka, isi angka 0 jika tidak ada isinya!</p>

                <button class="btn btn-primary btn-flat"
                        type="submit">
                    <i class="fa-solid fa-floppy-disk"></i> Update
                </button>
            </form>
        </div>
    </div>
@endsection
