@extends('layouts.mainlayout')

@section('title', 'Deleted Book')

@section('content')

<div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>Deleted Book List</h1>
        <a href="/books" class="btn btn-secondary me-3">Back</a>
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
                    <th>Code</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deletedBooks as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->book_code }}</td>
                    <td>{{ $item->title }}</td>
                    <td>
                        <a href="/book-restore/{{$item->slug}}">Restore</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $deletedBooks->links() }}
    </div>
@endsection