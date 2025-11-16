<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\GlobalMessage;

class MonthlyReportLivewire extends Component
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
    public $year;
    public $month;
    public $summary = [];

    public function mount()
    {if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->year = now()->year;
            $this->month = now()->month;

            $this->loadSummary();

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

    public function updatedYear()
    {
        $this->loadSummary();
    }

    public function updatedMonth()
    {
        $this->loadSummary();
    }

    public function loadSummary()
    {
        $year = $this->year;
        $month = $this->month;

        $this->summary = DB::table('common_supplies as cs')
            ->leftJoin('common_supply_ins as ins', 'ins.cs_id', '=', 'cs.id')
            ->leftJoin('common_supply_outs as outs', 'outs.cs_id', '=', 'cs.id')
            ->select(
                'cs.id',
                'cs.code',
                'cs.item',

                // Total In
                DB::raw("SUM(CASE WHEN MONTH(ins.date_acquired) = $month AND YEAR(ins.date_acquired) = $year 
                    THEN ins.qty_in ELSE 0 END) as total_in"),

                // Total Out
                DB::raw("SUM(CASE WHEN MONTH(outs.date_released) = $month AND YEAR(outs.date_released) = $year 
                    THEN outs.qty_out ELSE 0 END) as total_out"),

                // Beginning Balance
                DB::raw("(
                    COALESCE((SELECT SUM(qty_in) FROM common_supply_ins 
                              WHERE cs_id = cs.id 
                              AND (YEAR(date_acquired) < $year 
                                   OR (YEAR(date_acquired) = $year AND MONTH(date_acquired) < $month)
                              )), 0)
                    -
                    COALESCE((SELECT SUM(qty_out) FROM common_supply_outs 
                              WHERE cs_id = cs.id 
                              AND (YEAR(date_released) < $year
                                   OR (YEAR(date_released) = $year AND MONTH(date_released) < $month)
                              )), 0)
                ) AS beginning_balance"),

                // Ending Balance
                DB::raw("(
                    (
                        COALESCE((SELECT SUM(qty_in) FROM common_supply_ins 
                                  WHERE cs_id = cs.id 
                                  AND (YEAR(date_acquired) < $year 
                                       OR (YEAR(date_acquired) = $year AND MONTH(date_acquired) < $month)
                                  )), 0)
                        -
                        COALESCE((SELECT SUM(qty_out) FROM common_supply_outs 
                                  WHERE cs_id = cs.id 
                                  AND (YEAR(date_released) < $year
                                       OR (YEAR(date_released) = $year AND MONTH(date_released) < $month)
                                  )), 0)
                    )
                    + 
                    SUM(CASE WHEN MONTH(ins.date_acquired) = $month AND YEAR(ins.date_acquired) = $year 
                        THEN ins.qty_in ELSE 0 END)
                    -
                    SUM(CASE WHEN MONTH(outs.date_released) = $month AND YEAR(outs.date_released) = $year 
                        THEN outs.qty_out ELSE 0 END)
                ) AS ending_balance")
            )
            ->groupBy('cs.id', 'cs.code', 'cs.item')
            ->orderBy('cs.item')
            ->get();
    }

    public function render()
    {
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.monthly-report-livewire',[
            'system_message' => $system_message,
        ]);
    }
}
