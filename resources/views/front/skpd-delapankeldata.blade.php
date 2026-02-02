@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="surface">
            <div class="surface-head">
                <span class="section-eyebrow">Data</span>
                <h2>{{ $title }}</h2>
            </div>
            <div class="surface-body">
                <div class="accordion front-tree-accordion" id="frontSkpdTreeAccordion">
                    @foreach ($categories as $category)
                        @php
                            $collapseId = 'frontSkpdTreeCollapse' . $loop->index;
                            $headingId = 'frontSkpdTreeHeading' . $loop->index;
                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{ $headingId }}">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="{{ $collapseId }}">
                                    <span class="badge text-bg-primary me-2">{{ $loop->iteration }}</span>
                                    <span class="fw-semibold">{{ $category->nama_menu }}</span>
                                </button>
                            </h2>
                            <div id="{{ $collapseId }}"
                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                aria-labelledby="{{ $headingId }}" data-bs-parent="#frontSkpdTreeAccordion">
                                <div class="accordion-body">
                                    @if ($category->childs->count())
                                        <div class="list-group list-group-flush">
                                            @foreach ($category->childs as $child)
                                                <div class="list-group-item">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                        <div class="fw-semibold text-dark">{{ $child->nama_menu }}</div>
                                                        <span class="badge text-bg-light text-secondary">Sub menu</span>
                                                    </div>
                                                    @if ($child->childs->count())
                                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                                            @foreach ($child->childs as $grandchild)
                                                                @foreach ($tabel8KelDataIds as $table)
                                                                    @if ($table->id == $grandchild->id)
                                                                        <a class="btn btn-outline-primary btn-sm"
                                                                            @if (isset($tabel8KelData) && $tabel8KelData->id == $table->id) data-jstree='{ "selected" : true }' @endif
                                                                            href="{{ route('delapankeldata.tabel', $grandchild->id) }}">{{ $grandchild->nama_menu }}</a>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-muted">Belum ada data.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
