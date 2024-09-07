@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header card-header__lg bg-white">
                <h4 class="card-header__title">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <ol>
                    @foreach ($skpds as $skpd)
                        <li>
                            <a class="text-decoration-none"
                               href="{{ route('delapankeldata.skpd', $skpd->id) }}">{{ $skpd->nama }}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
