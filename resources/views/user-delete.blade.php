@extends('layouts.mainlayout')

@section('title', 'Ban User')

@section('content')
    <h2>Are you sure to banned user {{$user->username}}?</h2>
    <div class="mt-5">
        <a href="/user-destroy/{{$user->slug}}" class="btn btn-danger me-5">Sure</a>
        <a href="/users" class="btn btn-secondary">Cancel</a>
    </div>
@endsection