@extends('layouts.admin', ['title' => 'Audit Logs'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Audit Log List</h3>
        </div>

        <div class="card-body">
            {{ $dataTable->table(['class' => 'table-bordered table-striped table-hover ajaxTable datatable datatable-AuditLog table table-sm']) }}
        </div>
    </div>
@endsection

@section('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'text/javascript']) }}
@endsection
