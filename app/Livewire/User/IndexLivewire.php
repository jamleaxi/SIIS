<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\CommonSupplyTransaction;
use App\Models\GlobalMessage;
use Illuminate\Support\Facades\Auth;

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
    public $request_count;
    public $request_counts;
    public $request_countp;
    public $approve_count;
    public $approve_counts;
    public $approve_countp;
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
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function render()
    {
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

        return view('livewire.user.index-livewire',[
            'system_message' => $system_message,
        ]);
    }
}
