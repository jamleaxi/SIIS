<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Signature;
use App\Models\Entity;
use App\Models\Unit;
use App\Models\Division;
use App\Models\CenterCode;
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

class CommonSupplyRequestIssuanceLivewire extends Component
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
    public $my_level;
    public $dark_setting;

    // sign check
    public $signature = false;
    public $esig_files;

    // references
    public $cs_transaction;
    public $involvement_count;
    public $show_details_pane = false;
    public $show_approve_pane = false;
    public $show_assess_pane = false;
    public $show_ris_pane = false;
    public $show_issue_pane = false;
    public $show_receive_pane = false;
    public $show_edit_pane = false;
    public $show_assess_edit_pane = false;
    public $show_generate_pane = false;
    public $item_count;
    public $item_count_req;
    public $quantity_count;
    public $quantity_count_issue;
    public $rec_count;

    // request details
    public $t_id;
    public $tcode;
    public $division;
    public $office;
    public $purpose;
    public $requester;
    public $requester_id;
    public $position_req;
    public $date_req;
    public $sign_req;
    public $approver;
    public $approver_id;
    public $position_app;
    public $date_app;
    public $sign_app;
    public $assessor;
    public $assessor_id;
    public $position_ass;
    public $date_ass;
    public $sign_ass;
    public $issuer;
    public $issuer_id;
    public $position_iss;
    public $date_iss;
    public $sign_iss;
    public $receiver;
    public $receiver_id;
    public $position_rec;
    public $date_rec;
    public $sign_rec;
    public $requested_items = [];
    public $save_items = [];
    public $itd = '';
    public $status;
    public $accepted;
    public $type;
    public $created_at;
    public $risnum;
    public $entity;
    public $fund;
    public $ccode;
    public $overall_total;
    public $date_issued;
    public $date_received;
    public $issued_to;
    public $approved;
    public $submitted;
    public $ris_generation;

    // confirmation
    public $submit_confirm = false;
    public $delete_confirm = false;
    public $generate_confirm = false;
    public $issue_confirm = false;

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
            $this->my_level = Auth::user()->issuer_level;

            $this->signature = Signature::where('user_id','=',$this->my_id)->exists();

            $this->esig_files = Signature::all();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function render()
    {
        $involvement_status = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
        ->orWhere('approver_id','=',$this->my_id)
        ->orWhere('issuer_id','=',$this->my_id)
        ->orWhere('receiver_id','=',$this->my_id)
        ->get();

        $this->involvement_count = count($involvement_status);

        $system_users = User::all();

        $institutional_issuers = User::where('issuer_level', '=','YES')->get();

        $unique_dates = CommonSupplyTransaction::select('date_req')
            ->where('requester_id','=',$this->my_id)
            ->orderBy('date_req','desc')
            ->distinct()
            ->get();

        $unique_dates_app = CommonSupplyTransaction::select('date_app')
            ->where('approver_id','=',$this->my_id)
            ->orderBy('date_app','desc')
            ->distinct()
            ->get();

        $unique_dates_as = CommonSupplyTransaction::select('date_app')
            ->where('assessor_id','=','0')
            ->where('status','=','FOR ASSESSMENT')
            ->orderBy('date_app','desc')
            ->distinct()
            ->get();
        
        $unique_dates_ass = CommonSupplyTransaction::select('date_ass')
            ->where('assessor_id','!=','0')
            ->where('status','=','FOR ISSUANCE')
            ->orderBy('date_ass','desc')
            ->distinct()
            ->get();

        $unique_dates_iss = CommonSupplyTransaction::select('date_iss')
            // ->where('issuer_id','=',$this->my_id)
            ->where('date_iss','!=',null)
            ->orderBy('date_iss','desc')
            ->distinct()
            ->get();

        $unique_dates_rec = CommonSupplyTransaction::select('date_rec')
            ->where('receiver_id','=',$this->my_id)
            ->orderBy('date_rec','desc')
            ->distinct()
            ->get();

        $requests = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->orderBy('created_at','desc')
            ->get();

        $approvals = CommonSupplyTransaction::where('approver_id','=',$this->my_id)
            // ->where('status','=','FOR ASSESSMENT')
            ->orderBy('created_at','desc')
            ->get();

        $assesss = CommonSupplyTransaction::where('assessor_id','=','0')
            ->where('status','=','FOR ASSESSMENT')
            ->where('submitted','=','yes')
            ->orderBy('created_at','desc')
            ->get();

        $assessments = CommonSupplyTransaction::where('assessor_id','!=','0')
            ->where('status','=','FOR ISSUANCE')
            ->orderBy('created_at','desc')
            ->get();

        $issuances = CommonSupplyTransaction::where('sign_iss','=','true')
            ->where('status','=','COMPLETED')
            ->orderBy('created_at','desc')
            ->get();

        $receivals = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            // ->where('requester_id','!=',$this->my_id)
            ->where('status','=','COMPLETED')
            ->orderBy('created_at','desc')
            ->get();

        $this->rec_count = count($receivals);

        $transaction_items = CommonSupplyTransactionItem::all();
        $entities = Entity::orderBy('entity','asc')->get();
        $centers = CenterCode::orderBy('code','asc')->get();
        $users = User::where('role','!=', 'Superadmin')->where('id','!=', $this->my_id)->orderBy('name','asc')->get();

        if($this->submit_confirm == true)
        {
            $this->submitRequestDetails();
        }

        if($this->delete_confirm == true)
        {
            $this->deleteRequestDetails();
        }

        if($this->generate_confirm == true)
        {
            $this->generateRequest();
        }

        if($this->issue_confirm == true)
        {
            $this->issueRequest();
        }

        if (!$this->searchQuery)    // if search query is empty
        {
            $common_supplies = DB::table('common_supplies')
            ->join('categories','common_supplies.category','=','categories.id')
            ->join('units','common_supplies.unit','=','units.id')
            ->orderBy($this->sortColumn,$this->sortDirection)
            ->orderBy($this->sortColumnA,'asc')
            ->orderBy($this->sortColumnB,'asc')
            ->select(
                'common_supplies.id as cs_id',
                'common_supplies.code as cs_code',
                'common_supplies.item as cs_item',
                'common_supplies.description as cs_description',
                'categories.category as cs_category',
                'common_supplies.fund as cs_fund',
                'common_supplies.low_indicator as cs_low_indicator',
                'units.unit as cs_unit',
                'common_supplies.remarks as cs_remarks'
                )
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
            ->select(
                'common_supplies.id as cs_id',
                'common_supplies.code as cs_code',
                'common_supplies.item as cs_item',
                'common_supplies.description as cs_description',
                'categories.category as cs_category',
                'common_supplies.fund as cs_fund',
                'common_supplies.low_indicator as cs_low_indicator',
                'units.unit as cs_unit',
                'common_supplies.remarks as cs_remarks'
                )
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

        $this->item_count_req = count($this->requested_items);

        $inv_ins = CommonSupplyIn::all();
        $inv_outs = CommonSupplyOut::all();

        $divisions = Division::orderBy('division','asc')->get();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.common-supply-request-issuance-livewire', [
            'unique_dates' => $unique_dates,
            'unique_dates_app' => $unique_dates_app,
            'unique_dates_as' => $unique_dates_as,
            'unique_dates_ass' => $unique_dates_ass,
            'unique_dates_iss' => $unique_dates_iss,
            'unique_dates_rec' => $unique_dates_rec,
            'system_users' => $system_users,
            'institutional_issuers' => $institutional_issuers,
            'requests' => $requests,
            'approvals' => $approvals,
            'assesss' => $assesss,
            'assessments' => $assessments,
            'issuances' => $issuances,
            'receivals' => $receivals,
            'transaction_items' => $transaction_items,
            'entities' => $entities,
            'centers' => $centers,
            'users' => $users,
            'common_supplies' => $common_supplies,
            'inv_ins' => $inv_ins,
            'inv_outs' => $inv_outs,
            'divisions' => $divisions,
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
        'r-approved' => '$refresh',
        'r-assessed' => '$refresh',
        'r-issued' => '$refresh',
        'r-received' => '$refresh',
        'r-updated' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('r-approved','r-assessed','r-issued','r-received','r-updated')]
    public function refreshCS()
    {
        $this->loadCSTransactions();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewRequestDetails($id)
    {
        // get transaction details
        $rd = CommonSupplyTransaction::find($id);
        $this->t_id = $rd->id;
        $this->tcode = $rd->tcode;
        $this->division = $rd->division;
        $this->office = $rd->office;
        $this->purpose = $rd->purpose;
        $this->requester_id = $rd->requester_id;
        $this->requester = $rd->requester;
        $this->position_req = $rd->position_req;
        $this->date_req = $rd->date_req;
        $this->sign_req = $rd->sign_req;
        $this->approver_id = $rd->approver_id;
        $this->approver = $rd->approver;
        $this->position_app = $rd->position_app;
        $this->date_app = $rd->date_app;
        $this->sign_app = $rd->sign_app;
        $this->assessor_id = $rd->assessor_id;
        $this->assessor = $rd->assessor;
        $this->position_ass = $rd->position_ass;
        $this->date_ass = $rd->date_ass;
        $this->sign_ass = $rd->sign_ass;
        $this->issuer_id = $rd->issuer_id;
        $this->issuer = $rd->issuer;
        $this->position_iss = $rd->position_iss;
        $this->date_iss = $rd->date_iss;
        $this->sign_iss = $rd->sign_iss;
        $this->receiver_id = $rd->receiver_id;
        $this->receiver = $rd->receiver;
        $this->position_rec = $rd->position_rec;
        $this->date_rec = $rd->date_rec;
        $this->sign_rec = $rd->sign_rec;
        $this->status = $rd->status;
        $this->accepted = $rd->accepted;
        $this->type = $rd->type;
        $this->approved = $rd->approved;
        $this->submitted = $rd->submitted;
        $this->ris_generation = $rd->ris_generation;
        $this->created_at = $rd->created_at;
        $this->show_details_pane = true;

        // get transaction items
        $rdis = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)
        ->join('common_supplies','common_supply_transaction_items.cs_id','=','common_supplies.id')
        ->join('units','common_supplies.unit','=','units.id')
        ->select([
            'common_supply_transaction_items.id as rdi_id',
            'common_supply_transaction_items.itemnum as rdi_no',
            'common_supplies.item as rdi_item',
            'common_supplies.description as rdi_desc',
            'common_supplies.code as rdi_code',
            'common_supply_transaction_items.quantity_req as rdi_qty_req',
            'units.unit as rdi_unit'
            ])
        ->get();

        // get all distinct item numbers and get the actual items only
        $this->item_count = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->distinct()->count('itemnum');
        
        $cur = '';
        foreach ($rdis as $rdi)
        {
            $this->requested_items[] = [
                'id' => $rdi->rdi_id,
                'num' => $rdi->rdi_no,
                'code' => $rdi->rdi_code,
                'item' => $rdi->rdi_item,
                'description' => $rdi->rdi_desc,
                'unit' => $rdi->rdi_unit,
                'qty' => $rdi->rdi_qty_req
            ];

            if($rdi->rdi_no != $cur) // compare current item number to saved item number
            {
                $this->quantity_count += $rdi->rdi_qty_req; // quantity count gets the actual only
                $cur = $rdi->rdi_no; // store current item number for checking
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideDetailsPane()
    {
        $this->resetDetails();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDetails()
    {
        $this->show_details_pane = false;
        $this->reset([
            't_id',
            'tcode',
            'division',
            'office',
            'purpose',
            'requester_id',
            'requester',
            'position_req',
            'date_req',
            'sign_req',
            'approver_id',
            'approver',
            'position_app',
            'date_app',
            'sign_app',
            'assessor_id',
            'assessor',
            'position_ass',
            'date_ass',
            'sign_ass',
            'issuer_id',
            'issuer',
            'position_iss',
            'date_iss',
            'sign_iss',
            'receiver_id',
            'receiver',
            'position_rec',
            'date_rec',
            'sign_rec',
            'status',
            'accepted',
            'type',
            'requested_items',
            'item_count',
            'quantity_count'
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function confirmApproveRequest($id)
    {
        // get transaction details
        $rd = CommonSupplyTransaction::find($id);
        $this->t_id = $rd->id;
        $this->tcode = $rd->tcode;
        $this->show_approve_pane = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideApprovePane()
    {
        $this->resetApprove();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function approveRequest()
    {
        $app = CommonSupplyTransaction::find($this->t_id);
        $app->date_app = Carbon::now()->format('Y-m-d H:i:s');
        $app->sign_app = 'true';
        $app->assessor_id = '0';
        $app->status = 'FOR ASSESSMENT';
        $app->save();

        $this->resetApprove();

        session()->flash('success','Request successfully approved and sent for assassment.');

        $this->dispatch('r-approved', $app);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetApprove()
    {
        $this->show_approve_pane = false;
        $this->reset(['t_id','tcode']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function confirmAssessRequest($id)
    {
        // get transaction details
        $rd = CommonSupplyTransaction::find($id);
        $this->t_id = $rd->id;
        $this->tcode = $rd->tcode;
        $this->division = $rd->division;
        $this->office = $rd->office;
        $this->purpose = $rd->purpose;
        $this->requester_id = $rd->requester_id;
        $this->requester = $rd->requester;
        $this->position_req = $rd->position_req;
        $this->date_req = $rd->date_req;
        $this->sign_req = $rd->sign_req;
        $this->approver_id = $rd->approver_id;
        $this->approver = $rd->approver;
        $this->position_app = $rd->position_app;
        $this->date_app = $rd->date_app;
        $this->sign_app = $rd->sign_app;
        $this->assessor_id = $rd->assessor_id;
        $this->assessor = $rd->assessor;
        $this->position_ass = $rd->position_ass;
        $this->date_ass = $rd->date_ass;
        $this->sign_ass = $rd->sign_ass;
        $this->issuer_id = $rd->issuer_id;
        $this->issuer = $rd->issuer;
        $this->position_iss = $rd->position_iss;
        $this->date_iss = $rd->date_iss;
        $this->sign_iss = $rd->sign_iss;
        $this->receiver_id = $rd->receiver_id;
        $this->receiver = $rd->receiver;
        $this->position_rec = $rd->position_rec;
        $this->date_rec = $rd->date_rec;
        $this->sign_rec = $rd->sign_rec;
        $this->status = $rd->status;
        $this->accepted = $rd->accepted;
        $this->type = $rd->type;
        $this->entity = $rd->entity;
        $this->fund = $rd->fund;
        $this->ccode = $rd->ccode;
        $this->overall_total = $rd->overall_total;
        $this->show_assess_pane = true;
        $this->risnum = $this->generateRISNum();

        // get transaction items
        $rdis = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)
        ->join('common_supplies','common_supply_transaction_items.cs_id','=','common_supplies.id')
        ->join('units','common_supplies.unit','=','units.id')
        ->select([
            'common_supply_transaction_items.id as rdi_id',
            'common_supply_transaction_items.cs_id as rdi_cs_id',
            'common_supply_transaction_items.itemnum as rdi_no',
            'common_supplies.item as rdi_item',
            'common_supplies.description as rdi_desc',
            'common_supplies.code as rdi_code',
            'common_supply_transaction_items.quantity_req as rdi_qty_req',
            'units.unit as rdi_unit',
            'common_supply_transaction_items.fund as rdi_fund'
            ])
        ->get();

        // get all distinct item numbers and get the actual items only
        $this->item_count = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->distinct()->count('itemnum');

        $funds_used = '';
        $current_fund = '';

        foreach ($rdis as $rdi)
        {
            // {{-- JailyCodes FIFO-SI algorithm --}}
            // {{-- declare variables --}}
            $total_in = 0; // gets total quantity in
            $total_out = 0; // gets total quantity out
            $stock_total = 0;

            // get all inventory in
            $inventory_cs_ins = CommonSupplyIn::where('cs_id','=',$rdi->rdi_cs_id)->orderBy('date_acquired','asc')->get();
            foreach ($inventory_cs_ins as $inventory_cs_in)
            {
                $total_in += $inventory_cs_in->qty_in;
            }

            // get all inventory out
            $inventory_cs_outs = CommonSupplyOut::where('cs_id','=',$rdi->rdi_cs_id)->orderBy('date_released','asc')->get();
            foreach ($inventory_cs_outs as $inventory_cs_out)
            {
                $total_out += $inventory_cs_out->qty_out;
            }

            // {{-- difference: total remaining stock --}}
            $stock_total = $total_in - $total_out;

            if($stock_total > 0)
            {
                $avail = 'YES';
            }
            else
            {
                $avail = 'NO';
            }

            // {{-- declare variables --}}
            $activePO = ''; // set active PO to none
            $activePrice = 0; // set active price to zero
            $activeBal = 0; // set active balance to zero
            $excess = 0; // set excess to zero

            foreach ($inventory_cs_ins as $inventory_in)
            {
                $activePO = $inventory_in->reference; // get first value of reference
                $activePrice = $inventory_in->price_in; // get first value of price_in
                $activeBal = $inventory_in->qty_in; // get first value of qty_in

                // {{-- get OUT inputs if the inventory exists --}}
                $inventory_outs = CommonSupplyOut::where('cs_id','=',$rdi->rdi_cs_id)->where('reference_out','=', $inventory_in->reference)->orderBy('date_released','asc')->get();
                foreach($inventory_outs as $inventory_out)
                {
                    if($excess > 0)
                    {
                        $activeBal -= $excess; // deduct the current inventory out
                    }
                    else
                    {
                        $activeBal -= $inventory_out->qty_out; // deduct the current inventory out
                    }
                }
                
                // {{-- check active balance value --}}
                if($activeBal > 0) // if balance is greater than 0, always break loop
                {
                    break;
                }
                elseif($activeBal == 0)
                {
                    $activePO = ''; // set active PO to none
                    $activePrice = 0; // set active price to zero
                    $activeBal = 0; // set active balance to zero
                    // continue loop and get next value
                }
                elseif($activeBal < 0)
                {
                    $activePO = ''; // set active PO to none
                    $activePrice = 0; // set active price to zero
                    $activeBal = 0; // set active balance to zero
                    $excess = abs($activeBal); // convert balance value to positive
                }
            }
            // {{-- JailyCodes FIFO-SI algorithm end --}}

            $this->requested_items[] = [
                'id' => $rdi->rdi_id,
                'cs_id'=> $rdi->rdi_cs_id,
                'num' => $rdi->rdi_no,
                'code' => $rdi->rdi_code,
                'item' => $rdi->rdi_item,
                'description' => $rdi->rdi_desc,
                'unit' => $rdi->rdi_unit,
                'qty' => $rdi->rdi_qty_req,
                'fund'=> $rdi->rdi_fund,
                'avail' => $avail,
                'stock' => $stock_total,
                'qtyi' => '',
                'price' => $activePrice,
                'total' => '0.00',
                'remarks' => '',
                'ref' => $activePO
            ];

            $cur = '';
            if($rdi->rdi_no != $cur) // compare current item number to saved item number
            {
                $this->quantity_count += $rdi->rdi_qty_req; // quantity count gets the actual only
                $cur = $rdi->rdi_no; // store current item number for checking
            }

            // get funds used
            if($current_fund != $rdi->rdi_fund)
            {
                $current_fund = $rdi->rdi_fund;

                if($funds_used == '')
                {
                    $funds_used = $current_fund;
                }
                else
                {
                    $funds_used = $funds_used.','.$current_fund;
                }
            }

            $this->fund = $funds_used;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function generateRISNum()
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
    public function hideAssessmentPane()
    {
        $this->resetAssess();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAssess()
    {
        $this->show_assess_pane = false;
        $this->reset([
            't_id',
            'tcode',
            'division',
            'office',
            'purpose',
            'requester_id',
            'requester',
            'position_req',
            'date_req',
            'sign_req',
            'approver_id',
            'approver',
            'position_app',
            'date_app',
            'sign_app',
            'assessor_id',
            'assessor',
            'position_ass',
            'date_ass',
            'sign_ass',
            'issuer_id',
            'issuer',
            'position_iss',
            'date_iss',
            'sign_iss',
            'receiver_id',
            'receiver',
            'position_rec',
            'date_rec',
            'sign_rec',
            'status',
            'accepted',
            'type',
            'requested_items',
            'item_count',
            'quantity_count',
            'risnum',
            'entity',
            'fund',
            'ccode',
            'overall_total'
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateAssessment()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup = CommonSupplyTransaction::where('risnum', '=', $this->risnum)->exists();

        if($dup == true)
        {
            $this->risnum = $this->generateRISNum();
            $this->checkDuplicate();
        }
        else
        {
            $this->saveAssessment();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveAssessment()
    {
        $issuers = User::where('issuer_level', '=','YES')->get();
        foreach($issuers as $issuer)
        {
            $iss_id = $issuer->id;
            $iss_name = $issuer->name;
            $iss_pos = $issuer->position;
        }

        $ass = CommonSupplyTransaction::find($this->t_id);
        $ass->risnum = $this->risnum;
        $ass->entity = $this->entity;
        $ass->fund = $this->fund;
        $ass->ccode = $this->ccode;
        $ass->assessor_id = Auth::user()->id;
        $ass->assessor = Auth::user()->name;
        $ass->position_ass = Auth::user()->position;
        $ass->date_ass = Carbon::now()->format('Y-m-d H:i:s');
        $ass->sign_ass = 'true';
        $ass->issuer_id = $iss_id;
        $ass->issuer = $iss_name;
        $ass->position_iss = $iss_pos;
        $ass->status = 'FOR ISSUANCE';
        // $ass->ris_generation = 'yes'; do not generate if the RIS is not finalized by the admin
        $ass->save();

        $this->saveAssessmentItems();

        $ass->overall_total = $this->overall_total;
        $ass->save();

        $this->resetAssess();

        session()->flash('success','Request successfully assessed and forwarded to issuer.');

        $this->dispatch('r-assessed', $ass);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveAssessmentItems()
    {
        $this->deleteTransactionItems(); // clear tanan items involved sa transaction

        $index = 0; // set index number
        $itemno = 1; // set item number

        foreach($this->requested_items as $requested_item)
        {
            // {{-- JailyCodes FIFO-SI algorithm --}}
            // {{-- declare variables --}}
            $total_in = 0; // gets total quantity in
            $total_out = 0; // gets total quantity out
            $stock_total = 0; // store stock total

            // get all inventory in
            $inventory_cs_ins = CommonSupplyIn::where('cs_id','=',$requested_item['cs_id'])->orderBy('date_acquired','asc')->get();
            foreach ($inventory_cs_ins as $inventory_cs_in)
            {
                $total_in += $inventory_cs_in->qty_in; // sum all inventory IN
            }

            // get all inventory out
            $inventory_cs_outs = CommonSupplyOut::where('cs_id','=',$requested_item['cs_id'])->orderBy('date_released','asc')->get();
            foreach ($inventory_cs_outs as $inventory_cs_out)
            {
                $total_out += $inventory_cs_out->qty_out; // sum all inventory OUT
            }

            // {{-- difference: total remaining stock --}}
            $stock_total = $total_in - $total_out;

            if($stock_total > 0)
            {
                $avail = 'YES';
            }
            else
            {
                $avail = 'NO';
            }

            // {{-- declare variables --}}
            $activePO = ''; // set active PO to none
            $activePrice = 0; // set active price to zero
            $activeBal = 0; // set active balance to zero
            $excess = 0; // set excess to zero

            foreach ($inventory_cs_ins as $inventory_in)
            {
                $activePO = $inventory_in->reference; // get first value of reference
                $activePrice = $inventory_in->price_in; // get first value of price_in
                $activeBal = $inventory_in->qty_in; // get first value of qty_in

                // {{-- get OUT inputs if the inventory exists --}}
                $inventory_outs = CommonSupplyOut::where('cs_id','=',$requested_item['cs_id'])->where('reference_out','=', $inventory_in->reference)->orderBy('date_released','asc')->get();
                foreach($inventory_outs as $inventory_out)
                {
                    $activeBal -= $inventory_out->qty_out; // deduct the current inventory out
                }
                
                // {{-- check active balance value --}}
                if($activeBal > 0) // if balance is greater than 0, always break loop
                {
                    if($excess > 0)
                    {
                        if($activeBal >= $excess)
                        {
                            $this->save_items[] = [
                                'cs_id'=> $requested_item['cs_id'],
                                'num' => $itemno,
                                'code' => $requested_item['code'],
                                'item' => $requested_item['item'],
                                'description' => $requested_item['description'],
                                'unit' => $requested_item['unit'],
                                'qty' => $requested_item['qty'],
                                'fund'=> $requested_item['fund'],
                                'qtyi' => $excess,
                                'remarks' => $requested_item['remarks'],
                                'avail' => $avail,
                                'price' => $activePrice,
                                'ref' => $activePO,
                                'total' => '0.00',
                            ];

                            $this->getTotal($index);

                            $index++; // increment index
                            $itemno++; // increment item number

                            break; // break if condition is met
                        }
                        else
                        {
                            $this->save_items[] = [
                                'cs_id'=> $requested_item['cs_id'],
                                'num' => $itemno,
                                'code' => $requested_item['code'],
                                'item' => $requested_item['item'],
                                'description' => $requested_item['description'],
                                'unit' => $requested_item['unit'],
                                'qty' => $requested_item['qty'],
                                'fund'=> $requested_item['fund'],
                                'qtyi' => $activeBal,
                                'remarks' => $requested_item['remarks'],
                                'avail' => $avail,
                                'price' => $activePrice,
                                'ref' => $activePO,
                                'total' => '0.00',
                            ];

                            $this->getTotal($index);

                            $index++; // increment index
                            // get the same item number

                            $excess -= $activeBal; // deduct excess from active balance

                            // do not break and get new balance
                            $activePO = ''; // set active PO to none
                            $activePrice = 0; // set active price to zero
                            $activeBal = 0; // set active balance to zero
                        }
                    }
                    else
                    {
                        if($activeBal >= $requested_item['qtyi'])
                        {
                            $this->save_items[] = [
                                'cs_id'=> $requested_item['cs_id'],
                                'num' => $itemno,
                                'code' => $requested_item['code'],
                                'item' => $requested_item['item'],
                                'description' => $requested_item['description'],
                                'unit' => $requested_item['unit'],
                                'qty' => $requested_item['qty'],
                                'fund'=> $requested_item['fund'],
                                'qtyi' => $requested_item['qtyi'],
                                'remarks' => $requested_item['remarks'],
                                'avail' => $avail,
                                'price' => $activePrice,
                                'ref' => $activePO,
                                'total' => '0.00',
                            ];

                            $this->getTotal($index);

                            $index++; // increment index
                            $itemno++; // increment item number

                            break; // break if condition is met
                        }
                        else
                        {
                            $this->save_items[] = [
                                'cs_id'=> $requested_item['cs_id'],
                                'num' => $itemno,
                                'code' => $requested_item['code'],
                                'item' => $requested_item['item'],
                                'description' => $requested_item['description'],
                                'unit' => $requested_item['unit'],
                                'qty' => $requested_item['qty'],
                                'fund'=> $requested_item['fund'],
                                'qtyi' => $activeBal,
                                'remarks' => $requested_item['remarks'],
                                'avail' => $avail,
                                'price' => $activePrice,
                                'ref' => $activePO,
                                'total' => '0.00',
                            ];

                            $this->getTotal($index);

                            $index++; // increment index
                            // get the same item number

                            $excess = $requested_item['qtyi'] - $activeBal; // deduct requested from active balance

                            // do not break and get new balance
                            $activePO = ''; // set active PO to none
                            $activePrice = 0; // set active price to zero
                            $activeBal = 0; // set active balance to zero
                        }
                    }
                }
                else // if($activeBal <= 0)
                {
                    $activePO = ''; // set active PO to none
                    $activePrice = 0; // set active price to zero
                    $activeBal = 0; // set active balance to zero
                    // continue loop and get next value
                }
            }
            // {{-- JailyCodes FIFO-SI algorithm end --}}
        }

        foreach($this->save_items as $save_item)
        {
            // save record to transaction items
            $readd = new CommonSupplyTransactionItem();
            $readd->transaction_id = $this->t_id;
            $readd->itemnum = $save_item['num'];
            $readd->cs_id = $save_item['cs_id'];
            $readd->cs_code = $save_item['code'];
            $readd->quantity_req = $save_item['qty'];
            $readd->available = $save_item['avail'];
            $readd->quantity_iss = $save_item['qtyi'];
            $readd->price = $save_item['price'];
            $readd->total = $save_item['total'];
            $readd->fund = $save_item['fund'];
            if($save_item['remarks'] == '')
            {
                $readd->remarks = $save_item['ref'];
            }
            else
            {
                $readd->remarks = $save_item['ref'].'::'.$save_item['remarks'];
            }
            $readd->save();

            // save record to inventory out
            $out = new CommonSupplyOut();
            $out->cs_id = $save_item['cs_id'];
            $out->qty_out = $save_item['qtyi'];
            $out->price_out = $save_item['price'];
            $out->transaction_id = $this->t_id;
            $out->date_released = '';
            $out->reference_out = $save_item['ref'];
            $out->save();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteTransactionItems()
    {
        CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->delete();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getTotal($index)
    {
        $my_qty = $this->convertToDecimal($this->save_items[$index]['qtyi']);
        $my_price = $this->convertToDecimal($this->save_items[$index]['price']);
        $my_total = $my_qty * $my_price;
        $this->save_items[$index]['total'] = $this->convertToDecimal($my_total);

        $this->getOverallTotal();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getOverallTotal()
    {
        // convert the array to a collection
        $collection = collect($this->save_items);

        // sum the values of the 'total' key
        $this->overall_total = $this->convertToDecimal($collection->sum('total'));
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function convertToDecimal($value)
    {
        return number_format((float)$value, 2, '.', ''); // Converts to 2 decimal places
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function generateRequest()
    {
        $sr = CommonSupplyTransaction::find($this->t_id);
        $sr->ris_generation = 'yes';
        $sr->save();

        $this->resetGenerate();

        session()->flash('success','RIS successfully generated.');

        $this->dispatch('r-updated', $sr);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setGenerate($id)
    {
        $this->t_id = $id;

        $this->dispatch('triggerGenerate', $this->t_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetGenerate()
    {
        $this->generate_confirm = false;
        $this->reset(['t_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewGeneratedRIS($id)
    {
        // get transaction details
        $rd = CommonSupplyTransaction::find($id);
        $rc = CenterCode::where('code','=',$rd->ccode)->first();
        $this->t_id = $rd->id;
        $this->tcode = $rd->tcode;
        $this->division = $rd->division;
        $this->office = $rd->office.'-'.$rc->center;
        $this->purpose = $rd->purpose;
        $this->requester_id = $rd->requester_id;
        $this->requester = $rd->requester;
        $this->position_req = $rd->position_req;
        $this->date_req = $rd->date_req;
        $this->sign_req = $rd->sign_req;
        $this->approver_id = $rd->approver_id;
        $this->approver = $rd->approver;
        $this->position_app = $rd->position_app;
        $this->date_app = $rd->date_app;
        $this->sign_app = $rd->sign_app;
        $this->assessor_id = $rd->assessor_id;
        $this->assessor = $rd->assessor;
        $this->position_ass = $rd->position_ass;
        $this->date_ass = $rd->date_ass;
        $this->sign_ass = $rd->sign_ass;
        $this->issuer_id = $rd->issuer_id;
        $this->issuer = $rd->issuer;
        $this->position_iss = $rd->position_iss;
        $this->date_iss = $rd->date_iss;
        $this->sign_iss = $rd->sign_iss;
        $this->receiver_id = $rd->receiver_id;
        $this->receiver = $rd->receiver;
        $this->position_rec = $rd->position_rec;
        $this->date_rec = $rd->date_rec;
        $this->sign_rec = $rd->sign_rec;
        $this->status = $rd->status;
        $this->risnum = $rd->risnum;
        $this->entity = $rd->entity;
        $this->fund = $rd->fund;
        $this->ccode = $rd->ccode;
        $this->overall_total = $rd->overall_total;
        $this->show_ris_pane = true;

        // get transaction items
        $rdis = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)
        ->join('common_supplies','common_supply_transaction_items.cs_id','=','common_supplies.id')
        ->join('units','common_supplies.unit','=','units.id')
        ->select([
            'common_supply_transaction_items.id as rdi_id',
            'common_supply_transaction_items.cs_id as rdi_cs_id',
            'common_supply_transaction_items.itemnum as rdi_no',
            'common_supplies.item as rdi_item',
            'common_supplies.description as rdi_desc',
            'common_supplies.code as rdi_code',
            'common_supply_transaction_items.quantity_req as rdi_qty_req',
            'units.unit as rdi_unit',
            'common_supply_transaction_items.available as rdi_avail',
            'common_supply_transaction_items.quantity_iss as rdi_qty_iss',
            'common_supply_transaction_items.price as rdi_price',
            'common_supply_transaction_items.total as rdi_total',
            'common_supply_transaction_items.remarks as rdi_remarks'
            ])
        ->get();

        // get all distinct item numbers and get the actual items only
        $this->item_count = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->distinct()->count('itemnum');

        foreach ($rdis as $rdi)
        {
            $this->requested_items[] = [
                'id' => $rdi->rdi_id,
                'num' => $rdi->rdi_no,
                'code' => $rdi->rdi_code,
                'item' => $rdi->rdi_item,
                'description' => $rdi->rdi_desc,
                'unit' => $rdi->rdi_unit,
                'qty' => $rdi->rdi_qty_req,
                'avail' => $rdi->rdi_avail,
                'qtyi' => $rdi->rdi_qty_iss,
                'price' => $rdi->rdi_price,
                'total' => $rdi->rdi_total,
                'remarks' => $rdi->rdi_remarks
            ];

            $cur = '';
            if($rdi->rdi_no != $cur) // compare current item number to saved item number
            {
                $this->quantity_count += $rdi->rdi_qty_iss; // quantity count gets the actual only
                $cur = $rdi->rdi_no; // store current item number for checking
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideRISPane()
    {
        $this->resetRIS();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetRIS()
    {
        $this->show_ris_pane = false;
        $this->reset([
            't_id',
            'tcode',
            'division',
            'office',
            'purpose',
            'requester_id',
            'requester',
            'position_req',
            'date_req',
            'sign_req',
            'approver_id',
            'approver',
            'position_app',
            'date_app',
            'sign_app',
            'assessor_id',
            'assessor',
            'position_ass',
            'date_ass',
            'sign_ass',
            'issuer_id',
            'issuer',
            'position_iss',
            'date_iss',
            'sign_iss',
            'receiver_id',
            'receiver',
            'position_rec',
            'date_rec',
            'sign_rec',
            'status',
            'requested_items',
            'item_count',
            'quantity_count',
            'risnum',
            'entity',
            'fund',
            'ccode',
            'overall_total'
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setIssueRequest($id)
    {
        $this->t_id = $id;
        $this->dispatch('triggerIssue', $this->t_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetIssue()
    {
        $this->issue_confirm = false;
        $this->reset(['t_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateIssue()
    {
        $this->issueRequest();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function issueRequest()
    {
        $iss = CommonSupplyTransaction::find($this->t_id);
        $iss->date_iss = Carbon::now()->format('Y-m-d H:i:s');
        $iss->sign_iss = 'true';
        $iss->status = 'COMPLETED';
        $iss->save();

        $this->updateIssueItems();

        $this->resetIssue();

        session()->flash('success','Request successfully updated for issuance.');

        $this->dispatch('r-issued', $iss);
        $this->dispatch('triggerRemind');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateIssueItems()
    {
        foreach($this->requested_items as $requested_item)
        {
            if($this->type == 'standard')
            {
                $ii = CommonSupplyOut::where('transaction_id','=',$this->t_id)->get();
                foreach($ii as $in)
                {
                    $io = CommonSupplyOut::find($in->id);
                    $io->date_released = Carbon::today()->format('Y-m-d');;
                    $io->save();
                }
            }

            $ui = CommonSupplyTransactionItem::find($requested_item['id']);
            $ui->disbursed = 'yes';
            $ui->save();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function acceptRequest()
    {
        $ar = CommonSupplyTransaction::find($this->t_id);
        $ar->accepted = 'yes';
        $ar->save();

        $this->hideAssessmentPane();

        session()->flash('success','Request successfully accepted.');

        $this->dispatch('r-updated', $ar);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function declineRequest()
    {
        $dr = CommonSupplyTransaction::find($this->t_id);
        $dr->accepted = 'no';
        $dr->submitted = 'no';
        $dr->save();

        $this->hideAssessmentPane();

        session()->flash('success','Request successfully declined.');

        $this->dispatch('r-updated', $dr);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function revokeRequest()
    {
        $rr = CommonSupplyTransaction::find($this->t_id);
        $rr->accepted = null;
        $rr->save();

        $this->hideAssessmentPane();

        session()->flash('success','Request rejection successfully revoked.');

        $this->dispatch('r-updated', $rr);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function submitRequestDetails()
    {
        $sr = CommonSupplyTransaction::find($this->t_id);
        $sr->submitted = 'yes';
        $sr->save();

        $this->resetSubmit();

        session()->flash('success','Request successfully submitted.');

        $this->dispatch('r-updated', $sr);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setSubmit($id)
    {
        $this->t_id = $id;

        $this->dispatch('triggerSubmit', $this->t_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetSubmit()
    {
        $this->submit_confirm = false;
        $this->reset(['t_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteRequestDetails()
    {
        $dr = CommonSupplyTransaction::find($this->t_id);
        $dr->delete();

        $this->deleteRequestItems();

        $this->resetDelete();

        session()->flash('success','Request successfully deleted.');

        $this->dispatch('r-updated', $dr);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function deleteRequestItems()
    {
        CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->delete();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function setDelete($id)
    {
        $this->t_id = $id;

        $this->dispatch('triggerDelete', $this->t_id);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetDelete()
    {
        $this->delete_confirm = false;
        $this->reset(['t_id']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function editRequestDetails($id)
    {
        // get transaction details
        $rd = CommonSupplyTransaction::find($id);
        $this->t_id = $rd->id;
        $this->tcode = $rd->tcode;
        $this->division = $rd->division;
        $this->office = $rd->office;
        $this->purpose = $rd->purpose;
        $this->requester_id = $rd->requester_id;
        $this->requester = $rd->requester;
        $this->position_req = $rd->position_req;
        $this->date_req = $rd->date_req;
        $this->sign_req = $rd->sign_req;
        $this->approver_id = $rd->approver_id;
        $this->approver = $rd->approver;
        $this->position_app = $rd->position_app;
        $this->date_app = $rd->date_app;
        $this->sign_app = $rd->sign_app;
        $this->assessor_id = $rd->assessor_id;
        $this->assessor = $rd->assessor;
        $this->position_ass = $rd->position_ass;
        $this->date_ass = $rd->date_ass;
        $this->sign_ass = $rd->sign_ass;
        $this->issuer_id = $rd->issuer_id;
        $this->issuer = $rd->issuer;
        $this->position_iss = $rd->position_iss;
        $this->date_iss = $rd->date_iss;
        $this->sign_iss = $rd->sign_iss;
        $this->receiver_id = $rd->receiver_id;
        $this->receiver = $rd->receiver;
        $this->position_rec = $rd->position_rec;
        $this->date_rec = $rd->date_rec;
        $this->sign_rec = $rd->sign_rec;
        $this->status = $rd->status;
        $this->accepted = $rd->accepted;
        $this->show_edit_pane = true;

        // get transaction items
        $rdis = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)
        ->join('common_supplies','common_supply_transaction_items.cs_id','=','common_supplies.id')
        ->join('units','common_supplies.unit','=','units.id')
        ->select([
            'common_supply_transaction_items.cs_id as rdi_id',
            'common_supplies.code as rdi_code',
            'common_supplies.item as rdi_item',
            'common_supplies.description as rdi_desc',
            'units.unit as rdi_unit',
            'common_supply_transaction_items.quantity_req as rdi_qty_req',
            'common_supply_transaction_items.fund as rdi_fund'
            ])
        ->get();
        
        // get all distinct item numbers and get the actual items only
        $this->item_count = CommonSupplyTransactionItem::where('transaction_id','=',$this->t_id)->distinct()->count('itemnum');

        foreach ($rdis as $rdi)
        {
            $this->requested_items[] = [
                'id' => $rdi->rdi_id,
                'code' => $rdi->rdi_code,
                'item' => $rdi->rdi_item,
                'description' => $rdi->rdi_desc,
                'unit' => $rdi->rdi_unit,
                'qty' => $rdi->rdi_qty_req,
                'fund' => $rdi->rdi_fund
            ];

            $this->quantity_count = $this->quantity_count + $rdi->rdi_qty_req;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addToList($id)
    {
        $add_this = CommonSupply::find($id);
        $this_unit = Unit::find($add_this->unit);

        $this->requested_items[] = [
            'id' => $add_this->id,
            'code' => $add_this->code,
            'item' => $add_this->item,
            'description' => $add_this->description,
            'unit' => $this_unit->unit,
            'qty' => '',
            'fund' => $add_this->fund
        ];
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function removeFromList($index)
    {
        // Check if the index exists
        if (isset($this->requested_items[$index])) {
            $this->itd = $this->requested_items[$index]['id'];

            unset($this->requested_items[$index]); // Remove the item at the given index

            // Re-index the array to prevent gaps in the keys
            $this->requested_items = array_values($this->requested_items);

            $this->dispatch('r-updated', [$this->itd]);
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
    public function validateCSUpdate()
    {
        $this->updateCSTransaction();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateCSTransaction()
    {
        $transaction = CommonSupplyTransaction::find($this->t_id);
        $transaction->tcode = $this->tcode;
        $transaction->division = $this->division;
        $transaction->office = $this->office;
        $transaction->purpose = $this->purpose;
        $transaction->requester_id = $this->requester_id;
        $transaction->requester = $this->requester;
        $transaction->position_req = $this->position_req;
        $transaction->date_req = Carbon::now()->format('Y-m-d H:i:s');
        $transaction->sign_req = 'true';
        $transaction->approver_id = $this->approver_id;
        $transaction->approver = $this->approver;
        $transaction->position_app = $this->position_app;
        $transaction->date_app = Carbon::now()->format('Y-m-d H:i:s');
        $transaction->sign_app = 'true';
        $transaction->assessor_id = '0';
        $transaction->status = 'FOR ASSESSMENT';
        $transaction->type = 'standard';
        $transaction->save();

        $this->deleteTransactionItems(); // deletes previous items
        $this->updateTransactionItems(); // updates to latest items list

        $this->resetUpdateForm();

        $this->dispatch('transaction-added', $transaction);

        session()->flash('success','Request successfully updated!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateTransactionItems()
    {
        $itemno = 1;

        foreach($this->requested_items as $requested_item)
        {
            $add = new CommonSupplyTransactionItem();
            $add->transaction_id = $this->t_id;
            $add->itemnum = $itemno;
            $add->cs_id = $requested_item['id'];
            $add->cs_code = $requested_item['code'];
            $add->quantity_req = $requested_item['qty'];
            $add->fund = $requested_item['fund'];
            $add->save();

            $itemno++;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideEditPane()
    {
        $this->resetUpdateForm();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->show_edit_pane = false;
        $this->reset([
            't_id',
            'tcode',
            'division',
            'office',
            'purpose',
            'requester_id',
            'requester',
            'position_req',
            'date_req',
            'sign_req',
            'approver_id',
            'approver',
            'position_app',
            'date_app',
            'sign_app',
            'assessor_id',
            'assessor',
            'position_ass',
            'date_ass',
            'sign_ass',
            'issuer_id',
            'issuer',
            'position_iss',
            'date_iss',
            'sign_iss',
            'receiver_id',
            'receiver',
            'position_rec',
            'date_rec',
            'sign_rec',
            'status',
            'accepted',
            'requested_items',
            'item_count',
            'quantity_count',
            'itd'
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
} // end class