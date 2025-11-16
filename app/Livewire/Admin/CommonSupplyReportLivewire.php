<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Unit;
use App\Models\CommonSupply;
use App\Models\CommonSupplyIn;
use App\Models\CommonSupplyOut;
use App\Models\CommonSupplyTransaction;
use App\Models\CommonSupplyTransactionItem;
use App\Models\CommonSupplyTransactionItems;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class CommonSupplyReportLivewire extends Component
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

    // for inputs
    public $common_supply;
    public $c_id;
    public $entity;
    public $fund;
    public $item;
    public $code;
    public $description;
    public $unit;

    // for checking
    public $show_stock_card = false;
    public $show_advanced_stock_card = false;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->loadCS();

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
        
        $merged_dates = DB::table('common_supply_ins')
            ->select('date_acquired as date')
            ->union(
                DB::table('common_supply_outs')
                ->select('date_released as date')
            )
            ->orderBy('date')
            ->get();

        $r_items = CommonSupplyIn::orderBy('date_acquired','asc')->get();

        $i_items = DB::table('common_supply_transactions')
            ->join('common_supply_outs','common_supply_transactions.id','=','common_supply_outs.transaction_id')
            ->select(
                'common_supply_outs.cs_id as id',
                'common_supply_transactions.risnum as risnum',
                'common_supply_outs.date_released as date_released',
                'common_supply_outs.qty_out as qty_out',
                'common_supply_outs.price_out as price_out',
                'common_supply_outs.reference_out as reference_out',
                'common_supply_transactions.office as office',
                )
            ->get();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.common-supply-report-livewire', [
            'common_supplies' => $common_supplies,
            'merged_dates' => $merged_dates,
            'r_items' => $r_items,
            'i_items' => $i_items,
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
    public function loadCS()
    {
        $this->common_supply = CommonSupply::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'cs-added' => '$refresh',
        'cs-updated' => '$refresh',
        'cs-inventory' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('cs-added','cs-updated','cs-inventory')]
    public function refreshCS()
    {
        $this->loadCS();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewStockCard($id)
    {
        $sc = CommonSupply::find($id);
        $u = Unit::find($sc->unit);
        $this->c_id = $sc->id;
        $this->entity = 'JRMSU';
        $this->fund = $sc->fund;
        $this->item = $sc->item;
        $this->code = $sc->code;
        $this->description = $sc->description;
        $this->unit = $u->unit;
        $this->show_stock_card = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideStockCard()
    {
        $this->resetViewStockCard();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetViewStockCard()
    {
        $this->show_stock_card = false;
        $this->reset(['c_id','entity','fund','item','code','description','unit']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewAdvancedStockCard($id)
    {
        $sc = CommonSupply::find($id);
        $u = Unit::find($sc->unit);
        $this->c_id = $sc->id;
        $this->entity = 'JRMSU';
        $this->fund = $sc->fund;
        $this->item = $sc->item;
        $this->code = $sc->code;
        $this->description = $sc->description;
        $this->unit = $u->unit;
        $this->show_advanced_stock_card = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideAdvancedStockCard()
    {
        $this->resetViewAdvancedStockCard();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetViewAdvancedStockCard()
    {
        $this->show_advanced_stock_card = false;
        $this->reset(['c_id','entity','fund','item','code','description','unit']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
