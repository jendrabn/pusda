<div class="modal fade" id="modal-file-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Upload File Pendukung</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-light">
            <ul class="m-0">
              <li>Format file berupa pdf, doc, docx, xlsx, xls, csv</li>
              <li>Ukuran file maksimal 10 mb</li>
            </ul>
          </div>
          @csrf
          <div class="form-group">
            <input type="file" name="file_document" class="form-control">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke text-right">
          <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
