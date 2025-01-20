@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('layouts.navbar')
    <div class="content my-3 p-4 rounded-4">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-circle-plus"></i>
            Add User
        </a>
        <table class="users_table table mt-3">
            <thead>
                <tr>
                    <th class="text-danger" scope="col">#</th>
                    <th class="text-danger" scope="col">photo</th>
                    <th class="text-danger" scope="col">Name</th>
                    <th class="text-danger" scope="col">Email</th>
                    <th class="text-danger" scope="col">role</th>
                    <th class="text-danger" scope="col">Block\Unblock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td><img class="user_photo rounded-circle" src="{{ $user->image_url }}" alt="user_photo"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles[0]->name }}</td>
                        <td>
                            @if ($user->is_blocked)
                                <form action="{{ route('users.unblock', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning">unblock</button>
                                </form>
                            @else
                                <form action="{{ route('users.block', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">block</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
