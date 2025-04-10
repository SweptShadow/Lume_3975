<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\Article;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{   


    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve user by email
        $user = Users::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            
            if ($user->IsApproved) {
                Auth::login($user);
                Session::put('username', $user->username);
                Session::put('role', $user->Role);
                Session::put('name', $user->firstname . " " . $user->lastname);

                // Redirect based on role
                return ($user->Role === 'admin') ? redirect('/admin/users') : redirect('/profile');
            } else {
                return redirect('/pending');
            }
        } else {
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',  
                'regex:/[a-z]/',  
                'regex:/[0-9]/', 
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ]
        ]);
    
        $user = Users::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'Role' => 'user',
            'IsApproved' => false
        ]);
    
        // Redirect to login with a success message
        return redirect()->route('pending')->with('success', 'Registration successful. Please wait for approval.');
    }


    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }


    public function getAllUserPosts(){

        $username = Session::get('username');

        $articles = Article::where('username', $username)->get();

        
        $count = $articles->count();

        $totalLikes = $articles->sum('likes');


        return view('user/profile', compact('username', 'articles', 'count', 'totalLikes'));
    }
}
