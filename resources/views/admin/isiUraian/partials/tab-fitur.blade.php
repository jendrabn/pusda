<form action="{{ route('admin.' . $routePart . '.update_fitur', [$tabel->id, 'tab' => 'fitur']) }}"
      method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                  id="deskripsi"
                  name="deskripsi">{{ $fitur?->deskripsi }}</textarea>
        @error('deskripsi')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="analisis">Analisis</label>
        <textarea class="form-control @error('analisis') is-invalid @enderror"
                  id="analisis"
                  name="analisis">{{ $fitur?->analisis }}</textarea>
        @error('analisis')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="permasalahan">Permasalahan</label>
        <textarea class="form-control @error('permasalahan') is-invalid @enderror"
                  id="permasalahan"
                  name="permasalahan">{{ $fitur?->permasalahan }}</textarea>
        @error('permasalahan')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="solusi">Solusi atau Langkah-langkah Tindak Lanjut</label>
        <textarea class="form-control @error('solusi') is-invalid @enderror"
                  id="solusi"
                  name="solusi">{{ $fitur?->solusi }}</textarea>
        @error('solusi')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="saran">Saran/Rekomendasi ke Gubernur atau Pusat</label>
        <textarea class="form-control @error('saran') is-invalid @enderror"
                  id="saran"
                  name="saran">{{ $fitur?->saran }}</textarea>
        @error('saran')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <button class="btn btn-primary"
            id="submit"
            type="submit">
        <i class="fa-solid fa-floppy-disk"></i> Update
    </button>
</form>
