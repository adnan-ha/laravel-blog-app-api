@extends('layouts.app')

@section('title', 'edit-user')

@section('content')

    <h1>Edit User:</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="mt-5 row g-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>
        <div class="mb-3 col-md-6">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3 col-md-6">
            <label for="password_confirmation" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="role">Role:</label>
            <select class="form-select" id="role" name="role">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" @if ($user->roles[0]->name == $role->name) selected @endif>
                        {{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 col-md-6">
            <label for="formFile" class="form-label">choose photo:</label>
            <input class="form-control" type="file" id="formFile" name="photo">
        </div>
        <input type="submit" value="Edit" class="btn btn-primary w-100">
    </form>

@endsection
