@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('layouts.navbar')
    <div class="content my-3 p-4 rounded-4">
        <a href="{{ route('tags.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-circle-plus"></i>
            Add Tag
        </a>

        <table class="users_table table mt-3">
            <thead>
                <tr>
                    <th class="text-danger" scope="col">#</th>
                    <th class="text-danger" scope="col">Tag_Name</th>
                    <th class="text-danger" scope="col">Update</th>
                    <th class="text-danger" scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <th scope="row">{{ $tag->id }}</th>
                        <td>{{ $tag->name }}</td>
                        <td><a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-success">update</a></td>
                        <td>
                            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
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
