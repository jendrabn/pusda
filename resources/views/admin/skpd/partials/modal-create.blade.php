<div class="modal fade"
     data-backdrop="static"
     id="modal-create"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">Create SKPD</h5>
                <button aria-label="Close"
                        class="close"
                        data-dismiss="modal"
                        type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <fieldset>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required"
                                   for="_kategori_skpd_id">Kategori</label>
                            <select autofocus
                                    class="custom-select @error('kategori_skpd_id') is-invalid @enderror"
                                    id="_kategori_skpd_id"
                                    name="kategori_skpd_id">
                                @foreach ($kategori as $id => $nama)
                                    <option @selected($id == old('kategori_skpd_id'))
                                            value="{{ $id }}">
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_skpd_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_nama">Nama</label>
                            <input class="form-control @error('nama') is-invalid @enderror"
                                   id="_nama"
                                   name="nama"
                                   type="text"
                                   value="{{ old('nama') }}" />
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_singkatan">Singkatan</label>
                            <input class="form-control @error('singkatan') is-invalid @enderror"
                                   id="_singkatan"
                                   name="singkatan"
                                   type="text"
                                   value="{{ old('singkatan') }}" />
                            @error('singkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                data-dismiss="modal"
                                type="button">Close</button>
                        <button class="btn btn-primary"
                                type="submit">
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
