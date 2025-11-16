<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\CommonSupplyTransaction;
use App\Models\CommonSupplyOut;
use App\Models\CommonSupply;
use App\Models\CenterCode;
use App\Models\GlobalMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndexLivewire extends Component
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

    // counters
    public $assessment_count;
    public $assessment_count_s;
    public $assessment_count_p;
    public $issuance_count;
    public $issuance_count_s;
    public $issuance_count_p;
    public $complete_count;
    public $complete_count_s;
    public $complete_count_p;
    public $incoming_count;
    public $request_count;
    public $request_counts;
    public $request_countp;
    public $approve_count;
    public $approve_counts;
    public $approve_countp;
    public $assess_count;
    public $assess_counts;
    public $assess_countp;
    public $issue_count;
    public $issue_counts;
    public $issue_countp;
    public $involvement_count;
    public $involvement_counts;
    public $involvement_countp;
    public $receive_count;
    public $receive_counts;
    public $receive_countp;
    public $nreceive_count;
    public $nreceive_counts;
    public $nreceive_countp;
    public $for_approval;
    public $for_approvals;
    public $for_approvalp;
    public $for_assessment;
    public $for_assessments;
    public $for_assessmentp;
    public $for_issuance;
    public $for_issuances;
    public $for_issuancep;
    public $for_receive;
    public $for_receives;
    public $for_receivep;
    public $monthly_chart_data;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
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

        $this->monthly_chart_data = $this->getMonthlySuppliesData();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function render()
    {
        // ADMINISTRATOR DASHBOARD
        // Assessment
        $assess = CommonSupplyTransaction::where('assessor_id','=','0')
            ->where('status','=','FOR ASSESSMENT')
            ->where('submitted','=','yes')
            ->get();
        $this->assessment_count = count($assess);

        $assess_s = CommonSupplyTransaction::where('assessor_id','=','0')
            ->where('status','=','FOR ASSESSMENT')
            ->where('submitted','=','yes')
            ->where('type','=','standard')
            ->get();
        $this->assessment_count_s = count($assess_s);

        $assess_p = CommonSupplyTransaction::where('assessor_id','=','0')
            ->where('status','=','FOR ASSESSMENT')
            ->where('submitted','=','yes')
            ->where('type','=','project')
            ->get();
        $this->assessment_count_p = count($assess_p);

        // Issuance
        $issuance = CommonSupplyTransaction::where('assessor_id','!=','0')
            ->where('status','=','FOR ISSUANCE')
            ->get();
        $this->issuance_count = count($issuance);
        
        $issuance_s = CommonSupplyTransaction::where('assessor_id','!=','0')
            ->where('status','=','FOR ISSUANCE')
            ->where('type','=','standard')
            ->get();
        $this->issuance_count_s = count($issuance_s);

        $issuance_p = CommonSupplyTransaction::where('assessor_id','!=','0')
            ->where('status','=','FOR ISSUANCE')
            ->where('type','=','project')
            ->get();
        $this->issuance_count_p = count($issuance_p);

        // Complete
        $complete = CommonSupplyTransaction::where('sign_iss','=','true')
            ->where('status','=','COMPLETED')
            ->get();
        $this->complete_count = count($complete);

        $complete_s = CommonSupplyTransaction::where('sign_iss','=','true')
            ->where('status','=','COMPLETED')
            ->where('type','=','standard')
            ->get();
        $this->complete_count_s = count($complete_s);

        $complete_p = CommonSupplyTransaction::where('sign_iss','=','true')
            ->where('status','=','COMPLETED')
            ->where('type','=','project')
            ->get();
        $this->complete_count_p = count($complete_p);
        
        // Involvement
        $involvement = CommonSupplyTransaction::where('assessor_id','=',$this->my_id)
            ->orWhere('issuer_id','=',$this->my_id)
            ->get();
        $this->involvement_count = count($involvement);

        $admin_id = $this->my_id;

        $involvements = CommonSupplyTransaction::where('type','=','standard')
            ->where(function($query) use($admin_id){
                $query->where('assessor_id','=',$admin_id)
                    ->orWhere('issuer_id','=',$admin_id);
            })->get();
        $this->involvement_counts = count($involvements);

        $involvementp = CommonSupplyTransaction::where('type','=','project')
            ->where(function($query) use($admin_id){
                $query->where('assessor_id','=',$admin_id)
                    ->orWhere('issuer_id','=',$admin_id);
            })->get();
        $this->involvement_countp = count($involvementp);

        // Assessed
        $assess = CommonSupplyTransaction::where('assessor_id','=',$this->my_id)
            ->get();
        $this->assess_count = count($assess);

        $assesss = CommonSupplyTransaction::where('assessor_id','=',$this->my_id)
            ->where('type','=','standard')
            ->get();
        $this->assess_counts = count($assesss);

        $assessp = CommonSupplyTransaction::where('assessor_id','=',$this->my_id)
            ->where('type','=','project')
            ->get();
        $this->assess_countp = count($assessp);

        // Issued
        $issue = CommonSupplyTransaction::where('issuer_id','=',$this->my_id)
            ->get();
        $this->issue_count = count($issue);

        $issues = CommonSupplyTransaction::where('issuer_id','=',$this->my_id)
            ->where('type','=','standard')
            ->get();
        $this->issue_counts = count($issues);

        $issuep = CommonSupplyTransaction::where('issuer_id','=',$this->my_id)
            ->where('type','=','project')
            ->get();
        $this->issue_countp = count($issuep);

        // Incoming
        $incoming = CommonSupplyTransaction::where('assessor_id','=','0')
            ->where('status','=','FOR ASSESSMENT')
            ->where('submitted','=','no')
            ->get();
        $this->incoming_count = count($incoming);

        // USER DASHBOARD
        // Approved as Approver
        $approve = CommonSupplyTransaction::where('approver_id','=',$this->my_id)
        ->where('approved','=','yes')
            ->get();
        $this->approve_count = count($approve);

        $approves = CommonSupplyTransaction::where('approver_id','=',$this->my_id)
            ->where('type','=','standard')
            ->where('approved','=','yes')
            ->get();
        $this->approve_counts = count($approves);

        $approvep = CommonSupplyTransaction::where('approver_id','=',$this->my_id)
            ->where('type','=','project')
            ->where('approved','=','yes')
            ->get();
        $this->approve_countp = count($approvep);

        // Requests Sent
        $request = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->get();
        $this->request_count = count($request);

        $requests = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('type','=','standard')
            ->get();
        $this->request_counts = count($requests);

        $requestp = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('type','=','project')
            ->get();
        $this->request_countp = count($requestp);

        // Requests for Approval
        $approval = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR APPROVAL')
            ->get();
        $this->for_approval = count($approval);

        $approvals = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR APPROVAL')
            ->where('type','=','standard')
            ->get();
        $this->for_approvals = count($approvals);

        $approvalp = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR APPROVAL')
            ->where('type','=','project')
            ->get();
        $this->for_approvalp = count($approvalp);
        
        // Requests for Assessment
        $assessment = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR ASSESSMENT')
            ->get();
        $this->for_assessment = count($assessment);

        $assessmentss = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR ASSESSMENT')
            ->where('type','=','standard')
            ->get();
        $this->for_assessments = count($assessmentss);

        $assessmentsp = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR ASSESSMENT')
            ->where('type','=','project')
            ->get();
        $this->for_assessmentp = count($assessmentsp);
        
        // Requests for Issuance
        $issue = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR ISSUANCE')
            ->get();
        $this->for_issuance = count($issue);

        $issuess = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR ISSUANCE')
            ->where('type','=','standard')
            ->get();
        $this->for_issuances = count($issuess);

        $issuesp = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','FOR ISSUANCE')
            ->where('type','=','project')
            ->get();
        $this->for_issuancep = count($issuesp);
        
        // Requests Received
        $received = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','COMPLETED')
            ->get();
        $this->for_receive = count($received);

        $receiveds = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','COMPLETED')
            ->where('type','=','standard')
            ->get();
        $this->for_receives = count($receiveds);

        $receivedp = CommonSupplyTransaction::where('requester_id','=',$this->my_id)
            ->where('status','=','COMPLETED')
            ->where('type','=','project')
            ->get();
        $this->for_receivep = count($receivedp);
        
        // Requests Confirmed
        $receive = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            ->where('sign_rec','=','true')
            ->get();
        $this->receive_count = count($receive);

        $receives = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            ->where('type','=','standard')
            ->where('sign_rec','=','true')
            ->get();
        $this->receive_counts = count($receives);

        $receivep = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            ->where('type','=','project')
            ->where('sign_rec','=','true')
            ->get();
        $this->receive_countp = count($receivep);
        
        // Requests Not Confirmed
        $nreceive = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            ->where('sign_rec','=',null)
            ->get();
        $this->nreceive_count = count($nreceive);

        $nreceives = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            ->where('type','=','standard')
            ->where('sign_rec','=',null)
            ->get();
        $this->nreceive_counts = count($nreceives);

        $nreceivep = CommonSupplyTransaction::where('receiver_id','=',$this->my_id)
            ->where('type','=','project')
            ->where('sign_rec','=',null)
            ->get();
        $this->nreceive_countp = count($nreceivep);
        
        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');
        
        // Get top requesters
        $top_requesters = CommonSupplyTransaction::selectRaw('ccode, COUNT(*) as total_requests')
            ->where('ccode','!=',null)
            ->groupBy('ccode')
            ->orderByDesc('total_requests')
            ->take(10)
            ->get();

        // Get top items
        $top_items = DB::table('common_supply_outs as cso')
            ->join('common_supplies as cs', 'cs.id', '=', 'cso.cs_id')
            ->select('cs.item as item_name', DB::raw('SUM(cso.qty_out) as total_requested'))
            ->groupBy('cs.item')
            ->orderByDesc('total_requested')
            ->limit(10)
            ->get();

        // get center codes for top 10
        $centers = CenterCode::all();

        $this->monthly_chart_data = $this->getMonthlySuppliesData();
        
        return view('livewire.admin.index-livewire',[
            'system_message' => $system_message,
            'top_requesters' => $top_requesters,
            'top_items' => $top_items,
            'centers' => $centers,
            'monthly_chart_data',
        ]);
    }

    private function getMonthlySuppliesData($months = 12)
    {
        $startDate = Carbon::now()->subMonths($months)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Get monthly transaction counts
        $monthlyData = DB::table('common_supply_transactions as t')
            ->select(
                DB::raw('DATE_FORMAT(t.created_at, "%Y-%m") as month'),
                DB::raw('COUNT(DISTINCT t.id) as total_requests'),
                DB::raw('SUM(CASE WHEN ti.available = "YES" THEN 1 ELSE 0 END) as items_received'),
                DB::raw('SUM(CASE WHEN ti.quantity_iss IS NOT NULL AND ti.quantity_iss > 0 THEN 1 ELSE 0 END) as items_issued')
            )
            ->leftJoin('common_supply_transaction_items as ti', 't.id', '=', 'ti.transaction_id')
            ->whereBetween('t.created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Format data for Chart.js
        $labels = [];
        $total = [];
        $received = [];
        $issued = [];

        // Fill in all months, including those with no data
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $monthKey = $currentDate->format('Y-m');
            $monthLabel = $currentDate->format('M Y');
            
            $dataPoint = $monthlyData->firstWhere('month', $monthKey);
            
            $labels[] = $monthLabel;
            $total[] = $dataPoint ? $dataPoint->total_requests : 0;
            $received[] = $dataPoint ? $dataPoint->items_received : 0;
            $issued[] = $dataPoint ? $dataPoint->items_issued : 0;
            
            $currentDate->addMonth();
        }

        return [
            'labels' => $labels,
            'total' => $total,
            'received' => $received,
            'issued' => $issued
        ];
    }
}
