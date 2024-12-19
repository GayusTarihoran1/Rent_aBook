@extends('layouts.mainlayout')

@section('title', 'Book List')

@section('page-name', 'book-list')

@section('content')

    <form action="" method="get">
        <div class="row">
            <div class="col-12 col-sm-6">
                <select name="category" id="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-sm-6">
                <div class="input-group mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Search Books Title" aria-describedby="basic-addon2">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </div>
    </form>
    
    <div class="mt-5">
        @if (session('message'))
            <div class="alert {{session('alert-class')}}">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="my-5">
        <div class="row">

            @foreach ($books as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <img src="{{ $item->cover != null ? asset('storage/cover/'.$item->cover) :asset('images/image_not_found.jpg') }}" class="card-img-top" draggable="false">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{$item->book_code}}</h5>
                                <p class="card-text">{{$item->title}}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-auto">
                                <button 
                                    class="btn btn-rent {{ $item->status == 'instock' ? 'btn-success' : 'btn-secondary' }}" 
                                    {{ $item->status == 'instock' && auth()->check() && auth()->id() != 5 ? '' : 'disabled' }}
                                    data-bs-toggle="modal"
                                    data-bs-target="#rentConfirmationModal"
                                    data-book-id="{{ $item->id }}">
                                    Rent now
                                </button>
                                <p class="card-text fw-bold {{ $item->status == 'instock' ? 'text-success' : 'text-danger' }}">
                                    {{ $item->status }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(auth()->check())
        <!-- Modal -->
        <div class="modal fade" id="rentConfirmationModal" tabindex="-1" aria-labelledby="rentConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rentConfirmationModalLabel">Konfirmasi Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin meminjam buku ini?</p>
                        <form action="rent" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="book_id" id="book_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

<script>
const rentButtons = document.querySelectorAll('.btn-rent');
const bookIdInput = document.getElementById('book_id');

rentButtons.forEach(button => {
    button.addEventListener('click', function () {
        const bookId = this.dataset.bookId;
        bookIdInput.value = bookId; // Set book_id dari tombol ke input form
    });
});

</script>



@endsection