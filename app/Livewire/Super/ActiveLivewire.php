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
use App\Models\GlobalMessage;

class ActiveLivewire extends Component
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
    public $alluser;
    public $alluser_active;
    public $alluser_inactive;
    public $alluser_locked;
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
            $this->loadAlluser();

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
            $allusers = User::where('status','=','ACTIVE')->orderBy('name','asc')->paginate($this->pagination);
            $this->count = count(User::where('status','=','ACTIVE')->get());

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
            $allusers = User::where('status','=','ACTIVE')
                ->where(function($query) use ($search){
                    $query->where('name','like','%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                })->orderBy('name','asc')->paginate($this->pagination);

            $this->resultCount = User::where('status','=','ACTIVE')
                ->where(function($query) use ($search){
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

        $this->admin_issuer = count(User::where('issuer_level','=','YES')->get());
        if($this->admin_issuer > 0)
        {
            $admin_issuer_get = User::where('issuer_level','=','YES')->first();
            $this->admin_issuer_set = $admin_issuer_get->name.' ('.$admin_issuer_get->position.', '.$admin_issuer_get->office_full.')';
        }

        $positions = Position::orderBy('position','asc')->get();
        $offices = Office::orderBy('office','asc')->get();

        if($this->confirm_activate == true)
        {
            $this->activateAlluser();
        }

        if($this->confirm_deactivate == true)
        {
            $this->deactivateAlluser();
        }

        if($this->confirm_issuer == true)
        {
            $this->issuerAlluser();
        }

        if($this->confirm_issuer_remove == true)
        {
            $this->issuerRemoveAlluser();
        }

        if($this->confirm_staff == true)
        {
            $this->staffUser();
        }

        if($this->confirm_staff_remove == true)
        {
            $this->staffRemoveAlluser();
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

        return view('livewire.super.active-livewire',[
            'allusers' => $allusers,
            'positions' => $positions,
            'offices' => $offices,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadAlluser()
    {
        $this->alluser = User::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'alluser-updated' => '$refresh',
        'alluser-activated' => '$refresh',
        'alluser-deactivated' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On(
    'alluser-updated',
    'alluser-activated',
    'alluser-deactivated',
    )]
    public function refreshAlluser()
    {
        $this->loadAlluser();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewAlluser($id)
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
    public function editAlluser($id)
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

        $this->dispatch('alluser-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setActivate($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerActivate', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function activateAlluser()
    {
        $activate = User::find($this->s_id);
        $activate->status = 'ACTIVE';
        $activate->save();

        $this->resetActivate();

        session()->flash('success','User reactivated successfully!');

        $this->dispatch('alluser-activated', $activate);
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
    public function deactivateAlluser()
    {
        $deactivate = User::find($this->s_id);
        $deactivate->status = 'INACTIVE';
        $deactivate->save();

        $this->resetDeactivate();

        session()->flash('success','User deactivated successfully!');

        $this->dispatch('alluser-deactivated', $deactivate);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDeactivate()
    {
        $this->confirm_deactivate = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setIssuer($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerIssuer', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function issuerAlluser()
    {
        $issuer = User::find($this->s_id);
        $issuer->issuer_level = 'YES';
        $issuer->save();

        $this->resetIssuer();

        session()->flash('success','Issuer has been set successfully!');

        $this->dispatch('alluser-updated', $issuer);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetIssuer()
    {
        $this->confirm_issuer = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setIssuerRemove($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerIssuerRemove', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function issuerRemoveAlluser()
    {
        $issuer = User::find($this->s_id);
        $issuer->issuer_level = 'NO';
        $issuer->save();

        $this->resetIssuerRemove();

        session()->flash('success','Removed as issuer successfully!');

        $this->dispatch('alluser-updated', $issuer);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetIssuerRemove()
    {
        $this->confirm_issuer_remove = false; 
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

        $this->dispatch('alluser-updated', $staff);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetStaff()
    {
        $this->confirm_staff = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setStaffRemove($id)
    {
        $this->s_id = $id;

        $this->dispatch('triggerStaffRemove', $this->s_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function staffRemoveAlluser()
    {
        $issuer = User::find($this->s_id);
        $issuer->role = 'User';
        $issuer->supply_staff = 'NO';
        $issuer->save();

        $this->resetStaffRemove();

        session()->flash('success','Removed as an administrator successfully!');

        $this->dispatch('alluser-updated', $issuer);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetStaffRemove()
    {
        $this->confirm_staff_remove = false; 
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

        $this->dispatch('alluser-updated', $super);
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

        $this->dispatch('alluser-updated', $delete);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDelete()
    {
        $this->confirm_delete = false; 
        $this->reset(['s_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
