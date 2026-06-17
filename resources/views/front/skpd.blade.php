@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="surface">
            <div class="surface-head">
                <h2>{{ $title }}</h2>
            </div>
            <div class="surface-body">
                <div class="list-group list-group-flush skpd-list">
                    @foreach ($skpds as $skpd)
                        <a class="list-group-item list-group-item-action d-flex align-items-center justify-content-between"
                           href="{{ route('delapankeldata.skpd', $skpd->id) }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge text-bg-primary">{{ $loop->iteration }}</span>
                                <span class="fw-semibold text-dark text-uppercase">{{ $skpd->nama }}</span>
                            </div>
                            <span class="badge text-bg-light text-secondary">Lihat data</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
