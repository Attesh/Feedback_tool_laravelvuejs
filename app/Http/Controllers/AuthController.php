<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/AuthController.php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // return response()->json(['token' => auth()->user()->createToken('token-name')->plainTextToken]);
        return response()->json([
            'token' => auth()->user()->createToken('token-name')->plainTextToken,
            'user_id' => auth()->user()->id,
        ]);
        
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|string|same:password',
        ]);
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['token' => $user->createToken('token-name')->plainTextToken]);
    }
}

