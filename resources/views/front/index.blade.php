@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="surface">
            <div class="surface-head">
                <h2>{{ $title }}</h2>
            </div>
            <div class="surface-body">
                <div class="accordion front-tree-accordion"
                     id="frontTreeAccordion">
                    @foreach ($categories as $category)
                        @php
                            $collapseId = 'frontTreeCollapse' . $loop->index;
                            $headingId = 'frontTreeHeading' . $loop->index;
                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header"
                                id="{{ $headingId }}">
                                <button aria-controls="{{ $collapseId }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                        data-bs-target="#{{ $collapseId }}"
                                        data-bs-toggle="collapse"
                                        type="button">
                                    <span class="badge text-bg-primary me-2">{{ $loop->iteration }}</span>
                                    <span class="fw-semibold">{{ $category->nama_menu }}</span>
                                </button>
                            </h2>
                            <div aria-labelledby="{{ $headingId }}"
                                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                 data-bs-parent="#frontTreeAccordion"
                                 id="{{ $collapseId }}">
                                <div class="accordion-body">
                                    @if ($category->childs->count())
                                        <div class="list-group list-group-flush">
                                            @foreach ($category->childs as $child)
                                                <div class="list-group-item">
                                                    <div
                                                         class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                        <div class="fw-semibold text-dark">{{ $child->nama_menu }}</div>
                                                        <span class="badge text-bg-light text-secondary">Sub menu</span>
                                                    </div>
                                                    @if ($child->childs->count())
                                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                                            @foreach ($child->childs as $grandchild)
                                                                <a class="btn btn-outline-primary btn-sm"
                                                                   href="{{ route($routePart . '.tabel', $grandchild->id) }}">{{ $grandchild->nama_menu }}</a>
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
