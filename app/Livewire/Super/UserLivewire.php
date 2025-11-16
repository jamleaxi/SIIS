<?php

namespace App\Livewire\Super;

use Livewire\Component;
use App\Models\User;
use App\Models\Position;
use App\Models\Office;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Models\GlobalMessage;

class UserLivewire extends Component
{
    use WithPagination, WithoutUrlPagination;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // for pagination
    protected $paginationTheme = "bootstrap";
    public $pagination = 10;

    // for searching
    public $searchQuery;
    public $recordCount;
    public $resultCount;
    public $statMessage;

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

    // view control
    public $show_view = false;
    public $show_edit = false;
    public $confirm_activate = false;
    public $confirm_deactivate = false;
    public $confirm_issuer = false;
    public $confirm_issuer_remove = false;
    public $confirm_staff = false;
    public $confirm_staff_remove = false;
    public $confirm_super = false;
    public $confirm_delete = false;


    // for inputs
    public $user;
    public $user_active;
    public $user_inactive;
    public $user_locked;
    public $count;
    public $admin_issuer;
    public $admin_issuer_set;
    public $admin_staff;

    // for fetched data
    public $s_id;
    public $name;
    public $email;
    public $position;
    public $position_full;
    public $office;
    public $office_full;
    public $role;
    public $dark_mode;
    public $profile_photo_path;
    public $issuer_level;
    public $supply_staff;
    public $status;
    public $created_at;
    public $created_at_parsed;
    public $updated_at;
    public $updated_at_parsed;

    // for updating
    public $name_up;
    public $email_up;
    public $position_up;
    public $position_full_up;
    public $office_up;
    public $office_full_up;
    public $role_up;
    public $dark_mode_up;
    public $profile_photo_path_up;
    public $issuer_level_up;
    public $supply_staff_up;
    public $status_up;
    public $created_at_up;
    public $updated_at_up;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->loadUser();

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
        if (!$this->searchQuery) // if search query is empty
        {
            $users = User::where('role','=','User')->orderBy('name','asc')->paginate($this->pagination);
            $this->user_active = count(User::where('role','=','User')->where('status','=','ACTIVE')->orderBy('name','asc')->get());
            $this->user_inactive = count(User::where('role','=','User')->where('status','=','INACTIVE')->orderBy('name','asc')->get());
            $this->user_locked = count(User::where('role','=','User')->where('status','=','LOCKED')->orderBy('name','asc')->get());
            $this->count = count(User::where('role','=','User')->get());

            $this->recordCount = $this->count;

            if ($this->recordCount == 1)
            {
                $this->statMessage = $this->recordCount.' record';
            }
            else if ($this->recordCount > 1)
            {
                $this->statMessage = $this->recordCount.' records';
            }
            else
            {
                $this->statMessage = 'No record available'; 
            }
        }
        else
        {
            $search = $this->searchQuery;
            $users = User::where('role','=','User')
                ->where(function($query) use($search){
                    $query->where('name','like','%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                })->orderBy('name','asc')->paginate($this->pagination);

            $this->user_active = count(User::where('role','=','User')->where('status','=','ACTIVE')->where('name','like','%'.$search.'%')->orderBy('name','asc')->get());
            $this->user_inactive = count(User::where('role','=','User')->where('status','=','INACTIVE')->where('name','like','%'.$search.'%')->orderBy('name','asc')->get());
            $this->user_locked = count(User::where('role','=','User')->where('status','=','LOCKED')->where('name','like','%'.$search.'%')->orderBy('name','asc')->get());

            $this->resultCount = User::where('role','=','User')
                ->where(function($query) use($search){
                    $query->where('name','like','%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                })->orderBy('name','asc')->count(); 

            if ($this->resultCount == 1)
            {
                $this->statMessage = $this->resultCount.' result found';
            }
            else if ($this->resultCount > 1)
            {
                $this->statMessage = $this->resultCount.' results found';
            }
            else
            {
                $this->statMessage = 'No result found';
            }
        }

        $positions = Position::orderBy('position','asc')->get();
        $offices = Office::orderBy('office','asc')->get();

        if($this->confirm_activate == true)
        {
            $this->activateUser();
        }

        if($this->confirm_deactivate == true)
        {
            $this->deactivateUser();
        }

        if($this->confirm_staff == true)
        {
            $this->staffUser();
        }

        if($this->confirm_super == true)
        {
            $this->superUser();
        }

        if($this->confirm_delete == true)
        {
            $this->deleteUser();
        }

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.super.user-livewire',[
            'users' => $users,
            'positions' => $positions,
            'offices' => $offices,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadUser()
    {
        $this->user = User::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'user-updated' => '$refresh',
        'user-activated' => '$refresh',
        'user-deactivated' => '$refresh',
        'user-staffed' => '$refresh',
        'user-supered' => '$refresh',
        'user-deleted' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On(
    'user-updated',
    'user-activated',
    'user-deactivated',
    'user-staffed',
    'user-supered',
    'user-deleted',
    )]
    public function refreshUser()
    {
        $this->loadUser();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewUser($id)
    {
        /**
         * @var mixed $view
         */
        $view = User::find($id);
        $this->s_id = $view->id;
        $this->name = $view->name;
        $this->email = $view->email;
        $this->position = $view->position;
        $this->position_full = $view->position_full;
        $this->office = $view->office;
        $this->office_full = $view->office_full;
        $this->role = $view->role;
        $this->dark_mode = $view->dark_mode;
        $this->profile_photo_path = $view->profile_photo_path;
        $this->issuer_level = $view->issuer_level;
        $this->supply_staff = $view->supply_staff;
        $this->status = $view->status;

        $today = Carbon::now();
        $c = Carbon::parse($view->created_at);
        $created = $c->diffForHumans($today,true);
        $u = Carbon::parse($view->updated_at);
        $updated = $u->diffForHumans($today,true);

        $this->created_at = $view->created_at->isoFormat('MMMM D, YYYY');
        $this->created_at_parsed = $created;
        $this->updated_at = $view->updated_at->isoFormat('MMMM D, YYYY');
        $this->updated_at_parsed = $updated;
        $this->show_view = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideViewPane()
    {
        $this->resetDetails();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDetails()
    {
        $this->show_view = false; 
        $this->reset([
            's_id',
            'name',
            'email',
            'position',
            'position_full',
            'office',
            'office_full',
            'role',
            'dark_mode',
            'profile_photo_path',
            'issuer_level',
            'supply_staff',
            'status',
            'created_at',
            'created_at_parsed',
            'updated_at',
            'updated_at_parsed',
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function editUser($id)
    {
        /**
         * @var mixed $edit
         */
        $edit = User::find($id);
        $this->s_id = $edit->id;
        $this->email = $edit->email;
        $this->email_up = $edit->email;
        $this->position = $edit->position;
        $this->position_up = $edit->position;
        $this->position_full = $edit->position_full;
        $this->position_full_up = $edit->position_full;
        $this->office = $edit->office;
        $this->office_up = $edit->office;
        $this->office_full = $edit->office_full;
        $this->office_full_up = $edit->office_full;
        $this->show_edit = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideEditPane()
    {
        $this->resetEditDetails();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetEditDetails()
    {
        $this->show_edit = false; 
        $this->reset([
            's_id',
            'position',
            'position_full',
            'office',
            'office_full',
            'position_up',
            'position_full_up',
            'office_up',
            'office_full_up',
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getOffice()
    {
        if($this->office_full_up == '0' or $this->office_full_up == 0)
        {
            $this->office_up = '';
        }
        else
        {
            $ofc = Office::where('office','=',$this->office_full_up)->first();
            $this->office_up = $ofc->initial;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getPosition()
    {
        if($this->position_full_up == '0' or $this->position_full_up == 0)
        {
            $this->position_up = '';
        }
        else
        {
            $pos = Position::where('position','=',$this->position_full_up)->first();
            $this->position_up = $pos->initial;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateChanges()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        if($this->office_full_up == $this->office_full)
        {
            if($this->position_full_up != $this->position_full)
            {
                $this->saveChanges();
            }
            else
            {
                if($this->email_up != $this->email)
                {
                    $this->saveChanges();
                }
                else
                {
                    $this->resetEditDetails();
                    session()->flash('info','No updates were made.');
                }
            }
        }
        else
        {
            $this->saveChanges();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveChanges()
    {
        $updated = User::find($this->s_id);
        $updated->email = $this->email_up;
        $updated->office = $this->office_up;
        $updated->office_full = $this->office_full_up;
        $updated->position = $this->position_up;
        $updated->position_full = $this->position_full_up;
        $updated->save();

        $this->resetEditDetails();

        session()->flash('success','Account updated successfully!');

        $this->dispatch('user-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setActivate($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerActivate', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function activateUser()
    {
        $activate = User::find($this->s_id);
        $activate->status = 'ACTIVE';
        $activate->save();

        $this->sendActivationEmail($activate->email);

        $this->resetActivate();

        session()->flash('success','User reactivated successfully!');

        $this->dispatch('user-activated', $activate);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function sendActivationEmail($email)
    {
        Mail::html(
            "
                <h2>Your account has been activated!</h2>
                <p>Please use <strong> ".$email." </strong> as your email and input your password to login.</p>
                <p>In case you have forgotten your initial password, please click on the <i>'I forgot my password'</i> at the login screen.</p>
                <hr>
                <i>***Note: This is an automated email. Please do not reply.***</i>
            ", 
            function ($message) use ($email) {
                $message->to($email)
                        ->subject('SIIS Account Activation');
            });
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetActivate()
    {
        $this->confirm_activate = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setDeactivate($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerDeactivate', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deactivateUser()
    {
        $deactivate = User::find($this->s_id);
        $deactivate->status = 'INACTIVE';
        $deactivate->save();

        $this->resetDeactivate();

        session()->flash('success','User deactivated successfully!');

        $this->dispatch('user-deactivated', $deactivate);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDeactivate()
    {
        $this->confirm_deactivate = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setStaff($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerStaff', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function staffUser()
    {
        $staff = User::find($this->s_id);
        $staff->role = 'Administrator';
        $staff->supply_staff = 'YES';
        $staff->save();

        $this->resetStaff();

        session()->flash('success','Set as an administrator successfully!');

        $this->dispatch('user-staffed', $staff);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetStaff()
    {
        $this->confirm_staff = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setSuper($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerSuper', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function superUser()
    {
        $super = User::find($this->s_id);
        $super->role = 'Superadmin';
        $super->save();

        $this->resetSuper();

        session()->flash('success','Set as a superadmin successfully!');

        $this->dispatch('user-supered', $super);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetSuper()
    {
        $this->confirm_super = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setDelete($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerDelete', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteUser()
    {
        $delete = User::find($this->s_id);
        $delete->delete();

        $this->resetDelete();

        session()->flash('success','User request deleted successfully!');

        $this->dispatch('user-deleted', $delete);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDelete()
    {
        $this->confirm_delete = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
