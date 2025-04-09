<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{   
    /**
     * Display the admin dashboard.
     */
    public function userManagement()
    {
        $users = Users::all();
        return view('admin/dashboard', compact('users'));
    }

    /**
     * Display the toggle Approval.
     */
    public function toggleApproval(Request $request, $id)
    {
    $user = Users::findOrFail($id);
    $user->IsApproved = !$user->IsApproved;
    $user->save();

    return back()->with('success', 'User approval status updated.');
    }
}