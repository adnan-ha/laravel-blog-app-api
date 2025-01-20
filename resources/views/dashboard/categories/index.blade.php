@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('layouts.navbar')
    <div class="content my-3 p-4 rounded-4">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-circle-plus"></i>
            Add Category
        </a>
        <table class="users_table table mt-3">
            <thead>
                <tr>
                    <th class="text-danger" scope="col">#</th>
                    <th class="text-danger" scope="col">photo</th>
                    <th class="text-danger" scope="col">category</th>
                    <th class="text-danger" scope="col">Update</th>
                    <th class="text-danger" scope="col">delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td><img class="category_img  rounded" src="{{ $category->image_url }}"></td>
                        <td>{{ $category->name }}</td>
                        <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success">update</a></td>
                        <td>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
