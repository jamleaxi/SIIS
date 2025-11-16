<?php

namespace App\Livewire\Super;

use Livewire\Component;
use App\Models\Position;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class PositionLivewire extends Component
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
    public $position;
    public $position_new;
    public $initial_new;

    // for counters
    public $count = 0;

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $position_id = '';

    // for updating
    public $up_status = false;
    public $position_up_origin;
    public $position_up;
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
            $this->loadPosition();

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
            $positions = Position::orderBy('initial','asc')->get();
            $this->count = $positions->count();

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
            $positions = Position::where('position','like','%'.$this->searchQuery.'%')->orWhere('initial','like','%'.$this->searchQuery.'%')->orderBy('initial','asc')->get();

            $this->resultCount = $positions->count(); 

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
            $this->deletePosition();
        }

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.super.position-livewire', [
            'positions' => $positions,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadPosition()
    {
        $this->position = Position::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'position-added' => '$refresh',
        'position-updated' => '$refresh',
        'deletePosition',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('position-added','position-updated')]
    public function refreshPosition()
    {
        $this->loadPosition();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validatePosition()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_position = Position::where('initial','=',$this->initial_new)->orWhere('position','=',$this->position_new)->get(); // 
        $this->dup_status = $dup_position->count();

        if($this->dup_status == 0)
        {
            $this->addPosition();
        }
        else
        {
            session()->flash('error','Duplicate position title or initials!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addPosition()
    {
        $position = new Position;

        $position->position = $this->position_new;
        $position->initial = $this->initial_new;
        $position->save();

        $this->resetAddForm();

        $this->dispatch('position-added', $position);

        session()->flash('success','New position added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['position_new','initial_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validatePositionUpdate()
    {
        $this->checkDuplicateUpdate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_position = Position::where('initial','=',$this->initial_up)->get(); // where('position','=',$this->position_up)->
        $this->dup_status = $dup_position->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->initial_up_origin == $this->initial_up)
            {
                if($this->position_up_origin == $this->position_up)
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
                session()->flash('error','Duplicate position title or initials!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatePosition($id)
    {
        /**
         * @var mixed $position
         */
        $position = Position::find($id);
        $this->position_id = $position->id;
        $this->position_up_origin = $position->position;
        $this->position_up = $position->position;
        $this->initial_up_origin = $position->initial;
        $this->initial_up = $position->initial;
        $this->up_status = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = Position::find($this->position_id);
        $updated->position = $this->position_up;
        $updated->initial = $this->initial_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Position updated!');

        $this->dispatch('position-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['position_up','initial_up']);
        $this->position_id = '';
        $this->up_status = false;
        $this->delete_conf = false;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deletePosition()
    {
        $deleted = Position::find($this->position_id);
        $deleted->delete();

        $this->resetUpdateForm();

        session()->flash('success','Position deleted!');

        $this->dispatch('position-updated', $deleted);
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
