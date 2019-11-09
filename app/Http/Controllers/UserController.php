<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\EditUser;
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
        $user = Auth::user();
        return view('users/edit', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function editUserAccount(User $user,EditUser $request)
    {

        $user->name = $request->name;
        $user->save();
        return redirect()->route('mypage');
    }
}
