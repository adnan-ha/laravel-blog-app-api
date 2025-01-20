@extends('layouts.app')

@section('title', 'add-category')

@section('content')

    <h1>Add Category:</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="mt-5" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">category name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">choose image:</label>
            <input class="form-control" type="file" id="formFile" name="category_image">
        </div>
        <input type="submit" value="send" class="btn btn-primary w-50 d-block m-auto">
    </form>

@endsection
