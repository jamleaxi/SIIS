<?php

namespace App\Livewire\Super;

use Livewire\Component;
use App\Models\Office;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class OfficeLivewire extends Component
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
    public $office;
    public $office_new;
    public $initial_new;

    // for counters
    public $count = 0;

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $office_id = '';

    // for updating
    public $up_status = false;
    public $office_up_origin;
    public $office_up;
    public $initial_up_origin;
    public $initial_up;

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
            $this->loadOffice();

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
            $offices = Office::orderBy('initial','asc')->get();
            $this->count = $offices->count();

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
            $offices = Office::where('office','like','%'.$this->searchQuery.'%')->orWhere('initial','like','%'.$this->searchQuery.'%')->orderBy('initial','asc')->get();

            $this->resultCount = $offices->count(); 

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
            $this->deleteOffice();
        }

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.super.office-livewire', [
            'offices' => $offices,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadOffice()
    {
        $this->office = Office::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'office-added' => '$refresh',
        'office-updated' => '$refresh',
        'deleteOffice',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('office-added','office-updated')]
    public function refreshOffice()
    {
        $this->loadOffice();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateOffice()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_office = Office::where('initial','=',$this->initial_new)->orWhere('office','=',$this->office_new)->get(); // 
        $this->dup_status = $dup_office->count();

        if($this->dup_status == 0)
        {
            $this->addOffice();
        }
        else
        {
            session()->flash('error','Duplicate office name or initials!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addOffice()
    {
        $office = new Office;

        $office->office = $this->office_new;
        $office->initial = $this->initial_new;
        $office->save();

        $this->resetAddForm();

        $this->dispatch('office-added', $office);

        session()->flash('success','New office added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['office_new','initial_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateOfficeUpdate()
    {
        if($this->office_up == '')
        {
            session()->flash('warning','Please provide an office name!');
        }
        else
        {
            if($this->initial_up == '')
            {
                session()->flash('warning','Please provide an initial for this office!');
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
        $dup_office = Office::where('initial','=',$this->initial_up)->get(); // where('office','=',$this->office_up)->
        $this->dup_status = $dup_office->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->initial_up_origin == $this->initial_up)
            {
                if($this->office_up_origin == $this->office_up)
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
                session()->flash('error','Duplicate office name or initials!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateOffice($id)
    {
        /**
         * @var mixed $office
         */
        $office = Office::find($id);
        $this->office_id = $office->id;
        $this->office_up_origin = $office->office;
        $this->office_up = $office->office;
        $this->initial_up_origin = $office->initial;
        $this->initial_up = $office->initial;
        $this->up_status = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = Office::find($this->office_id);
        $updated->office = $this->office_up;
        $updated->initial = $this->initial_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Office updated!');

        $this->dispatch('office-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['office_up','initial_up']);
        $this->office_id = '';
        $this->up_status = false;
        $this->delete_conf = false;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteOffice()
    {
        $deleted = Office::find($this->office_id);
        $deleted->delete();

        $this->resetUpdateForm();

        session()->flash('success','Office deleted!');

        $this->dispatch('office-updated', $deleted);
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
