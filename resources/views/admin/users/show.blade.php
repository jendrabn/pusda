@extends('layouts.admin')


@section('title', 'Show User')

@section('content')
  <div class="card">
    <div class="card-header">
      Show Users
    </div>

    <div class="card-body">
      <div class="form-group">
        <div class="form-group">
          <a class="btn btn-default" href="{{ route('admin.users.index') }}">
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
                {{ $user->id }}
              </td>
            </tr>
            <tr>
              <th>
                Name
              </th>
              <td>
                {{ $user->name }}
              </td>
            </tr>
            <tr>
              <th>
                Email
              </th>
              <td>
                {{ $user->email }}
              </td>
            </tr>
            <tr>
              <th>
                Role
              </th>
              <td>
                {{ $user->role }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="form-group">
          <a class="btn btn-default" href="{{ route('admin.users.index') }}">
            Back to list
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
