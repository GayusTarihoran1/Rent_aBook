<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\RentLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    public function index() {
        $users = User::where('id', '!=', 5)->where('status', 'active')->get();
        $books = Book::all();
        return view('book-rent', ['users' => $users, 'books' => $books]);
    }

    public function store(Request $request) {
        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();
        
        $book = Book::findOrFail($request->book_id)->only('status');
        
        if($book['status'] != 'instock') {
            Session::flash('message', 'Cannot rent, the book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }

        else {
            $count = RentLogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count();

            if($count >= 3) {
                Session::flash('message', 'Cannot rent, user has reach rent limit');
                Session::flash('alert-class', 'alert-danger');
                return redirect('book-rent');
            } else {
                try {
                    DB::beginTransaction();
                    RentLogs::create($request->all());
                    $book = Book::findOrFail($request->book_id);
                    $book->status = 'outstock';
                    $book->save();
                    DB::commit();
    
                    Session::flash('message', 'Rent book success!!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect('book-rent');
    
                } catch (\Throwable $th) {
                    DB::rollBack();
                }
            }
            
        }
    }

    public function returnBook() {
        $userIds = RentLogs::whereNull('actual_return_date')->pluck('user_id')->toArray();

        $users = User::whereIn('id', $userIds)->where('status', 'active')->get();

        $books = Book::where('status', 'outstock')->get();
        return view('return-book', ['users' => $users, 'books' => $books]);
    }

    public function saveReturnBook(Request $request) {
        $rent = RentLogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)->where('actual_return_date', null);
        $stat = Book::findOrFail($request->book_id);
        $rentData = $rent->first();
        $countData = $rent->count();

        if($countData == 1) {
            $rentData->actual_return_date = Carbon::now()->toDateString();
            $rentData->save();

            $stat->status = 'instock';
            $stat->save();

            Session::flash('message', 'The Book is returned successfully');
            Session::flash('alert-class', 'alert-success');
            return redirect('book-return');
        }
        else {
            Session::flash('message', 'There is error in process');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-return');
        }
    }

    public function userStore(Request $request) {
        
        // Validasi input dari modal
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Tentukan tanggal pinjam dan tanggal pengembalian
        $rentDate = Carbon::now()->toDateString();
        $returnDate = Carbon::now()->addDay(3)->toDateString();
    
        // Periksa status buku
        $book = Book::findOrFail($request->book_id);
        
        if ($book->status != 'instock') {
            // Jika buku tidak tersedia
            Session::flash('message', 'Cannot rent, the book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/'); // Redirect ke halaman sebelumnya
        }
    
        // Periksa jumlah buku yang sedang dipinjam user
        $activeRentsCount = RentLogs::where('user_id', $request->user_id)
                                    ->whereNull('actual_return_date')
                                    ->count();
    
        if ($activeRentsCount >= 3) {
            // Jika user sudah mencapai batas maksimal peminjaman
            Session::flash('message', 'Cannot rent, user has reached rent limit');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/');
        }
    
        // Jika semua validasi lolos, simpan data peminjaman
        try {
            DB::beginTransaction();
    
            // Buat log peminjaman
            RentLogs::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'rent_date' => $rentDate,
                'return_date' => $returnDate,
            ]);
    
            // Update status buku menjadi 'outstock'
            $book->status = 'outstock';
            $book->save();
    
            DB::commit();
    
            // Berikan notifikasi sukses
            Session::flash('message', 'Rent book success!!');
            Session::flash('alert-class', 'alert-success');
            return redirect('/');
        } catch (\Throwable $th) {
            DB::rollBack();
    
            // Berikan notifikasi error jika terjadi kegagalan
            Session::flash('message', 'An error occurred while processing the request');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/');
        }
    }
}
