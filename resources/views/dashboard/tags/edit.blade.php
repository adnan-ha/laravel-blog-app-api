@extends('layouts.app')

@section('title', 'edit-tag')

@section('content')

    <h1>Edit Tag:</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tags.update', $tag->id) }}" method="POST" class="mt-5">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="tag" class="form-label">tag name:</label>
            <input type="text" class="form-control" id="tag" name="tag" value="{{ $tag->name }}">
        </div>
        <input type="submit" value="edit" class="btn btn-primary w-50 d-block m-auto">
    </form>

@endsection
