@extends('layouts.admin')

@section('content')
  @include('partials.menuTreeIsiUraian')

  <div class="card card-outline card-tabs">
    <div class="card-header border-bottom-0 p-0 pt-1">
      <ul class="nav nav-tabs" id="tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tabel-tab" data-toggle="pill" href="#tabel" role="tab" aria-controls="tabel"
             aria-selected="true">Tabel {{ $title }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="fitur-tab" data-toggle="pill" href="#fitur" role="tab" aria-controls="fitur"
             aria-selected="false">Fitur {{ $title }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="file-tab" data-toggle="pill" href="#file" role="tab" aria-controls="file"
             aria-selected="false">File Pendukung
            {{ $title }}</a>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <div class="tab-content" id="tabContent">
        <div class="tab-pane fade active show" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">
          <div class="d-flex mb-2">
            <button class="btn btn-primary btn-flat mr-2" data-toggle="modal" data-target="#modalTahun" type="button">
              <i class="fas fa-calendar-alt"></i> Pengaturan Tahun
            </button>
            <button class="btn btn-success btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" type="button">
              <i class="fas fa-file-download"></i> Exports
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item"
                 href="{{ route('exports.' . $crudRoutePart, [$tabel->id, 'format' => 'csv']) }}">CSV</a>
              <a class="dropdown-item"
                 href="{{ route('exports.' . $crudRoutePart, [$tabel->id, 'format' => 'xls']) }}">XLS</a>
              <a class="dropdown-item"
                 href="{{ route('exports.' . $crudRoutePart, [$tabel->id, 'format' => 'xlsx']) }}">XLSX</a>
            </div>
          </div>
          <table class="table-bordered table-striped table-hover datatable w-100 table" id="table__isiUraian">
            <thead>
              <tr>
                <th>#</th>
                <th class="text-danger">Uraian</th>
                <th>Satuan</th>
                <th>Ketersedian Data</th>
                @foreach ($tahuns as $tahun)
                  <th>
                    {{ $tahun }}
                  </th>
                @endforeach
                <th>Sumber Data</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($uraians as $index => $uraian)
                <tr>
                  <td>
                    @if ($uraian->parent_id == null)
                      {{ ++$index }}
                    @endif
                  </td>
                  <td><span class="text-danger">{{ $uraian->uraian }}</span> </td>
                  <td>{{ $uraian->satuan }}</td>
                  <td>{{ $uraian->ketersediaan_data }}</td>
                  @foreach ($tahuns as $tahun)
                    <th>&nbsp;</th>
                  @endforeach
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                @foreach ($uraian->childs as $child)
                  <tr>
                    <td>&nbsp;</td>
                    <td><span class="text-danger d-block" style="text-indent: 1.5rem;">{{ $child->uraian }}</span></td>
                    <td>{{ $child->satuan }}</td>
                    <td>{{ $child->ketersediaan_data === true ? 'Tersedia' : 'Tidak Tersedia' }}</td>
                    @foreach ($tahuns as $tahun)
                      <td>{{ $child->isi8KelData->where('tahun', $tahun)->first()->isi }}</td>
                    @endforeach
                    <td style="max-width: 200px;">
                      <select class="form-control sumber__data" name="sumber_data" data-id="{{ $child->id }}">
                        <option selected disabled hidden>Please Select</option>
                        @foreach ($skpds as $id => $singkatan)
                          <option value="{{ $id }}" @if ($id == $child->skpd_id) selected @endif>
                            {{ $singkatan }}
                          </option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <button class="btn btn-primary btn-xs btn__graphic" data-id="{{ $child->id }}">Grafik</button>
                      <a class="btn btn-xs btn-info" href="{{ route('admin.delapankeldata.edit', $child->id) }}">Edit</a>
                      <form style="display: inline-block;"
                            action="{{ route('admin.delapankeldata.destroy', $child->id) }}" method="POST"
                            onsubmit="return confirm('Are You Sure?');">
                        @method('DELETE')
                        @csrf
                        <input class="btn btn-xs btn-danger" type="submit" value="Delete">
                      </form>
                    </td>
                  </tr>
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="fitur" role="tabpanel" aria-labelledby="fitur-tab">
          <form action="{{ route('admin.' . $crudRoutePart . '.update_fitur', $fitur->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <textarea class="form-control rounded-0" id="deskripsi" name="deskripsi">{{ $fitur->deskripsi }}</textarea>
            </div>
            <div class="form-group">
              <label for="analisis">Analisis</label>
              <textarea class="form-control rounded-0" id="analisis" name="analisis">{{ $fitur->analisis }}</textarea>
            </div>
            <div class="form-group">
              <label for="permasalahan">Permasalahan</label>
              <textarea class="form-control rounded-0" id="permasalahan" name="permasalahan">{{ $fitur->permasalahan }}</textarea>
            </div>
            <div class="form-group">
              <label for="solusi">Solusi atau Langkah-langkah Tindak Lanjut</label>
              <textarea class="form-control rounded-0" id="solusi" name="solusi">{{ $fitur->solusi }}</textarea>
            </div>
            <div class="form-group">
              <label for="saran">Saran / Rekomendasi ke Gubernur atau Pusat</label>
              <textarea class="form-control rounded-0" id="saran" name="saran">{{ $fitur->saran }}</textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-danger" id="submit" type="submit">Update</button>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab">
          <div class="mb-3 border p-3">
            <form action="{{ route('admin.' . $crudRoutePart . '.files.store', $tabel->id) }}" method="POST"
                  enctype="multipart/form-data">
              @csrf

              <div class="custom-file">
                <input class="custom-file-input {{ $errors->has('file_document') ? 'is-invalid' : '' }}"
                       id="file_document" name="file_document" type="file">
                <label class="custom-file-label" for="file_document">
                  Tambah File Pendukung {{ $title }}
                </label>
                @if ($errors->has('file_document'))
                  <span class="text-danger">{{ $errors->first('file_document') }}</span>
                @endif
                <span class="help-block">Maks 25MB</span>
              </div>
              <div class="form-group mt-3 mb-0">
                <button class="btn btn-danger" type="submit">Save</button>
              </div>
            </form>
          </div>

          <table class="table-bordered table-striped table-hover table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama File</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($files as $file)
                <tr>
                  <td>{{ $file->id }}</td>
                  <td>{{ str_replace('files/', '', $file->file_name) }}</td>
                  <td>
                    <a class="btn btn-xs btn-success"
                       href="{{ route('admin.delapankeldata.files.download', $file->id) }}">Download</a>
                    <form style="display: inline-block;"
                          action="{{ route('admin.delapankeldata.files.destroy', $file->id) }}" method="POST"
                          onsubmit="return confirm('Are You Sure?');">
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
      </div>
    </div>
  </div>

  <div class="modal fade show" id="modal__chart" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Grafik</h4>
          <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="container__chart">
          <canvas id="chart__isiUraian" width="100%" height="100%"></canvas>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default mr-2" data-dismiss="modal" type="button">Close</button>
          <button class="btn btn-success" id="btn__chartDownload" type="button">
            <i class="fas fa-download"></i> Download
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade show" id="modalTahun" role="dialog" aria-modal="true">
    <div class="modal-dialog">
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
            <div class="form-group mb-3">
              <label for="tahun">Tambah Tahun</label>
              <select class="form-control select2" id="tahun" name="tahun[]" style="width: 100%"
                      multiple="multiple">
                @php
                  $tahunOptions = array_filter(range(2015, 2025), function ($year) use ($tahuns) {
                      return !in_array($year, $tahuns->toArray());
                  });
                @endphp
                @foreach ($tahunOptions as $tahun)
                  <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-danger" type="submit">Save</button>
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
              @foreach ($tahuns as $tahunear)
                <tr>
                  <td>{{ $tahunear }}</td>
                  <td>
                    <form style="display: inline-block;"
                          action="{{ route('admin.' . $crudRoutePart . '.destroy_tahun', [$tabel->id, $tahunear]) }}"
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
        <div class="modal-footer justify-content-between">
          <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
        </div>
      </div>
    </div>
  </div>

  <form id="form__updateSumberData" action="" method="POST" hidden>
    @csrf
    @method('PUT')
    <input name="sumber_data" type="text">
  </form>
@endsection

@section('scripts')
  @parent
  <script>
    $(function() {

      $('#tab a').click(function(e) {
        e.preventDefault()
        $(this).tab('show')
      })

      $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
        let id = $(e.target).attr("href").substr(1)
        window.location.hash = id
      })

      let hash = window.location.hash
      $('#tab a[href="' + hash + '"]').tab('show')

      $('#table__isiUraian').DataTable({
        ordering: false,
        columnDefs: [],
        buttons: []
      })

      $("#table__isiUraian").on("change", "select.sumber__data", function(e) {
        const form = $("#form__updateSumberData")
        form.prop('action', "{{ route('admin.delapankeldata.updateSumberData') }}/" + $(this).data('id'))
        form.find("input[name=sumber_data]").val(e.target.value)
        form.submit()
      })

      $("#btn__chartDownload").on("click", function() {
        const canvas = $("#chart__isiUraian")[0];
        const image = canvas.toDataURL("image/jpg").replace("image/jpg", "image/octet-stream");
        const link = document.createElement("a");
        link.download = Date.now() + ".jpg";
        link.href = image;
        link.click();
      });

      $("#table__isiUraian").on("click", "tbody .btn__graphic", function(e) {

        $.get("{{ route('admin.delapankeldata.graphic') }}/" + $(this).data('id'))
          .done(function(res) {
            let {
              isi,
              uraian
            } = res;

            $("#chart__isiUraian").remove();
            $("#container__chart").append('<canvas id="chart__isiUraian" width="100%" height="100%"></canvas>');

            const context = document.getElementById("chart__isiUraian");
            const chart = new Chart(context, {
              type: "bar",
              data: {
                labels: isi.map(val => val.tahun).reverse(),
                datasets: [{
                  label: uraian,
                  data: isi.map(val => val.isi).reverse(),
                  borderWidth: 1,
                }, ],
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true,
                    },
                  }, ],
                },
              },
            });
            $("#modal__chart").modal("show");
          })
          .fail(function(err) {

          })
      });
    })
  </script>
@endsection
