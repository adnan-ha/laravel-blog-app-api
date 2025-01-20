@extends('layouts.app')

@section('title', 'add-tag')

@section('content')

    <h1>Add Tag:</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tags.store') }}" method="POST" class="mt-5">
        @csrf
        <div class="mb-3">
            <label for="tag" class="form-label">tag name:</label>
            <input type="text" class="form-control" id="tag" name="tag">
        </div>
        <input type="submit" value="send" class="btn btn-primary w-50 d-block m-auto">
    </form>

@endsection
