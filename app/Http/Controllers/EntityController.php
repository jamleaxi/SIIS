<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class EntityController extends Controller
{
    public function index()
    {
        if  (Auth::id()) // checks if the user is logged in
        {
            $status = Auth::user()->status;

            if ($status == "ACTIVE")
            {
                // get usertype from the database
                $role = Auth::user()->role;

                // check usertype
                if ($role == 'Superadmin')    // if the user is superadmin
                {
                    return view('super.index'); // go to superadmin index
                }
                elseif ($role == 'Administrator')    // if the user is admin
                {
                    return view('admin.entity'); // go to admin index
                }
                elseif($role == 'User')    // if the user is just a user
                {
                    return view('user.index');  // go to user index
                }
            }
            elseif ($status == "INACTIVE")
            {
                Auth::logout();
                return view('lock.inactive');  // go to inactive notice
            }
            elseif ($status == "LOCKED")
            {
                Auth::logout();
                return view('lock.locked');  // go to locked notice
            }
        }
        else    // if the user is not logged in
        {
            return redirect()->route('login');
        }
    }
}
