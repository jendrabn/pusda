@extends('layouts.admin', ['title' => 'Show User'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Show User</h3>
        </div>
        <div class="card-body">
            <a class="btn btn-default mb-3"
               href="{{ route('admin.users.index') }}">Back to list</a>

            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    </tr>

                    <tr>
                        <th>Email Verified At</th>
                        <td>{{ $user->email_verified_at }}</th>
                    </tr>

                    <tr>
                        <th>SKPD</th>
                        <td>{{ $user->skpd?->nama }}</td>
                    </tr>

                    <tr>
                        <th>No. Handphone</th>
                        <td><a href="https://wa.me/{{ $user->phone }}"
                               target="_blank">{{ $user->phone }}</a></td>
                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->address }}</td>
                    </tr>

                    <tr>
                        <th>Avatar</th>
                        <td>
                            <a href="{{ $user->avatar_url }}"
                               target="_blank">
                                <img src="{{ $user->avatar_url }}"
                                     width="100">
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th>Tgl. Lahir</th>
                        <td>{{ $user->birth_date }}</td>
                    </tr>

                    <tr>
                        <th>Roles</th>
                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge badge-info rounded-0">{{ $role->name }}</span>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ $user->created_at }}</td>
                    </tr>

                    <tr>
                        <th>Updated At</th>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
