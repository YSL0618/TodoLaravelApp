<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\EditUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showIndexPage()
    {
        $user = Auth::user();

        return view('users/my_profile_index', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
    public function showEditForm(User $user)
    {
        $user = Auth::user();

        return view('users/edit_profile', [
            'name' => $user->name,
        ]);
    }

    public function editUserProfile(User $user,EditUser $request)
    {

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        return redirect()->route('users.index');
    }
}
