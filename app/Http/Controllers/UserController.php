<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // create a new user instance
        $user = new User();
        $user->name = $validatedData['full_name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);

        // save the new user to the database
        $user->save();

        // redirect the user to the login page
        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // attempt to authenticate the user
        if (auth()->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // if the user is authenticated, redirect them to the dashboard
            return redirect()->route('links.index');
        }

        // if the user is not authenticated, redirect them back to the login page
        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

}
