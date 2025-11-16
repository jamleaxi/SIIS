@if ($dark_setting == 'ON')
    <body class="hold-transition sidebar-mini layout-fixed dark-mode">
@else
    <body class="hold-transition sidebar-mini layout-fixed">
@endif

    <div class="wrapper">

        @include('includes.navbar')
        @include('includes.sidebar')

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mt-3">
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check-circle mr-2"></i>{{ session('success') }}
                                </div>
                            @endif
    
                            @if (session()->has('warning'))
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-exclamation-circle mr-2"></i>{{ session('warning') }}
                                </div>
                            @endif
    
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-times-circle mr-2"></i>{{ session('error') }}
                                </div>
                            @endif
    
                            @if (session()->has('info'))
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-info-circle mr-2"></i>{{ session('info') }}
                                </div>
                            @endif
                        </div>

                        @if($signature == false)
                            <div class="col-12">
                                <div class="text-center mt-3 h5">
                                    <i class="fas fa-exclamation-circle mr-1"></i>E-signature upload is required to proceed. To set your e-signature file, 
                                    <a href="{{ url('/custom-signature') }}">click here</a>.
                                </div>
                            </div>
                        @else
                            @if($involvement_count == 0 and Auth::user()->role == 'User')
                                <div class="col-12">
                                    <div class="text-center mt-3 h5">
                                        <i class="fas fa-info-circle mr-1"></i>You have no request involvements as of the moment.
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    @if($show_details_pane == true)
                                        <div class="card card-dark">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-ticket mr-3"></i>REQUEST DETAILS<i class="ml-3 text-sm text-gray">{{ $tcode }}</i></h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" wire:click='hideDetailsPane' wire:loading.attr="disabled">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                                        <div class="info-box">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><i class="mr-1 fas fas fa-info-circle"></i><u>General Status |</u> {{ $status }}</span>

                                                                @if($approved == 'no')
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: {{ $approver }} (Approver)</span>
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: For approval of immediate supervisor</span>
                                                                @elseif($approved != 'yes')
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: {{ $requester }} (Requester)</span>
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: For submission to immediate supervisor</span>
                                                                @endif

                                                                @if($assessor_id == '0')
                                                                    @if($accepted == null)
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: Supply Office (Assessor)</span>
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: For supply officer acceptance</span>
                                                                    @elseif($accepted == 'no')
                                                                        @if($submitted != 'yes')
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: {{ $requester }} (Requester)</span>
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: Rejected by supply office</span>
                                                                        @else
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: Supply Office (Assessor)</span>
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: Rejected by supply office</span>
                                                                        @endif
                                                                    @elseif($accepted == 'yes')
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: Supply Office (Assessor)</span>
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: Ongoing assessment</span>
                                                                    @endif
                                                                @endif

                                                                @if($assessor_id != '0' and $assessor_id != null)
                                                                    @if($ris_generation == 'yes')
                                                                        @if($sign_rec == 'true')
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Confirmed by: {{ $receiver }} (Receiver)</span>
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Conclusion: Request completion confirmed</span>
                                                                        @else
                                                                            @if($sign_iss == 'true')
                                                                                <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: {{ $requester }} (Receiver)</span>
                                                                                <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: For receipt confirmation</span>
                                                                            @else
                                                                                <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: {{ $issuer }} (Issuer)</span>
                                                                                <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: Pending issuance</span>
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Currently at: {{ $assessor }} (Assessor)</span>
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Progress: Pending RIS generation</span>
                                                                    @endif
                                                                @endif

                                                                @if($type == 'standard')
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Request Type: Standard</span>
                                                                @else
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-angle-double-right"></i>Request Type: Project</span>
                                                                @endif

                                                                <span class="info-box-text"><i class="mr-1 fab fa-uncharted"></i>Purpose: {{ $purpose }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                                        <div class="info-box">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">
                                                                    <i class="mr-1 fas fas fa-clock"></i><u>Processing Time |</u>
                                                                    
                                                                    @if($date_req != null && $date_rec != null)
                                                                        @php
                                                                            $diff = \Carbon\Carbon::parse($date_req)->diff(\Carbon\Carbon::parse($date_rec));
                                                                            $time = '';
                                                                            
                                                                            if ($diff->d > 0 || $diff->m > 0 || $diff->y > 0) {
                                                                                if($diff->d > 1){
                                                                                    $time .= $diff->format('%a days');
                                                                                }else{
                                                                                    $time .= $diff->format('%a day');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->h > 0) {
                                                                                if($diff->h > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hrs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hr');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->i > 0) {
                                                                                if($diff->i > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i mins');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i min');
                                                                                }
                                                                            }

                                                                            if ($diff->s > 0) {
                                                                                if($diff->s > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s secs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s sec');
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    @else
                                                                        @php $time = ''; @endphp    
                                                                    @endif
                                                                    
                                                                    @if($time == '')
                                                                        <i class="text-sm text-gray">Computed upon request completion...</i>
                                                                    @else
                                                                        {{ $time }}
                                                                    @endif
                                                                </span>

                                                                <span class="info-box-text">
                                                                    <i class="mr-1 fas fa-user-check text-sm"></i>Approval: 

                                                                    @if($date_req != null && $date_app != null)
                                                                        @php
                                                                            $diff = \Carbon\Carbon::parse($date_req)->diff(\Carbon\Carbon::parse($date_app));
                                                                            $time = '';
                                                                            
                                                                            if ($diff->d > 0 || $diff->m > 0 || $diff->y > 0) {
                                                                                if($diff->d > 1){
                                                                                    $time .= $diff->format('%a days');
                                                                                }else{
                                                                                    $time .= $diff->format('%a day');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->h > 0) {
                                                                                if($diff->h > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hrs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hr');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->i > 0) {
                                                                                if($diff->i > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i mins');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i min');
                                                                                }
                                                                            }

                                                                            if ($diff->s > 0) {
                                                                                if($diff->s > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s secs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s sec');
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    @else
                                                                        @php $time = ''; @endphp    
                                                                    @endif
                                                                    
                                                                    @if($time == '')
                                                                        <i class="ml-1 text-sm text-gray">No data available (upon approver's receipt from requester)</i>
                                                                    @else
                                                                        {{ $time }}<i class="ml-1 text-sm text-gray">(upon approver's receipt from requester)</i>
                                                                    @endif
                                                                </span>

                                                                <span class="info-box-text">
                                                                    <i class="mr-1 fas fa-clipboard-check text-sm"></i>Assessment: 

                                                                    @if($date_app != null && $date_ass != null)
                                                                        @php
                                                                            $diff = \Carbon\Carbon::parse($date_app)->diff(\Carbon\Carbon::parse($date_ass));
                                                                            $time = '';
                                                                            
                                                                            if ($diff->d > 0 || $diff->m > 0 || $diff->y > 0) {
                                                                                if($diff->d > 1){
                                                                                    $time .= $diff->format('%a days');
                                                                                }else{
                                                                                    $time .= $diff->format('%a day');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->h > 0) {
                                                                                if($diff->h > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hrs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hr');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->i > 0) {
                                                                                if($diff->i > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i mins');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i min');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->s > 0) {
                                                                                if($diff->s > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s secs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s sec');
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    @else
                                                                        @php $time = ''; @endphp
                                                                    @endif
                                                                    
                                                                    @if($time == '')
                                                                        <i class="ml-1 text-sm text-gray">No data available (upon assessor's receipt from approver)</i>
                                                                    @else
                                                                        {{ $time }}<i class="ml-1 text-sm text-gray">(upon assessor's receipt from approver)</i>
                                                                    @endif
                                                                </span>

                                                                <span class="info-box-text">
                                                                    <i class="mr-1 fas fa-thumbs-up text-sm"></i>Issuance: 

                                                                    @if($date_ass != null && $date_iss != null)
                                                                        @php
                                                                            $diff = \Carbon\Carbon::parse($date_ass)->diff(\Carbon\Carbon::parse($date_iss));
                                                                            $time = '';
                                                                            
                                                                            if ($diff->d > 0 || $diff->m > 0 || $diff->y > 0) {
                                                                                if($diff->d > 1){
                                                                                    $time .= $diff->format('%a days');
                                                                                }else{
                                                                                    $time .= $diff->format('%a day');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->h > 0) {
                                                                                if($diff->h > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hrs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hr');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->i > 0) {
                                                                                if($diff->i > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i mins');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i min');
                                                                                }
                                                                            }

                                                                            if ($diff->s > 0) {
                                                                                if($diff->s > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s secs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s sec');
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    @else
                                                                        @php $time = ''; @endphp
                                                                    @endif
                                                                    
                                                                    @if($time == '')
                                                                        <i class="ml-1 text-sm text-gray">No data available (upon issuer's receipt from assessor)</i>
                                                                    @else
                                                                        {{ $time }}<i class="ml-1 text-sm text-gray">(upon issuer's receipt from assessor)</i>
                                                                    @endif
                                                                </span>

                                                                <span class="info-box-text">
                                                                    <i class="mr-1 fas fa-check-circle text-sm"></i>Receipt: 

                                                                    @if($date_iss != null && $date_rec != null)
                                                                        @php
                                                                            $diff = \Carbon\Carbon::parse($date_iss)->diff(\Carbon\Carbon::parse($date_rec));
                                                                            $time = '';
                                                                            
                                                                            if ($diff->d > 0 || $diff->m > 0 || $diff->y > 0) {
                                                                                if($diff->d > 1){
                                                                                    $time .= $diff->format('%a days');
                                                                                }else{
                                                                                    $time .= $diff->format('%a day');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->h > 0) {
                                                                                if($diff->h > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hrs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%h hr');
                                                                                }
                                                                            }
                                                                            
                                                                            if ($diff->i > 0) {
                                                                                if($diff->i > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i mins');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%i min');
                                                                                }
                                                                            }

                                                                            if ($diff->s > 0) {
                                                                                if($diff->s > 1){
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s secs');
                                                                                }else{
                                                                                    $time .= ($time ? ', ' : '') . $diff->format('%s sec');
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    @else
                                                                        @php $time = ''; @endphp
                                                                    @endif
                                                                    
                                                                    @if($time == '')
                                                                        <i class="ml-1 text-sm text-gray">No data available (upon receiver's receipt from issuer)</i>
                                                                    @else
                                                                        {{ $time }}<i class="ml-1 text-sm text-gray">(upon receiver's receipt from issuer)</i>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="info-box">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><i class="mr-1 fas fa-building-flag"></i>Division: <b>{{ $division }}</b></span>
                                                                <span class="info-box-text"><i class="mr-1 fas fa-building"></i>Requesting office: <b>{{ $office }}</b></span>
                                                                <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Created: <b>{{ \Carbon\Carbon::parse($created_at)->isoFormat('MMMM D, YYYY h:mm A') }}</b></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="info-box">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><i class="mr-1 fas fa-user-tag"></i>Requested by: <b>{{ $requester }} - {{ $position_req }}</b></span>
                                                                @if($date_req != null)
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date requested: <b>{{ \Carbon\Carbon::parse($date_req)->isoFormat('MMMM D, YYYY h:mm A') }}</b></span>
                                                                    @foreach($esig_files->where('user_id','=',$requester_id) as $esig)
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed:<img class="mr-1 ml-2" src="storage/{{ $esig->signature_path }}" width="20" height="20" alt="e-Signature">  <i class="text-sm text-gray">{{ \Carbon\Carbon::parse($date_req)->isoFormat('YYYY MMMM D') }}</i></span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date requested: <i class="text-gray">No info available.</i></span>
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed: <i class="text-gray">No info available.</i></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="info-box">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><i class="mr-1 fas fa-user-check"></i>Approved by: <b>{{ $approver }} - {{ $position_app }}</b></span>
                                                                @if($sign_app == 'true')
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date approved: <b>{{ \Carbon\Carbon::parse($date_app)->isoFormat('MMMM D, YYYY h:mm A') }}</b></span>
                                                                    @foreach($esig_files->where('user_id','=',$approver_id) as $esig)
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed:<img class="mr-1 ml-2" src="storage/{{ $esig->signature_path }}" width="20" height="20" alt="e-Signature">  <i class="text-sm text-gray">{{ \Carbon\Carbon::parse($date_app)->isoFormat('YYYY MMMM D') }}</i></span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date approved: <i class="text-gray">No info available.</i></span>
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed: <i class="text-gray">No info available.</i></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($assessor_id)
                                                        <div class="col-md-4 col-sm-6 col-12">
                                                            <div class="info-box">
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-clipboard-check"></i>Assessed by: <b>{{ $assessor }} - {{ $position_ass }}</b></span>
                                                                    @if($sign_ass == 'true')
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date assessed: <b>{{ \Carbon\Carbon::parse($date_ass)->isoFormat('MMMM D, YYYY h:mm A') }}</b></span>
                                                                        @foreach($esig_files->where('user_id','=',$assessor_id) as $esig)
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed:<img class="mr-1 ml-2" src="storage/{{ $esig->signature_path }}" width="20" height="20" alt="e-Signature">  <i class="text-sm text-gray">{{ \Carbon\Carbon::parse($date_ass)->isoFormat('YYYY MMMM D') }}</i></span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date assessed: <i class="text-gray">No info available.</i></span>
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed: <i class="text-gray">No info available.</i></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($issuer_id)
                                                        <div class="col-md-4 col-sm-6 col-12">
                                                            <div class="info-box">
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-thumbs-up"></i>Issued by: <b>{{ $issuer }} - {{ $position_iss }}</b></span>
                                                                    @if($sign_iss == 'true')
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date issued: <b>{{ \Carbon\Carbon::parse($date_iss)->isoFormat('MMMM D, YYYY h:mm A') }}</b></span>
                                                                        @foreach($esig_files->where('user_id','=',$issuer_id) as $esig)
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed:<img class="mr-1 ml-2" src="storage/{{ $esig->signature_path }}" width="20" height="20" alt="e-Signature">  <i class="text-sm text-gray">{{ \Carbon\Carbon::parse($date_iss)->isoFormat('YYYY MMMM D') }}</i></span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date issued: <i class="text-gray">No info available.</i></span>
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed: <i class="text-gray">No info available.</i></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($receiver_id)
                                                        <div class="col-md-4 col-sm-6 col-12">
                                                            <div class="info-box">
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text"><i class="mr-1 fas fa-check-circle"></i>Received by: <b>{{ $receiver }} - {{ $position_rec }}</b></span>
                                                                    @if($sign_rec == 'true')
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date received: <b>{{ \Carbon\Carbon::parse($date_rec)->isoFormat('MMMM D, YYYY h:mm A') }}</b></span>
                                                                        @foreach($esig_files->where('user_id','=',$receiver_id) as $esig)
                                                                            <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed:<img class="mr-1 ml-2" src="storage/{{ $esig->signature_path }}" width="20" height="20" alt="e-Signature">  <i class="text-sm text-gray">{{ \Carbon\Carbon::parse($date_rec)->isoFormat('YYYY MMMM D') }}</i></span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-calendar-day"></i>Date assessed: <i class="text-gray">No info available.</i></span>
                                                                        <span class="info-box-text"><i class="mr-1 fas fa-signature"></i>Electronically signed: <i class="text-gray">No info available.</i></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <table class="table table-sm table-responsive-sm table-bordered table-hover">
                                                                    <thead class="bg-blue" align="center">
                                                                        <tr>
                                                                            <th width="75%"><i class="mr-1 fas fa-cube"></i>Description</th>
                                                                            <th width="10%"><i class="mr-1 fas fa-hashtag"></i>Qty</th>
                                                                            <th width="15%"><i class="mr-1 fas fa-box"></i>Unit</th>
                                                                        </tr>
                                                                    </thead>
                    
                                                                    <tbody>
                                                                        @php $cur_num = ''; @endphp
                                                                        @foreach($requested_items as $requested_item)
                                                                            @if($cur_num != $requested_item['num']) {{-- if not the same item number --}}
                                                                                <tr>
                                                                                    <td>{{ $requested_item['num'] }}. {{ $requested_item['item'] }} ({{ $requested_item['description'] }})</td>
                                                                                    <td align="center">{{ $requested_item['qty'] }}</td>
                                                                                    <td align="center">{{ $requested_item['unit'] }}</td>
                                                                                </tr>
                                                                                @php $cur_num = $requested_item['num']; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot class="bg-blue" align="center">
                                                                        <tr>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">Total Items: <b>{{ $item_count }}</b> || Total Quantity: <b>{{ $quantity_count }}</b></div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($show_ris_pane == true)
                                        <div class="card card-dark">
                                            <div class="card-header noprint">
                                                <h3 class="card-title"><i class="fas fa-file-alt mr-3"></i>GENERATED RIS [{{ $tcode }}] - RIS No. {{ $risnum }}<br><i class="fas fa-exclamation-circle text-sm text-yellow mr-3 mt-2"></i><i class="text-sm text-yellow">Please print 3 copies of this form.</i></h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" onclick="window.print()">
                                                        <i class="fas fa-print"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-tool" wire:click='hideRISPane' wire:loading.attr="disabled">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <img src="{{ asset('img/header.png') }}" width="100%">

                                                <div class="myform-text-12"><b>REQUISITION AND ISSUE SLIP (RIS)</b></div>

                                                <table align="center" width="100%" cellspacing=0 cellpadding=0><!--head table-->
                                                    <tr>
                                                        <td width="15%" class="myform-text-11-l"><b>Entity Name:</b></td>
                                                        <td width="40%" class="myform-text-11-l"><b><div id="lbEntity" class="mborder-bot">{{ $entity }}&nbsp;</div></b></td>
                                                        <td width="6%"  class="myform-text-11-l"><o:p>&nbsp;</o:p></td>
                                                        <td width="15%" class="myform-text-11-l"><b>Fund Cluster:</b></td>
                                                        <td width="18%"  class="myform-text-11-l"><b><div id="lbFund" class="mborder-bot">{{ $fund }}&nbsp;</div></b></td>
                                                        <td width="6%"  class="myform-text-11-l"><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                </table><!--head table-->

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;"><!--dividing table-->
                                                    <tr><!--line-->
                                                        <td width="15%" class="myform-text-10-l mborder-bot-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="30%" class="myform-text-10-l mborder-bot-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-bot-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="25%" class="myform-text-10-l mborder-bot-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="24%" class="myform-text-10-l mborder-bot-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-bot-2"><o:p>&nbsp;</o:p></td>
                                                    </tr><!--line-->

                                                    <tr><!--div-->
                                                        <td width="15%" class="myform-text-10-l mborder-left-2">&nbsp;Division:</o:p></td>
                                                        <td width="30%" class="myform-text-10-l "><b><div id="lbDivision" class="mborder-bot">{{ $division }}&nbsp;</div></b></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-right-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="25%" class="myform-text-10-l mborder-top-2">&nbsp;Responsibility Center Code:</td>
                                                        <td width="24%" class="myform-text-10-l "><b><div id="lbCenter" class="mborder-bot">{{ $ccode }}&nbsp;</div></b></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-right-2"><o:p>&nbsp;</o:p></td>
                                                    </tr><!--div-->

                                                    <tr><!--ofc-->
                                                        <td width="15%" class="myform-text-10-l mborder-left-2">&nbsp;Office:</td>
                                                        <td width="30%" class="myform-text-10-l "><b><div id="lbOffice" class="mborder-bot">{{ $office }}&nbsp;</div></b></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-right-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="25%" class="myform-text-10-l mborder-left-2">&nbsp;RIS No.:</td>
                                                        <td width="24%" class="myform-text-10-l "><b><div id="lbRISno" class="mborder-bot">{{ $risnum }}&nbsp;</div></b></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-right-2"><o:p>&nbsp;</o:p></td>
                                                    </tr><!--ofc-->
                                                </table><!--dividing table-->

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;">
                                                    <tr><!--req-->
                                                        <td width="48%" class="myform-text-9 mborder-top-2 mborder-bot mborder-left-2"><b>Requisition</b></td>
                                                        <td width="10%"  class="myform-text-9 mborder-top-2 mborder-bot mborder-left-2"><b>Stock Available?</b></td>
                                                        <td width="42%" class="myform-text-9 mborder-top-2 mborder-bot mborder-left-2 mborder-right-2"><b>Issue</b></td>
                                                    </tr><!--req-->
                                                </table><!--req table-->

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
                                                    <tr><!--stock-->
                                                        <td width="8%" class="myform-text-9 mborder-bot mborder-left-2 mborder-right">Stock<br>No.</td>
                                                        <td width="6%" class="myform-text-9 mborder-bot mborder-left mborder-right">Unit</td>
                                                        <td width="25%" class="myform-text-9 mborder-bot mborder-left mborder-right">Description</td>
                                                        <td width="9%" class="myform-text-9 mborder-bot mborder-left mborder-right-2">Quantity</td>
                                                        <td width="5%" class="myform-text-9 mborder-bot mborder-left mborder-right">Yes</td>
                                                        <td width="5%" class="myform-text-9 mborder-bot mborder-left mborder-right-2">No</td>
                                                        <td width="9%" class="myform-text-9 mborder-bot mborder-left mborder-right">Quantity</td>
                                                        <td width="7%" class="myform-text-9 mborder-bot mborder-left mborder-right">Unit Price</td>
                                                        <td width="9%" class="myform-text-9 mborder-bot mborder-left mborder-right">Total</td>
                                                        <td width="17%" class="myform-text-9 mborder-bot mborder-left mborder-right-2">Remarks</td>
                                                    </tr><!--stock-->
                                                </table><!--stock table-->

                                                <table id="stockSelectionTable" align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
                                                    @php $cur_num = ''; @endphp
                                                    @foreach($requested_items as $requested_item)
                                                        @if($cur_num != $requested_item['num'])
                                                            <tr>
                                                                <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >{{ $requested_item['code'] }}</div></td>
                                                                <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >{{ $requested_item['unit'] }}</div></td>
                                                                <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >{{ $requested_item['item'] }} ({{ $requested_item['description'] }})</div></td>
                                                                <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >{{ $requested_item['qty'] }}</div></td>
                                                                <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right">
                                                                    @if($requested_item['avail'] == 'YES')
                                                                    <div >✔</div>
                                                                    @endif
                                                                </td>
                                                                <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2">
                                                                    @if($requested_item['avail'] == 'NO')
                                                                    <div >✔</div>
                                                                    @endif
                                                                </td>
                                                                <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >{{ $requested_item['qtyi'] }}</div></td>
                                                                <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >₱{{ number_format($requested_item['price'],2) }}</div></td>
                                                                <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >₱{{ number_format($requested_item['total'],2) }}</div></td>
                                                                <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >{{ $requested_item['remarks'] }}</div></td>
                                                            </tr>
                                                            @php $cur_num = $requested_item['num']; @endphp
                                                        @else
                                                            <tr>
                                                                <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                                <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                                <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                                <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                                <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right">
                                                                    @if($requested_item['avail'] == 'YES')
                                                                    <div >&nbsp;</div>
                                                                    @endif
                                                                </td>
                                                                <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2">
                                                                    @if($requested_item['avail'] == 'NO')
                                                                    <div >&nbsp;</div>
                                                                    @endif
                                                                </td>
                                                                <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >{{ $requested_item['qtyi'] }}</div></td>
                                                                <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >₱{{ number_format($requested_item['price'],2) }}</div></td>
                                                                <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >₱{{ number_format($requested_item['total'],2) }}</div></td>
                                                                <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >{{ $requested_item['remarks'] }}</div></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table><!--stocksel tbl-->

                                                @if($item_count <= 10)
                                                    <table id="blankRowTable" align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="8%" class="myform-text-8 mborder-bot mborder-left-2 mborder-right"><div >&nbsp;</div></td>
                                                            <td width="6%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="25%" class="myform-text-8-l mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="5%" class="myform-text-8 mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8 mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="7%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="9%" class="myform-text-8-r mborder-bot mborder-left mborder-right"><div >&nbsp;</div></td>
                                                            <td width="17%" class="myform-text-8-l mborder-bot mborder-left mborder-right-2"><div >&nbsp;</div></td>
                                                        </tr>
                                                    </table><!--stocksel tbl-->
                                                @endif

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
                                                    <tr><!--  -->
                                                        <td width="8%" class="myform-text-8 mborder-bot-2 mborder-left-2 mborder-right"><div id="lbSN">&nbsp;</div></td>
                                                        <td width="6%" class="myform-text-8 mborder-bot-2 mborder-left mborder-right"><div id="lbUnit">&nbsp;</div></td>
                                                        <td width="25%" class="myform-text-8-l mborder-bot-2 mborder-left mborder-right"><div id="lbItem">&nbsp;</div></td>
                                                        <td width="9%" class="myform-text-8 mborder-bot-2 mborder-left mborder-right-2"><div id="lbQtyr">&nbsp;</div></td>
                                                        <td width="5%" class="myform-text-8 mborder-bot-2 mborder-left mborder-right"><div id="lbYes">&nbsp;</div></td>
                                                        <td width="5%" class="myform-text-8 mborder-bot-2 mborder-left mborder-right-2"><div id="lbNo">&nbsp;</div></td>
                                                        <td width="9%" class="myform-text-8 mborder-bot-2 mborder-left mborder-right"><div id="lbQtyi">&nbsp;</div></td>
                                                        <td width="7%" class="myform-text-8-r mborder-bot-2 mborder-left mborder-right"><div id="lbPrice">&nbsp;</div></td>
                                                        <td width="9%" class="myform-text-8-r mborder-bot-2 mborder-left mborder-right"><div id="lbTotal">₱{{ number_format($overall_total,2) }}</div></td>
                                                        <td width="17%" class="myform-text-8-l mborder-bot-2 mborder-left mborder-right-2"><div id="lbRem">&nbsp;</div></td>
                                                    </tr><!--  -->
                                                </table><!--stock tbl-->

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
                                                    <tr><!-- purpose 1-->
                                                        <td width="10%" class="myform-text-10-l mborder-bot-2 mborder-left-2">&nbsp;Purpose:</td>
                                                        <td width="87%" class="myform-text-10-l mborder-bot-2"><div id="lbPurpose" class="">{{ $purpose }}&nbsp;</div></td>
                                                        <td width="3%"  class="myform-text-10-l mborder-bot-2 mborder-right-2"><o:p>&nbsp;</o:p></td>
                                                    </tr><!-- purpose 1 -->

                                                    
                                                </table><!--purp tbl-->

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
                                                    <tr>
                                                        <td width="20%" class="myform-text-10-l mborder-right mborder-left-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="20%" class="myform-text-10-l mborder-right"><b>&nbsp;Requested by:</b></td>
                                                        <td width="20%" class="myform-text-10-l mborder-right"><b>&nbsp;Approved by:</b></td>
                                                        <td width="20%" class="myform-text-10-l mborder-right"><b>&nbsp;Issued by:</b></td>
                                                        <td width="20%" class="myform-text-10-l mborder-right-2"><b>&nbsp;Received by:</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" class="myform-text-8-l mborder-right mborder-left-2"><o:p>&nbsp;</o:p></td>
                                                        <td width="20%" class="myform-text-8-l mborder-right"><o:p>&nbsp;</o:p></td>
                                                        <td width="20%" class="myform-text-8-l mborder-right"><o:p>&nbsp;</o:p></td>
                                                        <td width="20%" class="myform-text-8-l mborder-right"><o:p>&nbsp;</o:p></td>
                                                        <td width="20%" class="myform-text-8-l mborder-right-2"><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right mborder-left-2">&nbsp;Signature:</td>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right">
                                                            @foreach($esig_files->where('user_id','=',$requester_id) as $esig)
                                                                @if($sign_req == 'true')
                                                                    <div class="text-center"><img class="no-print" src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right">
                                                            @foreach($esig_files->where('user_id','=',$approver_id) as $esig)
                                                                @if($sign_app == 'true')
                                                                    <div class="text-center"><img class="no-print" src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right">
                                                            @foreach($esig_files->where('user_id','=',$issuer_id) as $esig)
                                                                @if($sign_iss == 'true')
                                                                    <div class="text-center"><img class="no-print" src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right-2">
                                                            @foreach($esig_files->where('user_id','=',$receiver_id) as $esig)
                                                                @if($sign_rec == 'true')
                                                                    <div class="text-center"><img class="no-print" src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right mborder-left-2">&nbsp;Printed Name:</td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right"><div id="lbReqName">{{ $requester }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right"><div id="lbAppName">{{ $approver }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right"><div id="lbIssName">{{ $issuer }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right-2"><div id="lbRecName">{{ $receiver }}&nbsp;</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-right mborder-left-2">&nbsp;Designation:</td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right"><div id="lbReqPos">{{ $position_req }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right"><div id="lbAppPos">{{ $position_app }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right"><div id="lbIssPos">{{ $position_iss }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-right-2"><div id="lbRecPos">{{ $position_rec }}&nbsp;</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" class="myform-text-10-l mborder-top mborder-bot-2 mborder-right mborder-left-2">&nbsp;Date:</td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-bot-2 mborder-right"><div id="lbReqDate">{{ $date_req }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-bot-2 mborder-right"><div id="lbAppDate">{{ $date_app }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-bot-2 mborder-right"><div id="lbIssDate">{{ $date_iss }}&nbsp;</div></td>
                                                        <td width="20%" class="myform-text-8r mborder-top mborder-bot-2 mborder-right-2"><div id="lbRecDate">{{ $date_rec }}&nbsp;</div></td>
                                                    </tr>
                                                </table>

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;">
                                                    <tr>
                                                        <td width="100%" class="myform-text-8-l " ><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                </table>

                                                <table align="center" width="100%" style="line-height: 1; table-layout: fixed;">
                                                    <tr>
                                                        <td width="11%" class="myform-text-9-l mborder-top mborder-left" style="padding-top: 10px; padding-left: 10px;">&nbsp;Form No.</td>
                                                        <td width="2%"  class="myform-text-9-r mborder-top" style="padding-top: 10px;">&nbsp;:</td>
                                                        <td width="20%" class="myform-text-9-l mborder-top mborder-right" style="padding-top: 10px;">&nbsp;FM-JRMSU-RII-03</td>
                                                        <td width="59%" class="myform-text-9-l " ><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="11%" class="myform-text-9-l mborder-left" style="padding-left: 10px;">&nbsp;Issue Status</td>
                                                        <td width="2%"  class="myform-text-9-r " >&nbsp;:</td>
                                                        <td width="20%" class="myform-text-9-l mborder-right" >&nbsp;06</td>
                                                        <td width="59%" class="myform-text-9-l " ><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="11%" class="myform-text-9-l mborder-left" style="padding-left: 10px;">&nbsp;Revision No.</td>
                                                        <td width="2%"  class="myform-text-9-r " >&nbsp;:</td>
                                                        <td width="20%" class="myform-text-9-l mborder-right" >&nbsp;03</td>
                                                        <td width="59%" class="myform-text-9-l " ><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="11%" class="myform-text-9-l mborder-left" style="padding-left: 10px;">&nbsp;Date Effective</td>
                                                        <td width="2%"  class="myform-text-9-r " >&nbsp;:</td>
                                                        <td width="20%" class="myform-text-9-l mborder-right" >&nbsp;10 June 2024</td>
                                                        <td width="59%" class="myform-text-9-l " ><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="11%" class="myform-text-9-l mborder-bot mborder-left" style="padding-bottom: 10px; padding-left: 10px;">&nbsp;Approved by</td>
                                                        <td width="2%"  class="myform-text-9-r mborder-bot" style="padding-bottom: 10px;">&nbsp;:</td>
                                                        <td width="20%" class="myform-text-9-l mborder-bot mborder-right" style="padding-bottom: 10px;">&nbsp;President</td>
                                                        <td width="59%" class="myform-text-9-l " ><o:p>&nbsp;</o:p></td>
                                                    </tr>
                                                </table>
                                                <br><br><br>
                                                <img src="{{ asset('img/footer.png') }}" width="100%">
                                            </div>
                                        </div>
                                    @elseif($show_edit_pane == true)
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-edit mr-3"></i>MODIFY REQUEST [{{ $tcode }}]</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" wire:click='hideEditPane' wire:loading.attr="disabled">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="card card-dark">
                                                            <div class="card-header">
                                                                <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3 text-warning"></i>Request for Supplies and Materials</h3>
                                                            </div>
                        
                                                            <div class="card-body">
                                                                <form>
                                                                    @csrf
                                                                    
                                                                    <div class="row col-12">
                                                                        <div class="col-5">
                                                                            <div class="form-group">
                                                                                <div class="input-group col-md-12">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                                                    </div>
                        
                                                                                    <input type="text" class="form-control form-control-sm" wire:model.live='searchQuery' placeholder="Search here...">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                        
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <div class="input-group col-md-12">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                                                    </div>
                        
                                                                                    <select class="form-control form-control-sm" wire:model.live='pagination'>
                                                                                        <option value="10">10</option>
                                                                                        <option value="25">25</option>
                                                                                        <option value="50">50</option>
                                                                                        <option value="100">100</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                        
                                                                        <div class="col-4">
                                                                            <div class="float-right">
                                                                                <button class="btn btn-sm btn-success" style="cursor: default" disabled>{{ $statMessage }}</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                        
                                                                <table class="table table-bordered table-striped table-sm table-responsive-sm table-hover" style="font-size: 14px">
                                                                    <thead class="bg-blue" align="center">
                                                                        <tr>
                                                                            <th><i class="mr-1 fas fa-qrcode"></i>
                                                                                Code
                                                                                <span wire:click="sortBy('common_supplies.code')" class="float-right" style="cursor: pointer">
                                                                                    <i class="fas fa-arrow-up {{ $sortColumn === 'common_supplies.code' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                                                    <i class="fas fa-arrow-down {{ $sortColumn === 'common_supplies.code' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                                                                </span>
                                                                            </th>
                                                                            <th><i class="mr-1 fas fa-cube"></i>
                                                                                Item
                                                                                <span wire:click="sortBy('common_supplies.item')" class="float-right" style="cursor: pointer">
                                                                                    <i class="fas fa-arrow-up {{ $sortColumn === 'common_supplies.item' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                                                    <i class="fas fa-arrow-down {{ $sortColumn === 'common_supplies.item' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                                                                </span>
                                                                            </th>
                                                                            <th><i class="mr-1 fas fa-feather"></i>Description</th>
                                                                            <th><i class="mr-1 fas fa-clone"></i>
                                                                                Classification
                                                                                <span wire:click="sortBy('categories.category')" class="float-right" style="cursor: pointer">
                                                                                    <i class="fas fa-arrow-up {{ $sortColumn === 'categories.category' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                                                    <i class="fas fa-arrow-down {{ $sortColumn === 'categories.category' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                                                                </span>
                                                                            </th>
                                                                            <th><i class="mr-1 fas fa-box"></i>Unit</th>
                                                                            <th><i class="mr-1 fas fa-tasks"></i></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($common_supplies as $common_supply)
                                                                            @php $total_in = 0; $total_out = 0; $total_stock = 0; @endphp
                                                                            
                                                                            @foreach($inv_ins->where('cs_id','=',$common_supply->cs_id) as $inv_in)
                                                                                @php
                                                                                    $total_in += $inv_in->qty_in;
                                                                                @endphp
                                                                            @endforeach
                        
                                                                            @foreach($inv_outs->where('cs_id','=',$common_supply->cs_id) as $inv_out)
                                                                                @php
                                                                                    $total_out += $inv_out->qty_out;
                                                                                @endphp
                                                                            @endforeach
                        
                                                                            @php
                                                                                $total_stock = $total_in - $total_out;
                                                                            @endphp
                        
                                                                            @if($total_stock > 0)
                                                                                <tr>
                                                                                    <td align="center">{{ $common_supply->cs_code }}</td>
                                                                                    <td>{{ $common_supply->cs_item }}</td>
                                                                                    <td>{{ $common_supply->cs_description }}</td>
                                                                                    <td>{{ $common_supply->cs_category }}</td>
                                                                                    <td>{{ $common_supply->cs_unit }}</td>
                                                                                    <td align="center">
                                                                                        @php
                                                                                            $searchTerm = $common_supply->cs_id;
                                                                                            $found = false;
                        
                                                                                            foreach ($requested_items as $key => $requested_item)
                                                                                            {
                                                                                                if ($requested_item['id'] == $searchTerm) {
                                                                                                    $found = true;
                                                                                                    break;
                                                                                                }
                                                                                            }
                                                                                        @endphp
                                                                                        @if($found == true)
                                                                                            <button class="btn btn-xs bg-green" disabled><i class="fas fa-check-circle mr-1"></i>Added</button>
                                                                                        @else
                                                                                            <button class="btn btn-xs bg-yellow btnPick" id="{{ $common_supply->cs_id }}" wire:ignore wire:click="addToList({{ $common_supply->cs_id }})" wire:loading.attr="disabled"><i class="fas fa-plus-circle mr-1"></i>Add to List</button>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td align="center">{{ $common_supply->cs_code }}</td>
                                                                                    <td>{{ $common_supply->cs_item }}</td>
                                                                                    <td>{{ $common_supply->cs_description }}</td>
                                                                                    <td>{{ $common_supply->cs_category }}</td>
                                                                                    <td>{{ $common_supply->cs_unit }}</td>
                                                                                    <td align="center">
                                                                                        <button class="btn btn-xs bg-light" disabled><i class="fas fa-times mr-1"></i>Unavailable</button>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot class="bg-blue" align="center">
                                                                        <tr>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                        
                                                                <div class="mt-3">
                                                                    {{ $common_supplies->links(data: ['scrollTo' => false]) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-7">
                                                        <div class="card card-dark">
                                                            <div class="card-header">
                                                                <h3 class="card-title"><i class="fas fa-list mr-3 text-warning"></i>Requested Items</h3>
                                                            </div>
                        
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12 text-center">
                                                                        @if($item_count_req <= 0)
                                                                            <span class="badge bg-warning mb-2" style="cursor: default"><i class="icon fas fa-exclamation-circle mr-1"></i>There are no items on your list.</span>
                                                                        @else
                                                                            @if($item_count_req == 1)
                                                                                <span class="badge bg-success mb-2" style="cursor: default"><i class="icon fas fa-check-circle mr-1"></i>You have {{ $item_count_req }} item on your list.</span>
                                                                            @else
                                                                                <span class="badge bg-success mb-2" style="cursor: default"><i class="icon fas fa-check-circle mr-1"></i>You have {{ $item_count_req }} items on your list.</span>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="col-12">
                                                                        <form wire:submit.prevent='validateCSUpdate'>
                                                                            @csrf
                                    
                                                                            <div class="row">
                                                                                <table class="table table-sm table-responsive-sm table-hover">
                                                                                    <thead class="bg-blue" align="center">
                                                                                        <tr>
                                                                                            <th width="70%"><i class="mr-1 fas fa-cube"></i>Description</th>
                                                                                            <th width="10%"><i class="mr-1 fas fa-hashtag"></i>Qty</th>
                                                                                            <th width="15%"><i class="mr-1 fas fa-box"></i>Unit</th>
                                                                                            <th width="5%"><i class="mr-1 fas fa-tasks"></i></th>
                                                                                        </tr>
                                                                                    </thead>
                                        
                                                                                    <tbody>
                                                                                        @foreach($requested_items as $requested_item)
                                                                                            <tr>
                                                                                                <td>{{ $loop->iteration }}. {{ $requested_item['item'] }} ({{ $requested_item['description'] }})</td>
                                                                                                <td align="right"><input type="number" min="1" class="form-control form-control-sm" wire:model="requested_items.{{ $loop->index }}.qty" placeholder="Qty" required></td>
                                                                                                <td>{{ $requested_item['unit'] }}</td>
                                                                                                <td align="right"><button class="btn btn-xs bg-danger" tabindex="-1" style="border-radius: 20px" wire:click.prevent='removeFromList({{ $loop->index }})'>&nbsp;<i class="fas fa-times" wire:loading.attr="disabled"></i>&nbsp;</button></td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                    <tfoot class="bg-blue" align="center">
                                                                                        <tr>
                                                                                            <th></th>
                                                                                            <th></th>
                                                                                            <th></th>
                                                                                            <th></th>
                                                                                        </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
                            
                                                                            @if($item_count_req > 0)
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label for="division">&nbsp;&nbsp;&nbsp;Division:</label>
                                                                                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-building-flag"></i></span>
                                                                                                </div>
                                                                                                
                                                                                                <select class="form-control" wire:model='division' id="division" required autofocus>
                                                                                                    <option value="" class="text-blue">••• Please select a division:</option>
                                                                                                    @foreach($divisions as $division)
                                                                                                        <option value="{{ $division->division }}">{{ $division->division }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                            
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label for="office">&nbsp;&nbsp;&nbsp;Office/Unit:</label>
                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                                                </div>
                            
                                                                                                <input type="text" class="form-control" wire:model='office' id="office" placeholder="Office/Unit name" required disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                            
                                                                                    <div class="col-12">
                                                                                        <div class="form-group">
                                                                                            <label for="purpose">&nbsp;&nbsp;&nbsp;Purpose:</label>
                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                                                                                </div>
                            
                                                                                                <input type="text" class="form-control" wire:model='purpose' id="purpose" placeholder="State purpose of request" required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                            
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label for="requester">&nbsp;&nbsp;&nbsp;Requested by:</label>
                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                                                                </div>
                            
                                                                                                <input type="text" class="form-control" wire:model='requester' id="requester" placeholder="Requester name" required disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                            
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label for="position_req">&nbsp;&nbsp;&nbsp;Position/Designation:</label>
                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                                                </div>
                            
                                                                                                <input type="text" class="form-control" wire:model='position_req' id="position_req" placeholder="Requester position" required disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                            
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label for="approver_id">&nbsp;&nbsp;&nbsp;Approved by: (select your supervisor)</label>
                                                                                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                                                                                </div>
                                                                                                
                                                                                                <select class="form-control" wire:model='approver_id' id="approver_id" wire:click='getAppPos' required>
                                                                                                    <option value="" class="text-blue">••• Please select an approver:</option>
                                                                                                    @foreach($users as $user)
                                                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                            
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label for="position_app">&nbsp;&nbsp;&nbsp;Position/Designation:</label>
                            
                                                                                            <div class="input-group col-md-12">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                                                </div>
                            
                                                                                                <input type="text" class="form-control" wire:model='position_app' id="position_app" placeholder="Select approver to auto generate" required disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                            
                                                                                <div class="row">
                                                                                    <div class="col-12" align="center">
                                                                                        <button type="submit" class="btn bg-blue">
                                                                                            <i class="nav-icon fas fa-arrow-circle-up mr-1"></i>
                                                                                            Update Request
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else {{-- main --}}
                                        <div class="col-12 col-sm-12">
                                            <div class="card card-blue card-tabs">
                                            <div class="card-header p-0 pt-1">
                                                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                                    <li class="pt-2 px-3"><h3 class="card-title">REQUESTS</h3></li>

                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-two-approved-tab" data-toggle="pill" href="#custom-tabs-two-approved" role="tab" aria-controls="custom-tabs-two-approved" aria-selected="true"><i class="fas fa-handshake mr-2"></i>Shared</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-two-tabContent">
                                                    <div class="tab-pane fade show active" id="custom-tabs-two-approved" role="tabpanel" aria-labelledby="custom-tabs-two-approved-tab">
                                                        {{-- requests you approved / shared with you --}}
                                                        @if (count($approvals) != 0)
                                                            <div class="timeline">
                                                                @foreach ($unique_dates_app as $unique_date_app)
                                                                    <div class="time-label">
                                                                        <span class="bg-yellow">&nbsp;{{ \Carbon\Carbon::parse($unique_date_app->date_app)->format('F j, Y') }}&nbsp;</span>
                                                                    </div>

                                                                    @foreach ($approvals->where('date_app','=',$unique_date_app->date_app) as $approval)
                                                                        <div>
                                                                            @if ($approval->status == 'FOR APPROVAL')
                                                                                <i class="fas fa-user-check bg-yellow"></i>
                                                                            @elseif($approval->status == 'FOR ASSESSMENT')
                                                                                <i class="fas fa-clipboard-check bg-maroon"></i>
                                                                            @elseif ($approval->status == 'FOR ISSUANCE')
                                                                                <i class="fas fa-thumbs-up bg-blue"></i>
                                                                            @elseif ($approval->status == 'COMPLETED')
                                                                                @if($approval->date_rec)
                                                                                    <i class="fas fa-check-circle bg-green"></i>
                                                                                @else
                                                                                    <i class="fas fa-xmark-circle bg-red"></i>
                                                                                @endif
                                                                            @endif

                                                                            <div class="timeline-item">
                                                                                <span class="time"><i class="fas fa-ticket-alt mr-1"></i>{{ $approval->tcode }} • Created: {{ \Carbon\Carbon::parse($approval->created_at)->isoFormat('MMMM D, YYYY h:mm A') }} <i>({{ \Carbon\Carbon::parse($approval->created_at)->diffForHumans(\Carbon\Carbon::now(),true) }} ago)</i></span>

                                                                                @if ($approval->status == 'FOR APPROVAL')
                                                                                    <h3 class="timeline-header">
                                                                                        <a class="text-yellow mr-1">
                                                                                            {{ $approval->status }}: {{ $approval->division }} - {{ $approval->office }} <span class="text-gray"></span>

                                                                                            @if($approval->type == 'standard')
                                                                                                &nbsp;<span class="badge bg-indigo">Standard</span>
                                                                                            @else
                                                                                                &nbsp;<span class="badge bg-fuchsia">Project</span>
                                                                                            @endif
                                                                                        </a>
                                                                                    </h3>
                                                                                @elseif ($approval->status == 'FOR ASSESSMENT')
                                                                                    <h3 class="timeline-header">
                                                                                        <a class="text-maroon mr-1">
                                                                                            {{ $approval->status }}: {{ $approval->division }} - {{ $approval->office }} <span class="text-gray"></span>

                                                                                            @if($approval->type == 'standard')
                                                                                                &nbsp;<span class="badge bg-indigo">Standard</span>
                                                                                            @else
                                                                                                &nbsp;<span class="badge bg-fuchsia">Project</span>
                                                                                            @endif
                                                                                        </a>
                                                                                    </h3>
                                                                                @elseif ($approval->status == 'FOR ISSUANCE')
                                                                                    <h3 class="timeline-header">
                                                                                        <a class="text-blue mr-1">
                                                                                            {{ $approval->status }}: {{ $approval->division }} - {{ $approval->office }} <span class="text-gray"></span>

                                                                                            @if($approval->type == 'standard')
                                                                                                &nbsp;<span class="badge bg-indigo">Standard</span>
                                                                                            @else
                                                                                                &nbsp;<span class="badge bg-fuchsia">Project</span>
                                                                                            @endif
                                                                                        </a>
                                                                                    </h3>
                                                                                @elseif ($approval->status == 'COMPLETED')
                                                                                    <h3 class="timeline-header">
                                                                                        <a class="text-green mr-1">
                                                                                            {{ $approval->status }}: {{ $approval->division }} - {{ $approval->office }} <span class="text-gray"></span>

                                                                                            @if($approval->type == 'standard')
                                                                                                &nbsp;<span class="badge bg-indigo">Standard</span>
                                                                                            @else
                                                                                                &nbsp;<span class="badge bg-fuchsia">Project</span>
                                                                                            @endif

                                                                                            @if($approval->date_rec)
                                                                                                <span class="badge bg-green">Issuance is confirmed by receiver</span>
                                                                                            @else
                                                                                                <span class="badge bg-red">Issuance is not confirmed by receiver</span>
                                                                                            @endif
                                                                                        </a>
                                                                                    </h3>
                                                                                @endif
            
                                                                                <div class="timeline-body">
                                                                                    <div class="row mb-2">
                                                                                        <div class="col-12 mb-1">
                                                                                            <b class="text-gray">Purpose: </b>{{ $approval->purpose }}
                                                                                        </div>

                                                                                        <div class="col-6">
                                                                                            @foreach($system_users->where('id','=',$approval->requester_id) as $system_user_req)
                                                                                                <img src="{{ $system_user_req->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                <b class="text-gray">Requester:</b>
                                                                                                <b>{{ $approval->requester }} - {{ $approval->position_req }}</b>
                                                                                            @endforeach
                                                                                        </div>
            
                                                                                        <div class="col-6">
                                                                                            @foreach($system_users->where('id','=',$approval->approver_id) as $system_user_app)
                                                                                                <img src="{{ $system_user_app->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                <b class="text-gray">Approver:</b>
                                                                                                <b>{{ $approval->approver }} - {{ $approval->position_app }} <span class="text-blue">(You)</span></b>
                                                                                            @endforeach
                                                                                        </div>

                                                                                        @if ($approval->assessor_id != '0')
                                                                                            <div class="col-6">
                                                                                                @foreach($system_users->where('id','=',$approval->assessor_id) as $system_user_ass)
                                                                                                    <img src="{{ $system_user_ass->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                    <b class="text-gray">Assessor: </b>
                                                                                                    <b>{{ $approval->assessor }} - {{ $approval->position_ass }}</b>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif

                                                                                        @if ($approval->issuer_id != null or $approval->issuer_id != '')
                                                                                            <div class="col-6">
                                                                                                @foreach($system_users->where('id','=',$approval->issuer_id) as $system_user_iss)
                                                                                                    <img src="{{ $system_user_iss->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                    <b class="text-gray">Issuer: </b>
                                                                                                    <b>{{ $approval->issuer }} - {{ $approval->position_iss }}</b>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif

                                                                                        @if ($approval->receiver_id != null or $approval->receiver_id != '')
                                                                                            <div class="col-6">
                                                                                                @foreach($system_users->where('id','=',$approval->receiver_id) as $system_user_rec)
                                                                                                    <img src="{{ $system_user_rec->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                    <b class="text-gray">Receiver: </b>
                                                                                                    <b>{{ $approval->receiver }} - {{ $approval->position_rec }}</b>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
            
                                                                                    <div class="row border-top">
                                                                                        <div class="col-12 mt-2">
                                                                                            @if ($approval->status == 'FOR APPROVAL')
                                                                                                <button class="btn bg-blue btn-sm" style="border-radius: 20px" wire:click='viewRequestDetails({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-eye mr-1"></i>View Request Details</button>
                                                                                                @if($approval->approved == 'no')
                                                                                                    <button class="btn bg-lightblue btn-sm" style="border-radius: 20px" wire:click='setReturnRequest({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-redo mr-1"></i>Return to Requester</button>
                                                                                                    <button class="btn bg-pink btn-sm" style="border-radius: 20px" wire:click='setApproveRequest({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-thumbs-up mr-1"></i>Approve Request</button>
                                                                                                @endif
                                                                                            @elseif ($approval->status == 'FOR ASSESSMENT')
                                                                                                <button class="btn bg-blue btn-sm" style="border-radius: 20px" wire:click='viewRequestDetails({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-eye mr-1"></i>View Request Details</button>
                                                                                            @elseif ($approval->status == 'FOR ISSUANCE')
                                                                                                <button class="btn bg-blue btn-sm" style="border-radius: 20px" wire:click='viewRequestDetails({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-eye mr-1"></i>View Request Details</button>
                                                                                                @if($approval->ris_generation == 'yes')
                                                                                                    <button class="btn bg-lightblue btn-sm" style="border-radius: 20px" wire:click='viewGeneratedRIS({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-file-alt mr-1"></i>View Generated RIS</button>
                                                                                                @endif    
                                                                                            @elseif ($approval->status == 'COMPLETED')
                                                                                                <button class="btn bg-green btn-sm" style="border-radius: 20px" wire:click='viewRequestDetails({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-eye mr-1"></i>View Request Details</button>
                                                                                                <button class="btn bg-blue btn-sm" style="border-radius: 20px" wire:click='viewGeneratedRIS({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-file-alt mr-1"></i>View Digital RIS</button>
                                                                                                @if($approval->date_rec)
                                                                                                    <button class="btn bg-maroon btn-sm" style="border-radius: 20px" wire:click='openRIS({{ $approval->id }})' wire:loading.attr="disabled"><i class="fas fa-file-pdf mr-1"></i>View as PDF file</button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endforeach

                                                                <div>
                                                                    <i class="fas fa-handshake bg-gray"></i>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <i class="fas fa-info-circle mr-2"></i>You have no approved requests as of the moment.
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card -->
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </section>

            @include('includes.btt')
        </div>

        @include('includes.foot')

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    @include('includes.footer')

    @livewireScripts
</body>

@script
    <script>
        $('#nav-request').addClass('active');
        $('#nav-request-parent').addClass('menu-open');
        $('#nav-request-shared').addClass('active');

        document.addEventListener("contextmenu", function(event){
            if (event.target.tagName === "IMG") {
                event.preventDefault();
            }
        });

        document.addEventListener("dragstart", function(event){
            if (event.target.tagName === "IMG") {
                event.preventDefault();
            }
        });

        Livewire.on('triggerSubmit', t_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This request will be submitted to the supply office and you will not be able to make changes anymore.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit this request!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('submit_confirm', true);
                }
            });
        });

        Livewire.on('triggerApprove', t_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This request will be approved.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve this request!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('approve_confirm', true);
                }
            });
        });

        Livewire.on('triggerReturn', t_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This request will be returned to the requester.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, return this request!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('return_confirm', true);
                }
            });
        });

        Livewire.on('triggerDelete', t_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This request will be deleted and this action cannot be reverted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete this request!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('delete_confirm', true);
                }
            });
        });

        Livewire.on('triggerOpen', tcode => {
            const url = `/report/ris/${tcode}`;
            window.open(url, '_blank');
        });
    </script>
@endscript