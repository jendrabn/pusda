  <div class="dropdown dropleft">
    <button type="button" class="btn btn-success btn-icon icon-left" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false"><i class="fas fa-file-download"></i>
      Export to Excel</button>
    <div class="dropdown-menu">
      @php
        $exportsFormat = ['xlsx', 'csv', 'xls'];
      @endphp
      @foreach ($exportsFormat as $format)
        <a class="dropdown-item"
          href="{{ route('exports.' . $resource_name, [$table_id, 'format' => $format]) }}">{{ $format }}</a>
      @endforeach
    </div>
  </div>
