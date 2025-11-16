<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Fund;
use App\Models\CommonSupply;
use App\Models\CommonSupplyIn;
use App\Models\CommonSupplyOut;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class CommonSupplyLivewire extends Component
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
    public $code_new;
    public $item_new;
    public $description_new;
    public $category_new = '0';
    public $fund_new = '0';
    public $remarks_new;
    public $low_indicator_new;
    public $unit_new = '0';

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $common_supply_id = '';
    public $show_panel = '';

    // for updating
    public $up_status = false;
    public $code_up_origin;
    public $code_up;
    public $item_up_origin;
    public $item_up;
    public $description_up_origin;
    public $description_up;
    public $category_up_origin;
    public $category_up;
    public $fund_up_origin;
    public $fund_up;
    public $remarks_up_origin;
    public $remarks_up;
    public $low_indicator_up_origin;
    public $low_indicator_up;
    public $unit_up_origin;
    public $unit_up;

    // for inventory
    public $inventory;
    public $inv_cs_id = '';
    public $inv_code;
    public $inv_item;
    public $inv_description;
    public $inv_qty_in;
    public $inv_price_in;
    public $inv_date_acquired;
    public $inv_reference;
    public $inv_sources;
    public $source_id;
    public $source_qty;
    public $source_price;
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

        // fetch categories
        $categories_cs = Category::where('branch','=','CS')->orderBy('category','asc')->get();

        // fetch units
        $units = Unit::orderBy('unit','asc')->get();

        // fetch funds
        $funds = Fund::orderBy('fund','asc')->get();
        
        // fetch all inventory in/out
        $inventory_cs_ins = CommonSupplyIn::orderBy('date_acquired','asc')->get();
        $inventory_cs_outs = CommonSupplyOut::orderBy('date_released','asc')->get();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.common-supply-livewire', [
            'common_supplies' => $common_supplies,
            'categories_cs' => $categories_cs,
            'units' => $units,
            'funds' => $funds,
            'inventory_cs_ins' => $inventory_cs_ins,
            'inventory_cs_outs' => $inventory_cs_outs,
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
    public function validateCS()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_cs = CommonSupply::where('code','=',$this->code_new)->get();
        $this->dup_status = $dup_cs->count();

        if($this->dup_status == 0)
        {
            $this->addCS();
        }
        else
        {
            session()->flash('error','Duplicate item code!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addCS()
    {
        $cs = new CommonSupply();

        $cs->code = $this->code_new;
        $cs->item = $this->item_new;
        $cs->description = $this->description_new;
        $cs->category = $this->category_new;
        $cs->fund = $this->fund_new;
        $cs->remarks = $this->remarks_new;
        $cs->low_indicator = $this->low_indicator_new;
        $cs->unit = $this->unit_new;
        $cs->save();

        $this->resetAddForm();

        $this->dispatch('cs-added', $cs);

        session()->flash('success','New supply item added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['code_new','item_new','description_new','category_new','fund_new','remarks_new','low_indicator_new','unit_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateCSUpdate()
    {
        $this->checkDuplicateUpdate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_cs = CommonSupply::where('code','=',$this->code_up)->get();
        $this->dup_status = $dup_cs->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->code_up_origin == $this->code_up)
            {
                if($this->item_up_origin != $this->item_up or $this->description_up_origin != $this->description_up or $this->category_up_origin != $this->category_up or $this->fund_up_origin != $this->fund_up or $this->low_indicator_up_origin != $this->low_indicator_up or $this->unit_up_origin != $this->unit_up or $this->remarks_up_origin != $this->remarks_up)
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
                session()->flash('error','Duplicate item code!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateCS($id)
    {
        // get values
        $cs = CommonSupply::find($id);
        $this->common_supply_id = $cs->id;
        $this->code_up_origin = $cs->code;
        $this->code_up = $cs->code;
        $this->item_up_origin = $cs->item;
        $this->item_up = $cs->item;
        $this->description_up_origin = $cs->description;
        $this->description_up = $cs->description;
        $this->category_up_origin = $cs->category;
        $this->category_up = $cs->category;
        $this->fund_up_origin = $cs->fund;
        $this->fund_up = $cs->fund;
        $this->remarks_up_origin = $cs->remarks;
        $this->remarks_up = $cs->remarks;
        $this->low_indicator_up_origin = $cs->low_indicator;
        $this->low_indicator_up = $cs->low_indicator;
        $this->unit_up_origin = $cs->unit;
        $this->unit_up = $cs->unit;
        $this->up_status = true;
        $this->show_panel = 'update';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = CommonSupply::find($this->common_supply_id);
        $updated->code = $this->code_up;
        $updated->item = $this->item_up;
        $updated->description = $this->description_up;
        $updated->category = $this->category_up;
        $updated->fund = $this->fund_up;
        $updated->remarks = $this->remarks_up;
        $updated->low_indicator = $this->low_indicator_up;
        $updated->unit = $this->unit_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Item updated!');

        $this->dispatch('cs-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['code_up','item_up','description_up','category_up','fund_up','remarks_up','low_indicator_up','unit_up']);
        $this->common_supply_id = '';
        $this->up_status = false;
        $this->show_panel = '';
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
    public function validateCSInventory()
    {
        $this->checkDuplicateInventory();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateInventory()
    {
        $dup_cs_in = CommonSupplyIn::where('cs_id','=',$this->inv_cs_id)
        ->where('qty_in','=',$this->inv_qty_in)
        ->where('price_in','=',$this->convertToDecimal($this->inv_price_in))
        ->where('date_acquired','=',$this->inv_date_acquired)
        ->where('reference','=',$this->inv_reference)
        ->get();
        $this->dup_status = $dup_cs_in->count();

        if($this->dup_status == 0)
        {
            $this->saveInventory();
        }
        else
        {
            session()->flash('error','Duplicate inventory record!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function inventoryCS($id)
    {
        // get values
        $cs_in = CommonSupply::find($id);
        $this->inv_cs_id = $cs_in->id;
        $this->inv_code = $cs_in->code;
        $this->inv_item = $cs_in->item;
        $this->inv_description = $cs_in->description;
        $this->up_status = true;
        $this->show_panel = 'inventory';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveInventory()
    {
        $cs_inv_in = new CommonSupplyIn();

        $conv_price_in = $this->convertToDecimal($this->inv_price_in);

        $cs_inv_in->cs_id = $this->inv_cs_id;
        $cs_inv_in->qty_in = $this->inv_qty_in;
        $cs_inv_in->price_in = $conv_price_in; // converted price
        $cs_inv_in->date_acquired = $this->inv_date_acquired;
        $cs_inv_in->reference = $this->inv_reference;
        $cs_inv_in->save();

        $this->resetInventoryForm();

        $this->dispatch('cs-inventory', $cs_inv_in);

        session()->flash('success','Inventory updated successfully!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetInventoryForm()
    {
        $this->reset(['inv_qty_in','inv_price_in','inv_date_acquired','inv_reference']);
        $this->inv_cs_id = '';
        $this->up_status = false;
        $this->show_panel = '';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function convertToDecimal($value)
    {
        // COnverts to 2 decimal places
        return number_format((float)$value, 2, '.', '');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function viewSources($id)
    {
        // get item values
        $vs = CommonSupply::find($id);
        $this->inv_cs_id = $vs->id;
        $this->inv_code = $vs->code;
        $this->inv_item = $vs->item;
        $this->inv_description = $vs->description;

        // get inventories of item
        $this->inv_sources = CommonSupplyIn::where('cs_id','=',$this->inv_cs_id)->orderBy('date_acquired','asc')->get();

        // set statuses
        $this->up_status = true;
        $this->show_panel = 'sources';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetSourcesForm()
    {
        $this->reset(['inv_code','inv_item','inv_description','inv_sources']);
        $this->inv_cs_id = '';
        $this->up_status = false;
        $this->show_panel = '';
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateQP($id)
    {
        // get source values
        $sr = CommonSupplyIn::find($id);
        $this->source_id = $sr->id;
        $this->source_qty = $sr->qty_in;
        $this->source_price = $sr->price_in;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetQPForm()
    {
        $this->source_id = null;
        $this->source_qty = null;
        $this->source_price = null;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateSources()
    {
        $us = CommonSupplyIn::find($this->source_id);
        $us->qty_in = $this->source_qty;
        $us->price_in = $this->convertToDecimal($this->source_price);
        $us->save();

        $this->resetQPForm();
        $this->dispatch('cs-inventory', $us);
        session()->flash('success','Source updated successfully!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
