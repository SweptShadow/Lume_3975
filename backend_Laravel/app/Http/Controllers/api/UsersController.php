<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function login(Request $request){
        $request->validate([
            'username' => 'required|',
            'password' => 'required',
        ]);

        // Retrieve user by email
        $user = users::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            
            if ($user->is_admin) { // Assuming `is_approved` exists in your `users` table
                Auth::login($user);
                Session::put('username', $user->username);
                Session::put('is_admin', $user->is_admin);
                Session::put('name', $user->firstname . " " . $user->lastname);

                // Redirect based on role
                return ($user->role === 'admin') ? redirect('/admin/dashboard') : redirect('/');
            } else {
                return redirect('/pending');
            }
        } else {
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }
    }


    public function register(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',  // Uppercase
                'regex:/[a-z]/',  // Lowercase
                'regex:/[0-9]/',  // Number
                'regex:/[!@#$%^&*(),.?":{}|<>]/' // Special character
            ]
        ]);

        // Create user and hash password
        $user = users::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'], 
            'is_admin' => 0
        ]);

        // Redirect to pending page
        return redirect()->route('index');
    }




    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        //
    }
}
