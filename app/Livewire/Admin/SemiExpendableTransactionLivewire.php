<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Fund;
use App\Models\Office;
use App\Models\Signature;
use App\Models\SemiExpendable;
use App\Models\SemiExpendableTransaction;
use App\Models\SemiExpendableTransactionItem;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class SemiExpendableTransactionLivewire extends Component
{
    use WithPagination, WithoutUrlPagination;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
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

    // for adding items
    public $item_count;
    public $added_items = [];
    public $itd = '';

    // request details
    public $sep_transaction;
    public $tcode;
    public $fund;
    public $office;
    public $purpose;
    public $custodian;
    public $custodian_id;
    public $position_cus;
    public $date_cus;
    public $issuer;
    public $issuer_id;
    public $position_iss;
    public $date_iss;
    public $icsnum;
    public $overall_total;

    // for transaction code generation
    public $code_exists = false;
    public $signature = false;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->loadSEPTransactions();

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
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select('semi_expendables.id as sep_id',
            'semi_expendables.code as sep_code',
            'semi_expendables.item as sep_item',
            'semi_expendables.description as sep_description',
            'categories.category as sep_category',
            'semi_expendables.fund as sep_fund',
            'units.unit as sep_unit',
            'semi_expendables.price as sep_price',
            'semi_expendables.date_acquired as sep_date_acquired',
            'semi_expendables.est_life as sep_est_life',
            'semi_expendables.status as sep_status',
            'semi_expendables.custodian as sep_custodian',
            'semi_expendables.status as sep_status',
            )
            ->paginate($this->pagination);
            
            $this->recordCount = $semi_expendables->total();

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
            $semi_expendables = DB::table('semi_expendables')
            ->join('categories','semi_expendables.category','=','categories.id')
            ->join('units','semi_expendables.unit','=','units.id')
            ->where('semi_expendables.code','like','%'.$this->searchQuery.'%')
            ->orWhere('semi_expendables.item','like','%'.$this->searchQuery.'%')
            ->orWhere('semi_expendables.description','like','%'.$this->searchQuery.'%')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select('semi_expendables.id as sep_id',
            'semi_expendables.code as sep_code',
            'semi_expendables.item as sep_item',
            'semi_expendables.description as sep_description',
            'categories.category as sep_category',
            'semi_expendables.fund as sep_fund',
            'units.unit as sep_unit',
            'semi_expendables.price as sep_price',
            'semi_expendables.date_acquired as sep_date_acquired',
            'semi_expendables.est_life as sep_est_life',
            'semi_expendables.status as sep_status',
            'semi_expendables.custodian as sep_custodian',
            'semi_expendables.status as sep_status',
            )
            ->paginate($this->pagination);

            $this->resultCount = $semi_expendables->total(); 

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

        $this->item_count = count($this->added_items);

        // $users = User::where('role','!=', 'Superadmin')->where('id','!=', Auth::user()->id)->orderBy('name','asc')->get();
        $users = User::where('role','!=', 'Superadmin')->orderBy('name','asc')->get();
        $issuers = User::where('role','!=', 'Superadmin')->where('issuer_level','=', 'YES')->orderBy('name','asc')->get();
        $funds = Fund::orderBy('fund','asc')->get();
        $offices = Office::orderBy('initial','asc')->get();
        $this->signature = Signature::where('user_id','=',Auth::user()->id)->exists();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.semi-expendable-transaction-livewire',[
            'semi_expendables' => $semi_expendables,
            'users' => $users,
            'issuers' => $issuers,
            'funds' => $funds,
            'offices' => $offices,
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

        if($column == 'semi_expendables.code')
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
    public function loadSEPTransactions()
    {
        $this->sep_transaction = SemiExpendableTransaction::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'transaction-added' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('transaction-added')]
    public function refreshSEP()
    {
        $this->loadSEPTransactions();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addToList($id)
    {
        $this->icsnum = $this->generateICSNum();
        $add_this = SemiExpendable::find($id);
        $this_unit = Unit::find($add_this->unit);

        $this->added_items[] = [
            'id' => $add_this->id,
            'code' => $add_this->code,
            'item' => $add_this->item,
            'description' => $add_this->description,
            'unit' => $this_unit->unit,
            'qty' => '1',
            'price' => $add_this->price,
            'total' => $add_this->price,
        ];
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function removeFromList($index)
    {
        // Check if the index exists
        if (isset($this->added_items[$index])) {
            $this->itd = $this->added_items[$index]['id'];

            unset($this->added_items[$index]); // Remove the item at the given index

            // Re-index the array to prevent gaps in the keys
            $this->added_items = array_values($this->added_items);

            $this->dispatch('SEP-removed', [$this->itd]);
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getCusPos()
    {
        if($this->custodian_id == '' or $this->custodian_id == null or $this->custodian_id == '0' or $this->custodian_id == 0)
        {
            $this->position_cus = '';
            $this->custodian = '';
        }
        else
        {
            $pos_cus = User::find($this->custodian_id);
            $this->position_cus = $pos_cus->position;
            $this->custodian = $pos_cus->name;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getIssPos()
    {
        if($this->issuer_id == '' or $this->issuer_id == null or $this->issuer_id == '0' or $this->issuer_id == 0)
        {
            $this->position_iss = '';
            $this->issuer = '';
        }
        else
        {
            $pos_iss = User::find($this->issuer_id);
            $this->position_iss = $pos_iss->position;
            $this->issuer = $pos_iss->name;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateSEPRequest()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup = SemiExpendableTransaction::where('icsnum', '=', $this->icsnum)->exists();

        if($dup == true)
        {
            $this->icsnum = $this->generateICSNum();
            $this->checkDuplicate();
        }
        else
        {
            $this->addSEPTransaction();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function generateICSNum()
    {
        $ref = SemiExpendableTransaction::where('icsnum','!=',null)->orderBy('id','desc')->first();

        $month = Carbon::now()->format('m'); // get 2-digit format of month
        $year = Carbon::now()->format('Y'); // get 4-digit format of year

        if($ref) // if there is an existing ics num
        {
            $ref_array = explode('-',$ref->icsnum); // format: 2024-12-001
            $latest_m = $ref_array[1];
            $latest_y = $ref_array[0];
            $latest_num = $ref_array[2];

            if($latest_m < $month)
            {
                $num = '001';
            }
            else
            {
                if($latest_y < $year)
                {
                    $num = '001';
                }
                else
                {
                    $num = str_pad($latest_num + 1,3,'0',STR_PAD_LEFT);
                }
            }

            return $year.'-'.$month.'-'.$num;
        }
        else
        {
            return $year.'-'.$month.'-001';
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getOverallTotal()
    {
        // convert the array to a collection
        $collection = collect($this->added_items);

        // sum the values of the 'total' key
        $this->overall_total = $this->convertToDecimal($collection->sum('total'));
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function convertToDecimal($value)
    {
        return number_format((float)$value, 2, '.', ''); // Converts to 2 decimal places
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addSEPTransaction()
    {
        $this->getOverallTotal();

        $transaction = new SemiExpendableTransaction();
        $this->tcode = $this->generateCode();

        $transaction->tcode = $this->tcode;
        $transaction->icsnum = $this->icsnum;
        $transaction->fund = $this->fund;
        $transaction->office = $this->office;
        $transaction->purpose = $this->purpose;
        $transaction->custodian_id = $this->custodian_id;
        $transaction->custodian = $this->custodian;
        $transaction->position_cus = $this->position_cus;
        $transaction->date_cus = $this->date_cus;
        $transaction->sign_cus = 'false';
        $transaction->issuer_id = $this->issuer_id;
        $transaction->issuer = $this->issuer;
        $transaction->position_iss = $this->position_iss;
        $transaction->date_iss = $this->date_iss;
        $transaction->sign_iss = 'false';
        $transaction->ics_generation = 'yes';
        $transaction->overall_total = $this->overall_total;
        $transaction->save();

        $this->addSEPTransactionItems();

        $this->resetAddForm();

        $this->dispatch('transaction-added', $transaction);

        session()->flash('success','Successfully assigned custodian!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addSEPTransactionItems()
    {
        $transaction_id = SemiExpendableTransaction::where('tcode','=',$this->tcode)->first();

        $itemno = 1;

        foreach($this->added_items as $added_item)
        {
            $add = new SemiExpendableTransactionItem();
            $add->transaction_id = $transaction_id->id;
            $add->itemnum = $itemno;
            $add->sep_id = $added_item['id'];
            $add->sep_code = $added_item['code'];
            $add->quantity = $added_item['qty'];
            $add->price = $added_item['price'];
            $add->total = $added_item['total'];
            $add->save();

            $itemno++;

            $upd = SemiExpendable::find($added_item['id']);
            $upd->custodian = $this->custodian_id;
            $upd->save();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset([
            'added_items',
            'tcode',
            'office',
            'purpose',
            'custodian_id',
            'custodian',
            'position_cus',
            'date_cus',
            'issuer_id',
            'issuer',
            'position_iss',
            'date_iss',
            'icsnum',
            'overall_total',
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function generateCode() {    
        $new_code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

        $this->code_exists = SemiExpendableTransaction::where('tcode', '=', $new_code)->exists();

        if($this->code_exists == true)
        {
            self::generateCode();
        }
        else
        {
            return $new_code;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
