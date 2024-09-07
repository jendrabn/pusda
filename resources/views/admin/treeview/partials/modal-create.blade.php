<div aria-hidden="true"
     aria-labelledby="exampleModalLabel"
     class="modal fade"
     data-backdrop="static"
     id="modal-create"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">Create Menu</h5>
                <button aria-label="Close"
                        class="close"
                        data-dismiss="modal"
                        type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.treeview.' . $routePart . '.store') }}"
                  id="form-create"
                  method="POST">
                @csrf
                <fieldset>
                    <div class="modal-body">

                        @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                            <div class="form-group">
                                <label class="required"
                                       for="skpd_id">SKPD</label>
                                <select class="custom-select @error('skpd_id') is-invalid @enderror"
                                        id="category"
                                        name="skpd_id">
                                    <option value="">---</option>
                                    @foreach ($skpds as $id => $singkatan)
                                        <option @selected($id == auth()->user()->skpd_id)
                                                value="{{ $id }}">{{ $singkatan }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="required"
                                   for="parent_id">Parent</label>
                            <select class="custom-select @error('parent_id') is-invalid @enderror"
                                    id="category"
                                    name="parent_id">
                                <option selected
                                        value="">---</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_menu }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="nama_menu">Nama Menu</label>
                            <input class="form-control @error('nama_menu') is-invalid @enderror"
                                   name="nama_menu"
                                   type="text"
                                   value="{{ old('nama_menu') }}" />
                            @error('nama_menu')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                data-dismiss="modal"
                                type="button">Close</button>
                        <button class="btn btn-primary"
                                type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
