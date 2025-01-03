<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RentLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentLogController extends Controller
{
    public function index() {
        $rentlogs = RentLogs::with(['user', 'book'])->paginate(8);
        return view('rentlog', ['rent_logs' => $rentlogs]);
    }
}
