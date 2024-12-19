@extends('layouts.mainlayout')

@section('title', 'Category')

@section('content')

    <div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>Category List</h1>
        <div>
            <a href="category-deleted" class="btn btn-secondary me-3">View Deleted Data</a>
            <a href="category-add" class="btn btn-primary">Add Data</a>
        </div>
    </div>

    <div class="mt-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="my-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $item)
                <tr>
                    <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="category-edit/{{$item->slug}}" class="btn btn-success">Edit</a>
                        <a href="category-delete/{{$item->slug}}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection