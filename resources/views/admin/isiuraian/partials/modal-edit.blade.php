<div class="modal fade" id="modal-edit" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ $action }}" id="form-edit" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="uraian_id">
          <input type="hidden" name="parent_id">

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right">Uraian <code>*</code></label>
            <div class="col-sm-10">
              <input type="text" name="uraian" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-md-right">Satuan <code>*</code></label>
            <div class="col-sm-10">
              <input type="text" name="satuan" class="form-control">
            </div>
          </div>

          @isset($showKetersediaanData)
            @if ($showKetersediaanData === true)
              <div class="form-group row">
                <label class="col-sm-2 col-form-label text-md-right">Ketersedian Data<code>*</code></label>
                <div class="col-sm-10">
                  <select name="ketersediaan_data" class="form-control">
                    <option value="none" selected disabled hidden>--Silahkan Pilih--</option>
                    <option value="1">Tesedia</option>
                    <option value="0">Tidak Tersedia</option>
                  </select>
                </div>
              </div>
            @endif
          @endisset
          <div class="form-group row">
              <label class="col-sm-2 col-form-label text-md-right">Tahun <code>*</code></label>
              <div class="col-sm-10">
                <select name="tahun" class="form-control">
                  @foreach ($years as $index => $year)
                    <option value="none" selected disabled hidden>--Silahkan Pilih--</option>
                    <option value="{{$year}}">{{$year}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          <div class="form-group row">
              <label class="col-sm-2 col-form-label text-md-right">isi <code>*</code></label>
              <div class="col-sm-10">
                <input type="text" name="isi" class="form-control">
              </div>
            </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <p><code>*</code> Wajib diisi</p>
        <div>
          <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>
