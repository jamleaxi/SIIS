<?php

namespace App\Livewire\Super;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GlobalMessage;

class IndexLivewire extends Component
{
    // auth references
    public $my_id;
    public $my_name;
    public $my_email;
    public $my_position;
    public $my_position_full;
    public $my_office;
    public $my_office_full;
    public $my_role;
    public $my_photo;
    public $dark_setting;

    // counters
    public $superadmin_count;
    public $superadmin_count_active;
    public $superadmin_count_inactive;
    public $superadmin_count_locked;
    public $administrator_count;
    public $administrator_count_active;
    public $administrator_count_inactive;
    public $administrator_count_locked;
    public $user_count;
    public $user_count_active;
    public $user_count_inactive;
    public $user_count_locked;
    
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            // do nothing

            $this->my_id = Auth::user()->id;
            $this->my_name = Auth::user()->name;
            $this->my_email = Auth::user()->email;
            $this->my_position = Auth::user()->position;
            $this->my_position_full = Auth::user()->position_full;
            $this->my_office = Auth::user()->office;
            $this->my_office_full = Auth::user()->office_full;
            $this->my_role = Auth::user()->role;
            $this->my_photo = Auth::user()->profile_photo_path;
            $this->dark_setting = Auth::user()->dark_mode;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function render()
    {
        $superadmins = User::where('role','=','Superadmin')->get();
        $this->superadmin_count = count($superadmins);
        $this->superadmin_count_active = count(User::where('role','=','Superadmin')->where('status','=','ACTIVE')->get());
        $this->superadmin_count_inactive = count(User::where('role','=','Superadmin')->where('status','=','INACTIVE')->get());
        $this->superadmin_count_locked = count(User::where('role','=','Superadmin')->where('status','=','LOCKED')->get());


        $administrators = User::where('role','=','Administrator')->get();
        $this->administrator_count = count($administrators);
        $this->administrator_count_active = count(User::where('role','=','Administrator')->where('status','=','ACTIVE')->get());
        $this->administrator_count_inactive = count(User::where('role','=','Administrator')->where('status','=','INACTIVE')->get());
        $this->administrator_count_locked = count(User::where('role','=','Administrator')->where('status','=','LOCKED')->get());

        $users = User::where('role','=','User')->get();
        $this->user_count = count($users);
        $this->user_count_active = count(User::where('role','=','User')->where('status','=','ACTIVE')->get());
        $this->user_count_inactive = count(User::where('role','=','User')->where('status','=','INACTIVE')->get());
        $this->user_count_locked = count(User::where('role','=','User')->where('status','=','LOCKED')->get());

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.super.index-livewire',[
            'superadmins' => $superadmins,
            'administrators' => $administrators,
            'users' => $users,
            'system_message' => $system_message,
        ]);
    }
}
