<div class="card">
  <div class="card-header">
    <h4>Tambah Menu Tree View</h4>
  </div>
  <div class="card-body">
    <form action="{{ $action }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Kategori</label>
        <select name="parent_id" class="form-control select2" id="category">
          <option value="none" selected disabled hidden>--Pilih Kategori--</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->nama_menu }}</option>
          @endforeach
        </select>
        <div class="custom-control custom-checkbox mt-2">
          <input type="checkbox" class="custom-control-input" id="stay-in-category">
          <label class="custom-control-label" for="stay-in-category">Tetap di kategori ini</label>
        </div>
      </div>
      <div class="form-group">
        <label>Nama Menu <code>*</code></label>
        <input type="text" name="nama_menu" class="form-control" value="{{ request()->old('nama_menu') }}" autofocus>
      </div>
      <div class="form-group d-flex justify-content-between mb-0">
        <small><code>*</code> Wajib diisi</small>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
