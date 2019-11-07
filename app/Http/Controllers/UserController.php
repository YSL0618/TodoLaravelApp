<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('users/index', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
    public function showEditForm()
    {
        return view('users/edit');

        return view('users/index', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function editUserAccount()
    {
        $user = Auth::user();

        return view('users/index', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
