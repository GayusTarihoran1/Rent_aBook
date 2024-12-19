<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RentLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile() {
        
        $rentlogs = RentLogs::with('user', 'book')->where('user_id', Auth::user()->id)->get();
        $user = Auth::user();
        return view('profile', ['rent_logs' => $rentlogs], ['user' => $user]);
    }

    public function index() {
        $user = User::where('role_id', 2)->where('status', 'active')->get();
        return view('user', ['user' => $user]);
    }

    public function registeredUser() {
        $registeredUser = User::where('status', 'inactive')->where('role_id', 2)->get();
        return view('registered-user', ['registeredUsers' => $registeredUser]);
    }
    
    public function show($slug) {
        $user = User::where('slug', $slug)->first();
        $rentlogs = RentLogs::with('user', 'book')->where('user_id', $user->id)->get();
        return view('user-detail', ['user'=> $user, 'rent_logs' => $rentlogs]);
    }

    public function approve($slug) {
        $user = User::where('slug', $slug)->first();
        $user->status = 'active';
        $user->save();

        return redirect('user-detail/'.$slug)->with('status', 'User Approved Successfully');
    }

    public function delete($slug) {
        $user = User::where('slug', $slug)->first();
        return view('user-delete', ['user' => $user]);
    }

    public function destroy($slug) {
        $user = User::where('slug', $slug)->first();
        $user->delete();

        return redirect('users')->with('status','User Banned Successfully');
    }

    public function bannedUser() {
        $bannedUsers = User::onlyTrashed()->get();
        return view('user-banned', ['bannedUsers' => $bannedUsers]);
    }

    public function restore($slug) {
        $user = User::withTrashed()->where('slug' , $slug)->first();
        $user->restore();

        return redirect('users')->with('status','User Restored Successfully');
    }
}
