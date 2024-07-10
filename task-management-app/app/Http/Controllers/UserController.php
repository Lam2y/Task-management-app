<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserDetails(Request $request)
    {
        $user = User::find($request->user()->id);
        return response()->json($user);
    }

    public function getAllUsers()
    {
        $users = User::where('usertype', 'employee')->get();
        return response()->json($users);
    }
}
