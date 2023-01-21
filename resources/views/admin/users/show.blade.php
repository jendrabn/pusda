@extends('layouts.admin', ['title' => 'Show User'])

@section('content')
  <div class="card">
    <div class="card-header">
      Show User
    </div>

    <div class="card-body">
      <div class="form-group">
        <div class="form-group">
          <a class="btn btn-default" href="{{ route('admin.users.index') }}">
            Back to list
          </a>
        </div>
        <table class="table-bordered table-striped table">
          <tbody>
            <tr>
              <th>
                Foto Profil
              </th>
              <td>
                <img src="{{ $user->photo_url }}" alt="Foto User" width="150px" height="150px">
              </td>
            </tr>
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
                SKPD
              </th>
              <td>
                {{ $user->skpd->nama }}
              </td>
            </tr>
            <tr>
              <th>
                Nama
              </th>
              <td>
                {{ $user->name }}
              </td>
            </tr>
            <tr>
              <th>
                Username
              </th>
              <td>
                {{ $user->username }}
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
                No. HP
              </th>
              <td>
                {{ $user->phone }}
              </td>
            </tr>
            <tr>
              <th>
                Alamat
              </th>
              <td>
                {{ $user->address }}
              </td>
            </tr>
            <tr>
              <th>
                Role
              </th>
              <td>
                {{ $user->role_name }}
              </td>
            </tr>
            <tr>
              <th>
                Email verified at
              </th>
              <td>
                {{ $user->email_verified_at }}
              </td>
            </tr>
            <tr>
              <th>
                Created at
              </th>
              <td>
                {{ $user->created_at }}
              </td>
            </tr>
            <tr>
              <th>
                Updated at
              </th>
              <td>
                {{ $user->updated_at }}
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
