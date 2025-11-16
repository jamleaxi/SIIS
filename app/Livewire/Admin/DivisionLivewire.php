<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Division;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class DivisionLivewire extends Component
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
    public $division;
    public $division_new;

    // for counters
    public $count = 0;

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $division_id = '';

    // for updating
    public $up_status = false;
    public $division_up_origin;
    public $division_up;

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
            $this->loadDivision();

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
            $divisions = Division::orderBy('division','asc')->get();
            $this->count = $divisions->count();

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
            $divisions = Division::where('division','like','%'.$this->searchQuery.'%')->orderBy('division','asc')->get();

            $this->resultCount = $divisions->count(); 

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
            $this->deleteDivision();
        }

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.division-livewire', [
            'divisions' => $divisions,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadDivision()
    {
        $this->division = Division::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'division-added' => '$refresh',
        'division-updated' => '$refresh',
        'deleteDivision',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('division-added','division-updated')]
    public function refreshDivision()
    {
        $this->loadDivision();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateDivision()
    {
        if($this->division_new == '')
        {
            session()->flash('warning','Please provide a division name!');
        }
        else
        {
            $this->checkDuplicate();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_division = Division::where('division','=',$this->division_new)->get();
        $this->dup_status = $dup_division->count();

        if($this->dup_status == 0)
        {
            $this->addDivision();
        }
        else
        {
            session()->flash('error','Duplicate division name!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addDivision()
    {
        $division = new Division;

        $division->division = $this->division_new;
        $division->save();

        $this->resetAddForm();

        $this->dispatch('division-added', $division);

        session()->flash('success','New division added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['division_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateDivisionUpdate()
    {
        if($this->division_up == '')
        {
            session()->flash('warning','Please provide a division name!');
        }
        else
        {
            $this->checkDuplicateUpdate();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_division = Division::where('division','=',$this->division_up)->get();
        $this->dup_status = $dup_division->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->division_up_origin == $this->division_up)
            {
                $this->resetUpdateForm();

                session()->flash('info','No updates were made.');
            }
            else
            {
                session()->flash('error','Duplicate division name!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateDivision($id)
    {
        // get values
        $division = Division::find($id);
        $this->division_id = $division->id;
        $this->division_up_origin = $division->division;
        $this->division_up = $division->division;
        $this->up_status = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = Division::find($this->division_id);
        $updated->division = $this->division_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Division updated!');

        $this->dispatch('division-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['division_up']);
        $this->division_id = '';
        $this->up_status = false;
        $this->delete_conf = false;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteDivision()
    {
        $deleted = Division::find($this->division_id);
        $deleted->delete();

        $this->resetUpdateForm();

        session()->flash('success','Division deleted!');

        $this->dispatch('division-updated', $deleted);
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
