@extends('layouts.mainlayout')

@section('title', 'Add Category')

@section('page-name', 'Add Category')

@section('content')

<div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>Add New Category</h1>
        <a href="categories" class="btn btn-secondary me-3">Back</a>
    </div>

    <div class="mt-5 w-50">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="list-style-type: none;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="category-add" method="post">
            @csrf
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Category Name">
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>
@endsection