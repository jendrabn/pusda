@extends('layouts.admin')

@section('title', 'Audit Log')

@section('content')
  <div class="card">
    <div class="card-header text-uppercase">
      Show Audit Logs
    </div>

    <div class="card-body">
      <div class="form-group">
        <div class="form-group">
          <a class="btn btn-default" href="{{ route('admin.audit-logs.index') }}">
            Back to list
          </a>
        </div>
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <th>
                ID
              </th>
              <td>
                {{ $auditLog->id }}
              </td>
            </tr>
            <tr>
              <th>
                Description
              </th>
              <td>
                {{ $auditLog->description }}
              </td>
            </tr>
            <tr>
              <th>
                Subject ID
              </th>
              <td>
                {{ $auditLog->subject_id }}
              </td>
            </tr>
            <tr>
              <th>
                Subject Type
              </th>
              <td>
                {{ $auditLog->subject_type }}
              </td>
            </tr>
            <tr>
              <th>
                User ID
              </th>
              <td>
                {{ $auditLog->user_id }}
              </td>
            </tr>
            <tr>
              <th>
                Properties
              </th>
              <td>
                {{ $auditLog->properties }}
              </td>
            </tr>
            <tr>
              <th>
                Host
              </th>
              <td>
                {{ $auditLog->host }}
              </td>
            </tr>
            <tr>
              <th>
                Created at
              </th>
              <td>
                {{ $auditLog->created_at }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="form-group">
          <a class="btn btn-default" href="{{ route('admin.audit-logs.index') }}">
            Back to list
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
