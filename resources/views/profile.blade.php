@extends('layouts.mainlayout')

@section('title', 'Profile')

@section('content')
    <div>
        <div class="row">
            <!-- Kolom Profil Pengguna -->
            <div class="col-lg-4 col-md-12">
                <h2 class="mb-5">Hi, {{ $user->username }}!</h2>
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

            <!-- Kolom Rent Log -->
            <div class="col-lg-8 col-md-12">
                <h2 style="margin-left: 55px ">Your Rent Log</h2>
                <x-rent-log-table :rentlog='$rent_logs' />
            </div>
        </div>
    </div>
@endsection
