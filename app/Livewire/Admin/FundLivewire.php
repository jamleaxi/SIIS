<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Fund;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class FundLivewire extends Component
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
    public $fund;
    public $fund_new;
    public $description_new;

    // for counters
    public $count = 0;

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $fund_id = '';

    // for updating
    public $up_status = false;
    public $fund_up_origin;
    public $fund_up;
    public $description_up_origin;
    public $description_up;

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
            $this->loadFund();

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
            $funds = Fund::orderBy('fund','asc')->get();
            $this->count = $funds->count();

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
            $funds = Fund::where('fund','like','%'.$this->searchQuery.'%')->orWhere('description','like','%'.$this->searchQuery.'%')->orderBy('fund','asc')->get();

            $this->resultCount = $funds->count(); 

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
            $this->deleteFund();
        }

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.fund-livewire', [
            'funds' => $funds,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadFund()
    {
        $this->fund = Fund::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'fund-added' => '$refresh',
        'fund-updated' => '$refresh',
        'deleteFund',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('fund-added','fund-updated')]
    public function refreshFund()
    {
        $this->loadFund();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateFund()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_fund = Fund::where('fund','=',$this->fund_new)->orWhere('description','=',$this->description_new)->get();
        $this->dup_status = $dup_fund->count();

        if($this->dup_status == 0)
        {
            $this->addFund();
        }
        else
        {
            session()->flash('error','Duplicate fund code or description!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addFund()
    {
        $fund = new Fund;

        $fund->fund = $this->fund_new;
        $fund->description = $this->description_new;
        $fund->save();

        $this->resetAddForm();

        $this->dispatch('fund-added', $fund);

        session()->flash('success','New fund added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['fund_new','description_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateFundUpdate()
    {
        $this->checkDuplicateUpdate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_fund = Fund::where('fund','=',$this->fund_up)->get();
        $this->dup_status = $dup_fund->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->fund_up_origin == $this->fund_up)
            {
                if($this->description_up_origin == $this->description_up)
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
                session()->flash('error','Duplicate fund code or description!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateFund($id)
    {
        // get values
        $fund = Fund::find($id);
        $this->fund_id = $fund->id;
        $this->fund_up_origin = $fund->fund;
        $this->fund_up = $fund->fund;
        $this->description_up_origin = $fund->description;
        $this->description_up = $fund->description;
        $this->up_status = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = Fund::find($this->fund_id);
        $updated->fund = $this->fund_up;
        $updated->description = $this->description_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Fund updated!');

        $this->dispatch('fund-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['fund_up','description_up']);
        $this->fund_id = '';
        $this->up_status = false;
        $this->delete_conf = false;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteFund()
    {
        $deleted = Fund::find($this->fund_id);
        $deleted->delete();

        $this->resetUpdateForm();

        session()->flash('success','Fund deleted!');

        $this->dispatch('fund-updated', $deleted);
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
