@extends('layouts.admin', ['title' => 'Show User'])

@section('content')
  <div class="card">
    <div class="card-header">
      Show User
    </div>
    <div class="card-body">
      <div class="form-group">
        <a class="btn btn-default btn-flat"
          href="{{ route('admin.users.index') }}">
          Back to list
        </a>
      </div>
      <table class="table-bordered table-striped table table-sm">
        <tbody>
          <tr>
            <th>
              Foto
            </th>
            <td>
              <img class="img-fluid"
                src="{{ $user->photo }}"
                alt="User Photo"
                style="max-width: 100px;" />
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
              <a href="mailto:{{ $user->email }}"> {{ $user->email }}</a>
            </td>
          </tr>
          <tr>
            <th>
              No. Handphone
            </th>
            <td>
              <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}">{{ $user->phone }}</a>
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
              {{ $user->role }}
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
        </tbody>
      </table>
    </div>
  </div>
@endsection
