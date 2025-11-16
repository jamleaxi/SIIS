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
                                    @if($show_ris_pane == true)
                                        <div class="card card-dark">
                                            <div class="card-header noprint">
                                                <h3 class="card-title"><i class="fas fa-file-alt mr-3"></i>GENERATED RIS [{{ $tcode }}] - RIS No. {{ $risnum }}</h3>

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
                                    @else {{-- main --}}
                                        <div class="col-12 col-sm-12">
                                            <div class="card card-blue card-tabs">
                                            <div class="card-header p-0 pt-1">
                                                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                                    <li class="pt-2 px-3"><h3 class="card-title">SUPPLIES</h3></li>

                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-two-received-tab" data-toggle="pill" href="#custom-tabs-two-received" role="tab" aria-controls="custom-tabs-two-issued" aria-selected="true"><i class="fas fa-check-circle mr-2"></i>Received</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-two-tabContent">
                                                    <div class="tab-pane fade show active" id="custom-tabs-two-received" role="tabpanel" aria-labelledby="custom-tabs-two-received-tab">
                                                        {{-- received requests --}}
                                                        @if (count($receivals) != 0)
                                                            <div class="timeline">
                                                                @foreach ($unique_dates_rec as $unique_date_rec)
                                                                    <div class="time-label">
                                                                        <span class="bg-yellow">&nbsp;{{ \Carbon\Carbon::parse($unique_date_rec->date_rec)->format('F j, Y') }}&nbsp;</span>
                                                                    </div>

                                                                    @foreach ($receivals->where('date_rec','=',$unique_date_rec->date_rec) as $receival)
                                                                        <div>
                                                                            <i class="fas fa-check-circle bg-green"></i>

                                                                            <div class="timeline-item">
                                                                                <span class="time"><i class="fas fa-clock"> {{ $receival->created_at }} ({{ \Carbon\Carbon::parse($receival->created_at)->diffForHumans(\Carbon\Carbon::now(),true) }} ago)</i></span>

                                                                                @if ($receival->status == 'COMPLETED')
                                                                                    <h3 class="timeline-header">
                                                                                        <a class="text-green mr-1">
                                                                                            {{ $receival->status }}: {{ $receival->division }} - {{ $receival->office }} <span class="text-gray">| <i class="fas fa-ticket-alt"></i> {{ $receival->tcode }}</span>

                                                                                            @if($receival->accepted == 'yes')
                                                                                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Accepted by Supply Office</span>
                                                                                            @elseif($receival->accepted == 'no')
                                                                                                <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i>Rejected by Supply Office</span>
                                                                                            @else
                                                                                                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Pending for Acceptance</span>
                                                                                            @endif

                                                                                            @if($receival->type == 'standard')
                                                                                                &nbsp;<span class="badge bg-indigo">Standard</span>
                                                                                            @else
                                                                                                &nbsp;<span class="badge bg-fuchsia">Project</span>
                                                                                            @endif
                                                                                        </a>
                                                                                    </h3>
                                                                                @endif
            
                                                                                <div class="timeline-body">
                                                                                    <div class="row mb-2">
                                                                                        <div class="col-12 mb-1">
                                                                                            <b class="text-gray">Purpose: </b>{{ $receival->purpose }}
                                                                                        </div>

                                                                                        <div class="col-6">
                                                                                            @foreach($system_users->where('id','=',$receival->requester_id) as $system_user_req)
                                                                                                <img src="{{ $system_user_req->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                <b class="text-gray">Requester:</b>
                                                                                                <b>{{ $receival->requester }} - {{ $receival->position_req }}</b>
                                                                                            @endforeach
                                                                                        </div>
            
                                                                                        <div class="col-6">
                                                                                            @foreach($system_users->where('id','=',$receival->approver_id) as $system_user_app)
                                                                                                <img src="{{ $system_user_app->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                <b class="text-gray">Approver:</b>
                                                                                                <b>{{ $receival->approver }} - {{ $receival->position_app }}</b>
                                                                                            @endforeach
                                                                                        </div>

                                                                                        @if ($receival->assessor_id != '0')
                                                                                            <div class="col-6">
                                                                                                @foreach($system_users->where('id','=',$receival->assessor_id) as $system_user_ass)
                                                                                                    <img src="{{ $system_user_ass->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                    <b class="text-gray">Assessor: </b>
                                                                                                    <b>{{ $receival->assessor }} - {{ $receival->position_ass }}</b>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif

                                                                                        @if ($receival->issuer_id != null or $receival->issuer_id != '')
                                                                                            <div class="col-6">
                                                                                                @foreach($system_users->where('id','=',$receival->issuer_id) as $system_user_iss)
                                                                                                    <img src="{{ $system_user_iss->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                    <b class="text-gray">Issuer: </b>
                                                                                                    <b>{{ $receival->issuer }} - {{ $receival->position_iss }}</b>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif

                                                                                        @if ($receival->receiver_id != null or $receival->receiver_id != '')
                                                                                            <div class="col-6">
                                                                                                @foreach($system_users->where('id','=',$receival->receiver_id) as $system_user_rec)
                                                                                                    <img src="{{ $system_user_rec->profile_photo_url }}" class="img-circle mr-1" width="20" height="20">
                                                                                                    <b class="text-gray">Receiver: </b>
                                                                                                    <b>{{ $receival->receiver }} - {{ $receival->position_rec }} <span class="text-blue">(You)</span></b>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
            
                                                                                    <div class="row border-top">
                                                                                        <div class="col-12 mt-2">
                                                                                            @if ($receival->status == 'COMPLETED')
                                                                                                <button class="btn bg-blue btn-sm" style="border-radius: 20px" wire:click='viewGeneratedRIS({{ $receival->id }})' wire:loading.attr="disabled"><i class="fas fa-file-alt mr-1"></i>View Accomplished RIS</a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endforeach

                                                                <div>
                                                                    <i class="fas fa-check-circle bg-gray"></i>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <i class="fas fa-info-circle mr-2"></i>You have no received supplies as of the moment.
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
        $('#nav-issuance').addClass('active');
        $('#nav-issuance-parent').addClass('menu-open');
        $('#nav-issuance-supply').addClass('active');

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
    </script>
@endscript