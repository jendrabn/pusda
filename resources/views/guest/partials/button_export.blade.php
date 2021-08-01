  <div class="dropdown">
    <button class="btn btn-success btn-icon-left" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
        class="fas fa-file-download"></i>
      Export to Excel
    </button>
    <div class="dropdown-menu">
      @php
        $exportsFormat = ['xlsx', 'csv', 'xls'];
      @endphp
      @foreach ($exportsFormat as $format)
        <a class="dropdown-item"
          href="{{ route('exports.' . $resourceName, [$id, 'format' => $format]) }}">{{ $format }}</a>
      @endforeach
    </div>
  </div>
