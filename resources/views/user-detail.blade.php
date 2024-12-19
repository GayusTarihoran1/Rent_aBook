@extends('layouts.mainlayout')

@section('title', 'Users')

@section('content')
    <h1>Detail User</h1>
    <div class="row">
        <div class="d-flex justify-content-end">
            @if ($user->status =='inactive')
                <a href="/user-approve/{{$user->slug}}" class="btn btn-info">Approve User</a>
                
            @endif
        </div>
    
        <div class="mt-5 ">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    
        <div class="mb-5 w-lg-25 w-md-50 w-sm-50 col-lg-3 col-sm-12">
            <div class="mb-3">
                <label for="" class="form-label">Username</label>
                <input type="text" class="form-control" readonly value="{{$user->username}}">
            </div>
    
            <div class="mb-3">
                <label for="" class="form-label">Phone</label>
                <input type="text" class="form-control" readonly value="{{$user->phone}}">
            </div>
    
            <div class="mb-3">
                <label for="" class="form-label">Address</label>
                <textarea name="" id="" cols="30" rows="7" class="form-control" style="resize: none">{{ $user->address }}</textarea>
            </div>
    
            <div class="mb-3">
                <label for="" class="form-label">Status</label>
                <input type="text" class="form-control" readonly value="{{$user->status}}">
            </div>
        </div>
    
        <div class="col-lg-9 justify-content-end">
            <h2>User's Rent Log</h2>
            <x-rent-log-table :rentlog='$rent_logs' />
        </div>
    </div>
    
@endsection