<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->passes() && Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'result' => true,
                'message' => 'Yes ...',
                'user' => Auth::user()
            ]);
        }
        return response()->json([
            'result' => false,
            'message' => 'No ...'
        ]);
    }

    function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->passes()) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'result' => true,
                'message' => 'Yes ...'
            ]);
        }
        return response()->json([
            'result' => false,
            'message' => 'No ...'
        ]);
    }

    function logout()
    {
        Auth::logout();
        return response()->json([
            'result' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
