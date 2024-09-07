<div class="modal fade"
     data-backdrop="static"
     id="modal-edit"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Uraian {{ $tabel->nama_menu }}</h5>
                <button class="close"
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
                                   for="parent_id">Kategori</label>
                            <select class="custom-select"
                                    id="parent_id"
                                    name="parent_id">
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="uraian">Uraian</label>
                            <input class="form-control"
                                   name="uraian"
                                   type="text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                data-dismiss="modal"
                                type="button">Close</button>
                        <button class="btn btn-primary"
                                type="submit">
                            <i class="fa-solid fa-floppy-disk"></i> Update
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
