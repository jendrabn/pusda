<div class="row mb-3">
    <div class="col-12 col-lg-4">
        <form action="{{ route('admin.' . $routePart . '.files.store', [$tabel->id, 'tab' => 'file-pendukung']) }}"
              enctype="multipart/form-data"
              method="POST">
            @csrf

            <form>
                <div class="form-group">
                    <label class="required"
                           for="file_pendukung">File Pendukung</label>
                    <div class="input-group @error('file_pendukung') is-invalid @enderror">
                        <input class="form-control border-0"
                               id="file_pendukung"
                               multiple
                               name="file_pendukung[]"
                               type="file" />
                        <div class="input-group-append">
                            <button class="btn btn-primary"
                                    type="submit">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                        </div>
                    </div>

                    @error('file_pendukung')
                        <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table class="table-bordered table-striped table-hover datatable dataTable-FilePendukung table table-sm w-100">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th class="text-left">ID</th>
                    <th>Nama File</th>
                    <th>Ukuran File</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td></td>
                        <td class="text-left">{{ $file->id }}</td>
                        <td>{{ $file->nama }}</td>
                        <td>{{ round($file->size / 1024, 2) }} KB</td>
                        <td>{{ $file->created_at }}</td>
                        <td>{{ $file->updated_at }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a class="btn btn-xs btn-success"
                                   href="{{ route('admin.' . $routePart . '.files.download', $file->id) }}">Download</a>
                                <button class="btn btn-xs btn-danger btn-delete"
                                        data-url="{{ route('admin.' . $routePart . '.files.destroy', [$file->id, 'tab' => 'file-pendukung']) }}">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
