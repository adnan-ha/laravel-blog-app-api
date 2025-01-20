@extends('layouts.app')

@section('title', 'edit-category')

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

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mt-5" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">category name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">choose image:</label>
            <input class="form-control" type="file" id="formFile" name="image">
        </div>
        <input type="submit" value="Edit" class="btn btn-primary w-100">
    </form>

@endsection
