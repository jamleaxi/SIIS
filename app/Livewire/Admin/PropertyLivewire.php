<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Fund;
use App\Models\User;
use App\Models\Property;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class PropertyLivewire extends Component
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

    // for sorting
    public $sortColumn = 'properties.item';
    public $sortDirection = 'asc';
    public $sortColumnA = 'properties.description';
    public $sortColumnB = 'properties.code';


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
    public $ppe;
    public $code;
    public $item;
    public $description;
    public $category = '0';
    public $unit = '0';
    public $fund = '0';
    public $date_acquired;
    public $price;
    public $status = 'New';
    public $est_life;
    public $custodian;
    public $prev_cus;

    // for updating
    public $code_up;
    public $item_up;
    public $description_up;
    public $category_up;
    public $unit_up;
    public $fund_up;
    public $date_acquired_up;
    public $price_up;
    public $status_up;
    public $est_life_up;
    public $custodian_up;
    public $prev_cus_up;
    public $ppe_id;

    // for transfer
    public $t_id;
    public $new_custodian;
    public $date_transferred;

    // for checking
    public $up_status;
    public $show_add = false;
    public $show_panel = '';
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->loadPPE();

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
        if (!$this->searchQuery)    // if search query is empty
        {
            $properties = DB::table('properties')
            ->join('categories','properties.category','=','categories.id')
            ->join('units','properties.unit','=','units.id')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select(
                'properties.id as ppe_id',
                'properties.code as ppe_code',
                'properties.item as ppe_item',
                'properties.description as ppe_description',
                'categories.category as ppe_category',
                'properties.fund as ppe_fund',
                'properties.date_acquired as ppe_date_acquired',
                'units.unit as ppe_unit',
                'properties.price as ppe_price',
                'properties.est_life as ppe_est_life',
                'properties.status as ppe_status',
                'users.name as ppe_custodian',
                'properties.prev_cus as ppe_prev_cus',
                )
            ->paginate($this->pagination);
            
            $this->recordCount = $properties->total();

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
        else    // if search query is not empty
        {
            $properties = DB::table('properties')
            ->join('categories','properties.category','=','categories.id')
            ->join('units','properties.unit','=','units.id')
            ->where('properties.code','like','%'.$this->searchQuery.'%')
            ->orWhere('properties.item','like','%'.$this->searchQuery.'%')
            ->orWhere('properties.description','like','%'.$this->searchQuery.'%')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select(
                'properties.id as ppe_id',
                'properties.code as ppe_code',
                'properties.item as ppe_item',
                'properties.description as ppe_description',
                'categories.category as ppe_category',
                'properties.fund as ppe_fund',
                'properties.date_acquired as ppe_date_acquired',
                'units.unit as ppe_unit',
                'properties.price as ppe_price',
                'properties.est_life as ppe_est_life',
                'properties.status as ppe_status',
                'properties.custodian as ppe_custodian',
                'properties.prev_cus as ppe_prev_cus',
                )
            ->paginate($this->pagination);

            $this->resultCount = $properties->total();

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

        // fetch categories
        $categories_ppe = Category::where('branch','=','PPE')->orderBy('category','asc')->get();

        // fetch units
        $units = Unit::orderBy('unit','asc')->get();

        // fetch funds
        $funds = Fund::orderBy('fund','asc')->get();

        $users = User::where('role','!=', 'Superadmin')->orderBy('name','asc')->get();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.property-livewire', [
            'properties' => $properties,
            'categories_ppe' => $categories_ppe,
            'units' => $units,
            'funds' => $funds,
            'users' => $users,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function sortBy($column)
    {
        if($this->sortColumn === $column)
        {
            $this->sortDirection = $this->swapSortDirection();
        }
        else
        {
            $this->sortDirection = 'asc';
        }

        if($column == 'ppe.code')
        {
            $this->sortColumnA = 'properties.item';
            $this->sortColumnB = 'properties.description';
        }
        elseif($column == 'properties.item')
        {
            $this->sortColumnA = 'properties.description';
            $this->sortColumnB = 'properties.code';
        }
        elseif($column == 'categories.category')
        {
            $this->sortColumnA = 'properties.item';
            $this->sortColumnB = 'properties.description';
        }
        
        $this->sortColumn = $column;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadPPE()
    {
        $this->ppe = Property::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'ppe-added' => '$refresh',
        'ppe-updated' => '$refresh',
        'ppe-inventory' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('ppe-added','ppe-updated','ppe-inventory')]
    public function refreshPPE()
    {
        $this->loadPPE();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function convertToDecimal($value)
    {
        return number_format((float)$value, 2, '.', ''); // Converts to 2 decimal places
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
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validatePPE()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_ppe = Property::where('code','=',$this->code)->get();
        $dup_status = $dup_ppe->count();

        if($dup_status == 0)
        {
            $this->addPPE();
        }
        else
        {
            session()->flash('error','Duplicate PPE number!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addPPE()
    {
        $ppe = new Property();

        $ppe->code = $this->code;
        $ppe->item = $this->item;
        $ppe->description = $this->description;
        $ppe->category = $this->category;
        $ppe->fund = $this->fund;
        $ppe->unit = $this->unit;
        $ppe->date_acquired = $this->date_acquired;
        $ppe->price = $this->convertToDecimal($this->price);
        $ppe->est_life = $this->est_life;
        $ppe->status = $this->status;
        $ppe->custodian = '';
        $ppe->prev_cus = '';
        $ppe->date_transferred = '';
        $ppe->save();

        $this->resetAddForm();

        $this->dispatch('ppe-added', $ppe);

        session()->flash('success','New PPE added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset([
            'code',
            'item',
            'description',
            'category',
            'fund',
            'unit',
            'date_acquired',
            'price',
            'est_life',
            'status',
            'custodian',
            'prev_cus',
            'date_transferred',
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatePPE($id)
    {
        $ppe = Property::find($id);
        $this->ppe_id = $ppe->id;
        $this->code = $ppe->code;
        $this->item = $ppe->item;
        $this->description = $ppe->description;
        $this->category = $ppe->category;
        $this->fund = $ppe->fund;
        $this->unit = $ppe->unit;
        $this->date_acquired = $ppe->date_acquired;
        $this->price = $this->convertToDecimal($ppe->price);
        $this->est_life = $ppe->est_life;
        $this->status = $ppe->status;
        $this->custodian = $ppe->custodian;
        $this->prev_cus = $ppe->prev_cus;
        $this->code_up = $ppe->code;
        $this->item_up = $ppe->item;
        $this->description_up = $ppe->description;
        $this->category_up = $ppe->category;
        $this->fund_up = $ppe->fund;
        $this->unit_up = $ppe->unit;
        $this->date_acquired_up = $ppe->date_acquired;
        $this->price_up = $this->convertToDecimal($ppe->price);
        $this->est_life_up = $ppe->est_life;
        $this->status_up = $ppe->status;
        $this->custodian_up = $ppe->custodian;
        $this->prev_cus_up = $ppe->prev_cus;
        $this->up_status = true;
        $this->show_panel = 'update';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset([
            'code',
            'item',
            'description',
            'category',
            'fund',
            'unit',
            'date_acquired',
            'price',
            'est_life',
            'status',
            'custodian',
            'prev_cus',
            'code_up',
            'item_up',
            'description_up',
            'category_up',
            'fund_up',
            'unit_up',
            'date_acquired_up',
            'price_up',
            'est_life_up',
            'status_up',
            'custodian_up',
            'prev_cus_up',
        ]);

        $this->ppe_id = '';
        $this->up_status = false;
        $this->show_panel = '';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validatePPEUpdate()
    {
        $this->checkDuplicateUpdate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_ppe = Property::where('code','=',$this->code_up)->get();
        $dup_status = $dup_ppe->count();

        if($dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->code == $this->code_up)
            {
                if($this->item != $this->item_up or $this->description != $this->description_up or $this->category != $this->category_up or $this->fund != $this->fund_up or $this->unit != $this->unit_up or $this->date_acquired != $this->date_acquired_up or $this->price != $this->price_up or $this->est_life != $this->est_life_up or $this->custodian != $this->custodian_up or $this->prev_cus != $this->prev_cus_up or $this->status != $this->status_up)
                {
                    $this->saveUpdate();
                }
                else
                {
                    $this->resetUpdateForm();

                    session()->flash('info','No updates were made.');
                }
            }
            else
            {
                session()->flash('error','Duplicate PPE number!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = Property::find($this->ppe_id);
        $updated->code = $this->code_up;
        $updated->item = $this->item_up;
        $updated->description = $this->description_up;
        $updated->category = $this->category_up;
        $updated->fund = $this->fund_up;
        $updated->unit = $this->unit_up;
        $updated->date_acquired = $this->date_acquired_up;
        $updated->price = $this->convertToDecimal($this->price_up);
        $updated->est_life = $this->est_life_up;
        $updated->status = $this->status_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Item updated!');

        $this->dispatch('ppe-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function transferPPE($id)
    {
        $ppe = Property::find($id);
        $this->ppe_id = $ppe->id;
        $this->code = $ppe->code;
        $this->item = $ppe->item;
        $this->description = $ppe->description;
        $this->category = $ppe->category;
        $this->fund = $ppe->fund;
        $this->unit = $ppe->unit;
        $this->date_acquired = $ppe->date_acquired;
        $this->price = $this->convertToDecimal($ppe->price);
        $this->est_life = $ppe->est_life;
        $this->status = $ppe->status;
        $this->custodian = $ppe->custodian;
        $this->prev_cus = $ppe->prev_cus;
        $this->up_status = true;
        $this->show_panel = 'transfer';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetTransferForm()
    {
        $this->reset([
            'code',
            'item',
            'description',
            'category',
            'fund',
            'unit',
            'date_acquired',
            'price',
            'est_life',
            'status',
            'custodian',
            'prev_cus',
            't_id',
            'new_custodian',
            'date_transferred',
        ]);

        $this->ppe_id = '';
        $this->up_status = false;
        $this->show_panel = '';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validatePPETransfer()
    {
        $this->saveTransfer();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveTransfer()
    {
        $updated = Property::find($this->ppe_id);
        $updated->custodian = $this->new_custodian;
        $updated->prev_cus = $this->custodian;
        $updated->date_transferred = $this->date_transferred;
        $updated->status = $this->status;
        $updated->save();

        $this->resetTransferForm();

        session()->flash('success','Transferred successfully!');

        $this->dispatch('ppe-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
