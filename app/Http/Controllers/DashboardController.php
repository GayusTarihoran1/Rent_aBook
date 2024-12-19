<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(){
        $bookCount = Book::count();
        $categoryCount = Category::count();
        $userCount = User::count();
        $rentlogs = RentLogs::with(['user', 'book'])->paginate(10);
        return view('dashboard', ['book_count' => $bookCount, 'category_count' => $categoryCount, 'user_count' => $userCount, 'rent_logs' => $rentlogs]);
    }
}
