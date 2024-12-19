@extends('layouts.mainlayout')

@section('title', 'Profile')

@section('content')
    <div>
        <h2 class="mb-5">Hi, {{ $user->username }}!</h2>
        <div class="row">
            <!-- Kolom Profil Pengguna -->
            <div class="col-lg-3 col-md-12">
                <div class="mb-5">
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
            </div>
            <div class="col-lg-1"></div>
            <!-- Kolom Rent Log -->
            <div class="col-lg-8 col-md-12">
                <h4>Your Rent Log</h4>
                <x-rent-log-table :rentlog='$rent_logs' />
            </div>
        </div>
    </div>
@endsection
