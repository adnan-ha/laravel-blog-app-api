@extends('layouts.app')
@section('title', 'Login')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="login_wrapper d-flex justify-content-center align-items-center vh-100">
        <div class="w-75 p-5 border border-primary rounded">
            <h1 class="text-center">Login</h1>
            <form action="{{ route('login') }}" method="POST" class="mt-5">
                @csrf
                <div class="mb-3 row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password">
                    </div>
                </div>
                <input type="submit" value="Login" class="btn btn-primary w-100">
            </form>
        </div>
    </div>
@endsection
