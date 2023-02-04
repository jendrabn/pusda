<div class="row">
  <div class="col-lg-7">
    <form
      action="@admin{{ route('admin.' . $crudRoutePart . '.files.store', $tabel->id) }}@endadmin @skpd{{ route('admin_skpd.' . $crudRoutePart . '.files.store', $tabel->id) }}@endskpd"
      method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="required" for="document">File Pendukung</label>
        <div class="custom-file">
          <input class="custom-file-input @error('document') is-invalid @enderror" id="document" name="document"
            type="file">
          <label class="custom-file-label" for="document">
            Choose File
          </label>
          @error('document')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<table class="table-bordered table-striped table-hover ajaxTable datatable datatable-filependukung table">
  <thead>
    <tr>
      <th width="10"></th>
      <th>ID</th>
      <th>Nama File</th>
      <th>Created at</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($files as $file)
      <tr>
        <td>&nbsp;</td>
        <td>{{ $file->id }}</td>
        <td>{{ $file->nama }}</td>
        <td>{{ $file->created_at }}</td>
        <td>
          @admin
            <a class="btn btn-xs btn-success"
              href="{{ route('admin.' . $crudRoutePart . '.files.download', $file->id) }}">Download</a>
            <form style="display: inline-block;"
              action="{{ route('admin.' . $crudRoutePart . '.files.destroy', $file->id) }}" method="POST"
              onsubmit="return confirm('Are You Sure?');">
              @method('DELETE')
              @csrf
              <input class="btn btn-xs btn-danger" type="submit" value="Delete">
            </form>
          @endadmin
          @skpd
            <a class="btn btn-xs btn-success"
              href="{{ route('admin_skpd.' . $crudRoutePart . '.files.download', $file->id) }}">Download</a>
            <form style="display: inline-block;"
              action="{{ route('admin_skpd.' . $crudRoutePart . '.files.destroy', $file->id) }}" method="POST"
              onsubmit="return confirm('Are You Sure?');">
              @method('DELETE')
              @csrf
              <input class="btn btn-xs btn-danger" type="submit" value="Delete">
            </form>
          @endskpd
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
