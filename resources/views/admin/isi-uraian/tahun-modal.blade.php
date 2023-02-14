<div class="modal fade show" id="modalTahun" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pengaturan Tahun</h4>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.' . $crudRoutePart . '.store_tahun', $tabel->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="required" for="tahun">Tambah Tahun</label>
            <input class="form-control @error('tahun') is-invalid @enderror input-tahun" id="date" name="tahun"
              type="number" min="2010" max="2030" placeholder="YYYY">
            @error('tahun')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit"> <i class="fas fa-save"></i> Simpan</button>
          </div>
        </form>
        <table class="table-bordered table-striped table-hover table-sm table">
          <thead>
            <tr>
              <th>Tahun</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tahuns as $tahun)
              <tr>
                <td>{{ $tahun }}</td>
                <td>
                  <form class="form-row"
                    action="{{ route('admin.' . $crudRoutePart . '.destroy_tahun', [$tabel->id, $tahun]) }}"
                    method="POST" onsubmit="return confirm('Are You Sure?');">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-xs btn-danger" type="submit" value="Delete">
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fas fa-times"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>
