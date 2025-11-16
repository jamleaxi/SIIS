<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Division;
use App\Models\Office;
use App\Models\Fund;
use App\Models\Entity;
use App\Models\CenterCode;
use App\Models\Signature;
use App\Models\CommonSupply;
use App\Models\CommonSupplyIn;
use App\Models\CommonSupplyOut;
use App\Models\CommonSupplyTransaction;
use App\Models\CommonSupplyTransactionItem;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class CommonSupplyCustomTransactionLivewire extends Component
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
    public $sortColumn = 'common_supplies.item';
    public $sortDirection = 'asc';
    public $sortColumnA = 'common_supplies.description';
    public $sortColumnB = 'common_supplies.code';

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
    public $cs_transaction;
    public $tcode;
    public $division;
    public $office;
    public $purpose;
    public $requester;
    public $requester_id;
    public $position_req;
    public $date_req;
    public $approver;
    public $approver_id;
    public $position_app;
    public $date_app;
    public $fund;
    public $overall_total;
    public $risnum;
    public $entity;
    public $ccode;

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
            $this->loadCSTransactions();

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
            $common_supplies = DB::table('common_supplies')
            ->join('categories','common_supplies.category','=','categories.id')
            ->join('units','common_supplies.unit','=','units.id')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select('common_supplies.id as cs_id','common_supplies.code as cs_code','common_supplies.item as cs_item','common_supplies.description as cs_description','categories.category as cs_category','common_supplies.fund as cs_fund','common_supplies.low_indicator as cs_low_indicator','units.unit as cs_unit','common_supplies.remarks as cs_remarks')
            ->paginate($this->pagination);
            
            $this->recordCount = $common_supplies->total();

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
            $common_supplies = DB::table('common_supplies')
            ->join('categories','common_supplies.category','=','categories.id')
            ->join('units','common_supplies.unit','=','units.id')
            ->where('common_supplies.code','like','%'.$this->searchQuery.'%')
            ->orWhere('common_supplies.item','like','%'.$this->searchQuery.'%')
            ->orWhere('common_supplies.description','like','%'.$this->searchQuery.'%')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select('common_supplies.id as cs_id','common_supplies.code as cs_code','common_supplies.item as cs_item','common_supplies.description as cs_description','categories.category as cs_category','common_supplies.fund as cs_fund','common_supplies.low_indicator as cs_low_indicator','units.unit as cs_unit','common_supplies.remarks as cs_remarks')
            ->paginate($this->pagination);

            $this->resultCount = $common_supplies->total(); 

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

        $users = User::where('role','!=', 'Superadmin')->orderBy('name','asc')->get();
        $this->signature = Signature::where('user_id','=',Auth::user()->id)->exists();

        $this->risnum = $this->generateRIS();

        $divisions = Division::orderBy('division','asc')->get();
        $offices = Office::orderBy('initial','asc')->get();
        $funds = Fund::orderBy('fund','asc')->get();
        $entities = Entity::orderBy('entity','asc')->get();
        $centers = CenterCode::orderBy('code','asc')->get();

        $inv_ins = CommonSupplyIn::all();
        $inv_outs = CommonSupplyOut::all();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.common-supply-custom-transaction-livewire',[
            'common_supplies' => $common_supplies,
            'users' => $users,
            'divisions' => $divisions,
            'offices' => $offices,
            'funds' => $funds,
            'entities' => $entities,
            'centers' => $centers,
            'inv_ins' => $inv_ins,
            'inv_outs' => $inv_outs,
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

        if($column == 'common_supplies.code')
        {
            $this->sortColumnA = 'common_supplies.item';
            $this->sortColumnB = 'common_supplies.description';
        }
        elseif($column == 'common_supplies.item')
        {
            $this->sortColumnA = 'common_supplies.description';
            $this->sortColumnB = 'common_supplies.code';
        }
        elseif($column == 'categories.category')
        {
            $this->sortColumnA = 'common_supplies.item';
            $this->sortColumnB = 'common_supplies.description';
        }
        
        $this->sortColumn = $column;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadCSTransactions()
    {
        $this->cs_transaction = CommonSupplyTransaction::all();
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
    public function refreshCS()
    {
        $this->loadCSTransactions();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addToList($id)
    {
        $add_this = CommonSupply::find($id);
        $this_unit = Unit::find($add_this->unit);

        $this->added_items[] = ['id' => $add_this->id,'code' => $add_this->code,'item' => $add_this->item,'description' => $add_this->description,'unit' => $this_unit->unit,'qty' => '','price' => '','total' => '0.00'];
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
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getAppPos()
    {
        if($this->approver_id == '' or $this->approver_id == null or $this->approver_id == '0' or $this->approver_id == 0)
        {
            $this->position_app = '';
            $this->approver = '';
        }
        else
        {
            $pos_app = User::find($this->approver_id);
            $this->position_app = $pos_app->position;
            $this->approver = $pos_app->name;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getReqPos()
    {
        if($this->requester_id == '' or $this->requester_id == null or $this->requester_id == '0' or $this->requester_id == 0)
        {
            $this->position_req = '';
            $this->requester = '';
        }
        else
        {
            $pos_req = User::find($this->requester_id);
            $this->position_req = $pos_req->position;
            $this->requester = $pos_req->name;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function generateRIS()
    {
        $ref = CommonSupplyTransaction::where('risnum','!=',null)->orderBy('id','desc')->first();

        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('d');
        $year = Carbon::now()->format('y');

        if($ref) // if there is an existing ris num
        {
            $ref_array = explode('-',$ref->risnum);
            $latest_m = $ref_array[0];
            $latest_y = $ref_array[2];
            $latest_num = $ref_array[3];

            if($latest_m < $month)
            {
                $num = '0001';
            }
            else
            {
                if($latest_y < $year)
                {
                    $num = '0001';
                }
                else
                {
                    $num = str_pad($latest_num + 1,4,'0',STR_PAD_LEFT);
                }
            }

            return $month.'-'.$day.'-'.$year.'-'.$num;
        }
        else
        {
            return $month.'-'.$day.'-'.$year.'-0001';
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateCSRequest()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup = CommonSupplyTransaction::where('risnum', '=', $this->risnum)->exists();

        if($dup == true)
        {
            $this->risnum = $this->generateRIS();
            $this->checkDuplicate();
        }
        else
        {
            $this->addCSTransaction();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addCSTransaction()
    {
        $issuers = User::where('issuer_level', '=','YES')->get();
        foreach($issuers as $issuer)
        {
            $iss_id = $issuer->id;
            $iss_name = $issuer->name;
            $iss_pos = $issuer->position;
        }

        $transaction = new CommonSupplyTransaction();
        $this->tcode = $this->generateCode();

        $transaction->tcode = $this->tcode;
        $transaction->risnum = $this->risnum;
        $transaction->entity = $this->entity;
        $transaction->fund = $this->fund;
        $transaction->division = $this->division;
        $transaction->office = $this->office;
        $transaction->ccode = $this->ccode;
        $transaction->purpose = $this->purpose;
        $transaction->requester_id = $this->requester_id;
        $transaction->requester = $this->requester;
        $transaction->position_req = $this->position_req;
        $transaction->date_req = $this->date_req;
        // $transaction->sign_req = 'true';
        $transaction->approver_id = $this->approver_id;
        $transaction->approver = $this->approver;
        $transaction->position_app = $this->position_app;
        // $transaction->date_app = $this->date_app;
        // $transaction->sign_app = 'true';
        $transaction->assessor_id = $this->my_id;
        $transaction->assessor = $this->my_name;
        $transaction->position_ass = $this->my_position;
        $transaction->date_ass = Carbon::today()->format('Y-m-d');
        $transaction->sign_ass = 'true';
        $transaction->issuer_id = $iss_id;
        $transaction->issuer = $iss_name;
        $transaction->position_iss = $iss_pos;
        $transaction->status = 'FOR APPROVAL';
        $transaction->ris_generation = 'yes';
        $transaction->overall_total = $this->convertToDecimal($this->overall_total);
        $transaction->accepted = 'yes';
        $transaction->submitted = 'yes';
        $transaction->type = 'project';
        $transaction->save();

        $this->addCSTransactionItems();

        $this->resetAddForm();

        $this->dispatch('transaction-added', $transaction);

        session()->flash('success','Successfully created!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addCSTransactionItems()
    {
        $transaction_id = CommonSupplyTransaction::where('tcode','=',$this->tcode)->first();

        $itemno = 1;

        foreach($this->added_items as $added_item)
        {
            $add = new CommonSupplyTransactionItem();
            $add->transaction_id = $transaction_id->id;
            $add->itemnum = $itemno;
            $add->cs_id = $added_item['id'];
            $add->cs_code = $added_item['code'];
            $add->quantity_req = $added_item['qty'];
            $add->fund = $this->fund;
            $add->available = 'YES';
            $add->quantity_iss = $added_item['qty'];
            $add->price = $this->convertToDecimal($added_item['price']);
            $add->total = $this->convertToDecimal($added_item['total']);
            $add->disbursed = 'no';
            $add->save();

            $itemno++;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['added_items','division','office','purpose','requester_id','requester','position_req','approver_id','approver','position_app']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function generateCode() 
    {    
        $new_code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

        $this->code_exists = CommonSupplyTransaction::where('tcode', '=', $new_code)->exists();

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
    public function getTotal($index)
    {
        $my_qty = $this->convertToDecimal($this->added_items[$index]['qty']);
        $my_price = $this->convertToDecimal($this->added_items[$index]['price']);
        $my_total = $my_qty * $my_price;
        $this->added_items[$index]['total'] = $this->convertToDecimal($my_total);

        $this->getOverallTotal();
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
}
