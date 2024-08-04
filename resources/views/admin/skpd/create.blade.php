@extends('layouts.admin', ['title' => 'Create SKPD'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create SKPD</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-secondary"
                   href="{{ route('admin.skpd.index') }}">
                    Back to list
                </a>
            </div>
            <form action="{{ route('admin.skpd.store') }}"
                  method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label class="required">Kategori</label>
                        <select autofocus
                                class="form-control select2 @error('kategori_skpd_id') is-invalid @enderror"
                                name="kategori_skpd_id">
                            <option selected
                                    value="">---</option>
                            @foreach ($kategori as $id => $nama)
                                <option @selected($id == old('kategori_skpd_id'))
                                        value="{{ $id }}">
                                    {{ $nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_skpd_id')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="required">Nama</label>
                        <input class="form-control @error('nama') is-invalid @enderror"
                               name="nama"
                               type="text"
                               value="{{ old('nama') }}">
                        @error('nama')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="required">Singkatan</label>
                        <input class="form-control @error('singkatan') is-invalid @enderror"
                               name="singkatan"
                               type="text"
                               value="{{ old('singkatan') }}">
                        @error('singkatan')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <p class="text-muted">(<code>*</code>) wajib diisi</p>

                <div class="form-group text-right mb-0">
                    <button class="btn btn-primary"
                            type="submit">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
