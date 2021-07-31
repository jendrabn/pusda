<div class="modal fade" tabindex="-1" role="dialog" id="modal-add-year" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pengaturan Tahun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.' . $resource_name . '.store_tahun', $tabel_id) }}" method="POST">
          @csrf
          <div class="form-group mb-3">
            <label for="tahun">Tambah Tahun</label>
            <select name="tahun[]" id="tahun" class="form-control" multiple="multiple">
              @php
                $yearOptions = array_filter(range(2015, 2030), function ($year) use ($years) {
                    return !in_array($year, $years->toArray());
                });
              @endphp
              @foreach ($yearOptions as $year)
                <option value="{{ $year }}">{{ $year }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Simpan</button>
          </div>
        </form>
        <div class="table-responsive">
          <table class="table table-sm table-light table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($years as $index => $year)
                <tr>
                  <td>{{ ++$index }}</td>
                  <td>{{ $year }}</td>
                  <th>
                    <button data-url="{{ route('admin.' . $resource_name . '.destroy_tahun', [$tabel_id, $year]) }}"
                      class="btn btn-icon btn-sm btn-danger hapus-tahun">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </th>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
