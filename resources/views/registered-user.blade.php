@extends('layouts.mainlayout')

@section('title', 'Users')

@section('content')

<div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>New Registered User List</h1>
        <a href="/users" class="btn btn-primary">Approved User List</a>
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
                @foreach ($registeredUsers as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->username }}</td>
                        <td>
                            @if ($item->phone)
                                {{ $item->phone }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="/user-detail/{{$item->slug}}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $registeredUsers->links() }}
        </div>
    </div>
@endsection