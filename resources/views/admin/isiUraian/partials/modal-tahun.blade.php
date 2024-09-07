<div class="modal fade"
     id="modal-tahun"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengaturan Tahun</h5>
                <button class="close"
                        data-dismiss="modal"
                        type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-sm table-tahun">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tahun</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tahuns as $tahun)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tahun }}</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-danger btn-delete"
                                            data-url="{{ route('admin.' . $routePart . '.destroy_tahun', [$tabel->id, $tahun]) }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="{{ route('admin.' . $routePart . '.store_tahun', $tabel->id) }}"
                      method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="required"
                               for="tahun">Tambah Tahun</label>
                        <div class="input-group">
                            <input class="form-control @error('tahun') is-invalid @enderror tahun"
                                   id="date"
                                   max="2030"
                                   min="2017"
                                   name="tahun"
                                   placeholder="YYYY"
                                   step="1"
                                   type="number"
                                   value="{{ old('tahun', date('Y')) }}" />

                            <div class="input-group-append">
                                <button class="btn btn-primary"
                                        type="submit">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                                </button>
                            </div>
                        </div>
                        @error('tahun')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary"
                        data-dismiss="modal"
                        type="button">
                    <i class="fa-solid fa-xmark"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
