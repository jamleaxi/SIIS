<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Fund;
use App\Models\User;
use App\Models\SemiExpendable;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class SemiExpendableLivewire extends Component
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
    public $sortColumn = 'semi_expendables.item';
    public $sortDirection = 'asc';
    public $sortColumnA = 'semi_expendables.description';
    public $sortColumnB = 'semi_expendables.code';


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
    public $sep;
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
    public $sep_id;

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
            $this->loadSEP();

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
            $semi_expendables = DB::table('semi_expendables')
            ->join('categories','semi_expendables.category','=','categories.id')
            ->join('units','semi_expendables.unit','=','units.id')
            ->join('users','semi_expendables.custodian','=','users.id')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select(
                'semi_expendables.id as sep_id',
                'semi_expendables.code as sep_code',
                'semi_expendables.item as sep_item',
                'semi_expendables.description as sep_description',
                'categories.category as sep_category',
                'semi_expendables.fund as sep_fund',
                'semi_expendables.date_acquired as sep_date_acquired',
                'units.unit as sep_unit',
                'semi_expendables.price as sep_price',
                'semi_expendables.est_life as sep_est_life',
                'semi_expendables.status as sep_status',
                'users.name as sep_custodian',
                'semi_expendables.prev_cus as sep_prev_cus',
                )
            ->paginate($this->pagination);
            
            $this->recordCount = $semi_expendables->total();

            if ($this->recordCount == 1)
            {
                $this->statMessage = $this->recordCount.' record';
            }
            elseif ($this->recordCount > 1)
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
            $semi_expendables = DB::table('semi_expendables')
            ->join('categories','semi_expendables.category','=','categories.id')
            ->join('units','semi_expendables.unit','=','units.id')
            ->join('users','semi_expendables.custodian','=','users.id')
            ->where('semi_expendables.code','like','%'.$this->searchQuery.'%')
            ->orWhere('semi_expendables.item','like','%'.$this->searchQuery.'%')
            ->orWhere('semi_expendables.description','like','%'.$this->searchQuery.'%')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select(
                'semi_expendables.id as sep_id',
                'semi_expendables.code as sep_code',
                'semi_expendables.item as sep_item',
                'semi_expendables.description as sep_description',
                'categories.category as sep_category',
                'semi_expendables.fund as sep_fund',
                'semi_expendables.date_acquired as sep_date_acquired',
                'units.unit as sep_unit',
                'semi_expendables.price as sep_price',
                'semi_expendables.est_life as sep_est_life',
                'semi_expendables.status as sep_status',
                'semi_expendables.custodian as sep_custodian',
                'semi_expendables.prev_cus as sep_prev_cus',
                )
            ->paginate($this->pagination);

            $this->resultCount = $semi_expendables->total();

            if ($this->resultCount == 1)
            {
                $this->statMessage = $this->resultCount.' result found';
            }
            elseif ($this->resultCount > 1)
            {
                $this->statMessage = $this->resultCount.' results found';
            }
            else
            {
                $this->statMessage = 'No result found';
            }
        }

        // fetch categories
        $categories_sep = Category::where('branch','=','SEP')->orderBy('category','asc')->get();

        // fetch units
        $units = Unit::orderBy('unit','asc')->get();

        // fetch funds
        $funds = Fund::orderBy('fund','asc')->get();

        $users = User::where('role','!=', 'Superadmin')->orderBy('name','asc')->get();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.semi-expendable-livewire', [
            'semi_expendables' => $semi_expendables,
            'categories_sep' => $categories_sep,
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

        if($column == 'sep.code')
        {
            $this->sortColumnA = 'semi_expendables.item';
            $this->sortColumnB = 'semi_expendables.description';
        }
        elseif($column == 'semi_expendables.item')
        {
            $this->sortColumnA = 'semi_expendables.description';
            $this->sortColumnB = 'semi_expendables.code';
        }
        elseif($column == 'categories.category')
        {
            $this->sortColumnA = 'semi_expendables.item';
            $this->sortColumnB = 'semi_expendables.description';
        }
        
        $this->sortColumn = $column;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadSEP()
    {
        $this->sep = SemiExpendable::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'sep-added' => '$refresh',
        'sep-updated' => '$refresh',
        'sep-inventory' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('sep-added','sep-updated','sep-inventory')]
    public function refreshSEP()
    {
        $this->loadSEP();
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
    public function validateSEP()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_sep = SemiExpendable::where('code','=',$this->code)->get();
        $dup_status = $dup_sep->count();

        if($dup_status == 0)
        {
            $this->addSEP();
        }
        else
        {
            session()->flash('error','Duplicate SEP number!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addSEP()
    {
        $sep = new SemiExpendable();

        $sep->code = $this->code;
        $sep->item = $this->item;
        $sep->description = $this->description;
        $sep->category = $this->category;
        $sep->fund = $this->fund;
        $sep->unit = $this->unit;
        $sep->date_acquired = $this->date_acquired;
        $sep->price = $this->convertToDecimal($this->price);
        $sep->est_life = $this->est_life;
        $sep->status = $this->status;
        $sep->custodian = '';
        $sep->prev_cus = '';
        $sep->date_transferred = '';
        $sep->save();

        $this->resetAddForm();

        $this->dispatch('sep-added', $sep);

        session()->flash('success','New SEP added!');
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
    public function updateSEP($id)
    {
        $sep = SemiExpendable::find($id);
        $this->sep_id = $sep->id;
        $this->code = $sep->code;
        $this->item = $sep->item;
        $this->description = $sep->description;
        $this->category = $sep->category;
        $this->fund = $sep->fund;
        $this->unit = $sep->unit;
        $this->date_acquired = $sep->date_acquired;
        $this->price = $this->convertToDecimal($sep->price);
        $this->est_life = $sep->est_life;
        $this->status = $sep->status;
        $this->custodian = $sep->custodian;
        $this->prev_cus = $sep->prev_cus;
        $this->code_up = $sep->code;
        $this->item_up = $sep->item;
        $this->description_up = $sep->description;
        $this->category_up = $sep->category;
        $this->fund_up = $sep->fund;
        $this->unit_up = $sep->unit;
        $this->date_acquired_up = $sep->date_acquired;
        $this->price_up = $this->convertToDecimal($sep->price);
        $this->est_life_up = $sep->est_life;
        $this->status_up = $sep->status;
        $this->custodian_up = $sep->custodian;
        $this->prev_cus_up = $sep->prev_cus;
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

        $this->sep_id = '';
        $this->up_status = false;
        $this->show_panel = '';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateSEPUpdate()
    {
        $this->checkDuplicateUpdate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_sep = SemiExpendable::where('code','=',$this->code_up)->get();
        $dup_status = $dup_sep->count();

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
                session()->flash('error','Duplicate SEP number!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = SemiExpendable::find($this->sep_id);
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

        $this->dispatch('sep-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function transferSEP($id)
    {
        $sep = SemiExpendable::find($id);
        $this->sep_id = $sep->id;
        $this->code = $sep->code;
        $this->item = $sep->item;
        $this->description = $sep->description;
        $this->category = $sep->category;
        $this->fund = $sep->fund;
        $this->unit = $sep->unit;
        $this->date_acquired = $sep->date_acquired;
        $this->price = $this->convertToDecimal($sep->price);
        $this->est_life = $sep->est_life;
        $this->status = $sep->status;
        $this->custodian = $sep->custodian;
        $this->prev_cus = $sep->prev_cus;
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

        $this->sep_id = '';
        $this->up_status = false;
        $this->show_panel = '';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateSEPTransfer()
    {
        $this->saveTransfer();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveTransfer()
    {
        $updated = SemiExpendable::find($this->sep_id);
        $updated->custodian = $this->new_custodian;
        $updated->prev_cus = $this->custodian;
        $updated->date_transferred = $this->date_transferred;
        $updated->status = $this->status;
        $updated->save();

        $this->resetTransferForm();

        session()->flash('success','Transferred successfully!');

        $this->dispatch('sep-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
