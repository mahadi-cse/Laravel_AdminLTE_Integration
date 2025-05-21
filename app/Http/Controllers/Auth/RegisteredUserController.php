<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisteredUserController extends Controller
{
    public function store(Request $request, CreatesNewUsers $creator)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        // Create the user
        $creator->create($request->all());

        // DON'T login the user (Auth::login() is skipped)
        // Redirect to login instead
        return redirect()->route('login')->with('status', 'Registered successfully. Please login.');
    }
}
