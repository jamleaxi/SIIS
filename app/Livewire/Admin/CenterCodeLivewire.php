<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\CenterCode;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class CenterCodeLivewire extends Component
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

    // for inputs
    public $center;
    public $center_new;
    public $code_new;

    // for counters
    public $count = 0;

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $center_id = '';

    // for updating
    public $up_status = false;
    public $center_up_origin;
    public $center_up;
    public $code_up_origin;
    public $code_up;

    //for deleting
    public $delete_conf = false;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->loadCenter();

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
            $centers = CenterCode::orderBy('code','asc')->get();
            $this->count = $centers->count();

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
        else // if search query is not empty
        {
            $centers = CenterCode::where('center','like','%'.$this->searchQuery.'%')->orWhere('code','like','%'.$this->searchQuery.'%')->orderBy('code','asc')->get();

            $this->resultCount = $centers->count(); 

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

        if($this->delete_conf == true)
        {
            $this->deleteCenter();
        }

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.center-code-livewire', [
            'centers' => $centers,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadCenter()
    {
        $this->center = CenterCode::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'center-added' => '$refresh',
        'center-updated' => '$refresh',
        'deleteCenter',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('center-added','center-updated')]
    public function refreshCenter()
    {
        $this->loadCenter();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateCenter()
    {
        if($this->center_new == '')
        {
            session()->flash('warning','Please provide a center name!');
        }
        else
        {
            if($this->code_new == '')
            {
                session()->flash('warning','Please provide a code for this center!');
            }
            else
            {
                $this->checkDuplicate();
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_center = CenterCode::where('center','=',$this->center_new)->orWhere('code','=',$this->code_new)->get();
        $this->dup_status = $dup_center->count();

        if($this->dup_status == 0)
        {
            $this->addCenter();
        }
        else
        {
            session()->flash('error','Duplicate center name or code!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addCenter()
    {
        $center = new CenterCode;

        $center->center = $this->center_new;
        $center->code = $this->code_new;
        $center->save();

        $this->resetAddForm();

        $this->dispatch('center-added', $center);

        session()->flash('success','New center added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['center_new','code_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateCenterUpdate()
    {
        if($this->center_up == '')
        {
            session()->flash('warning','Please provide a center name!');
        }
        else
        {
            if($this->code_up == '')
            {
                session()->flash('warning','Please provide a code for this center!');
            }
            else
            {
                $this->checkDuplicateUpdate();
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_center = CenterCode::where('code','=',$this->code_up)->get();
        $this->dup_status = $dup_center->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->code_up_origin == $this->code_up)
            {
                if($this->center_up_origin == $this->center_up)
                {
                    $this->resetUpdateForm();

                    session()->flash('info','No updates were made.');
                }
                else
                {
                    $this->saveUpdate();
                }
            }
            else
            {
                session()->flash('error','Duplicate center name or code!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateCenter($id)
    {
        // get values
        $center = CenterCode::find($id);
        $this->center_id = $center->id;
        $this->center_up_origin = $center->center;
        $this->center_up = $center->center;
        $this->code_up_origin = $center->code;
        $this->code_up = $center->code;
        $this->up_status = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = CenterCode::find($this->center_id);
        $updated->center = $this->center_up;
        $updated->code = $this->code_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Center updated!');

        $this->dispatch('center-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['center_up','code_up']);
        $this->center_id = '';
        $this->up_status = false;
        $this->delete_conf = false;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteCenter()
    {
        $deleted = CenterCode::find($this->center_id);
        $deleted->delete();

        $this->resetUpdateForm();

        session()->flash('success','Center deleted!');

        $this->dispatch('center-updated', $deleted);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function showAddPanel()
    {
        $this->show_add = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideAddPanel()
    {
        $this->show_add = false;
        $this->resetAddForm();
    }
}
