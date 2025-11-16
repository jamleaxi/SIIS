<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\GlobalMessage;

class TopSupplyItemsLivewire extends Component
{
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

    public $labels = [];
    public $values = [];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $topItems = DB::table('common_supply_transaction_items as csti')
                ->join('common_supplies as cs', 'cs.id', '=', 'csti.cs_id')
                ->select('cs.item as item_name', DB::raw('SUM(csti.quantity_iss) as total'))
                ->groupBy('cs.item')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            $this->labels = $topItems->pluck('item_name');
            $this->values = $topItems->pluck('total');

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

    public function render()
    {
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.top-supply-items-livewire',[
            'system_message' => $system_message,
        ]);
    }
}

