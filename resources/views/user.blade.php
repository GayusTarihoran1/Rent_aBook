@extends('layouts.mainlayout')

@section('title', 'Users')

@section('content')

    <div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>User List</h1>
        <div>
            <a href="/user-banned" class="btn btn-secondary me-3">View Banned User</a>
            <a href="registered-users" class="btn btn-primary">Registered User</a>
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
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($user->currentPage() - 1) * $user->perPage() }}</td>
                        <td>{{ $item->username }}</td>
                        <td>
                            @if ($item->phone)
                                {{ $item->phone }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="/user-detail/{{$item->slug}}" class="btn btn-success">Detail</a>
                            <a href="/user-ban/{{$item->slug}}" class="btn btn-danger">Banned</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $user->links() }}
        </div>
    </div>

@endsection
