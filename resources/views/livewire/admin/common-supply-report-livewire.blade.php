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
                        <div class="col-md-12 mt-3">
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
                            
                            @if($show_stock_card == true)
                                <div class="card card-blue">
                                    <div class="card-header noprint">
                                        <h3 class="card-title"><i class="fas fa-file-alt mr-3"></i>STOCK CARD [{{ $code }}] : {{ $item }} ({{ $description }})</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" onclick="window.print()">
                                                <i class="fas fa-print"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                <i class="fas fa-expand"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" wire:click='hideStockCard'>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <img src="{{ asset('img/header.png') }}" width="100%">

                                        <div class="myform-text-12"><b>STOCK CARD</b></div>

                                        <table align="center" width="100%" cellspacing=0 cellpadding=0><!--head table-->
                                            <tr>
                                                <td width="3%"  class="myform-text-11-l"><o:p>&nbsp;</o:p></td>
                                                <td width="15%" class="myform-text-11-l">Entity Name:</td>
                                                <td width="40%" class="myform-text-11-l"><div class="mborder-bot">&nbsp;<b>{{ $entity }}</b></div></td>
                                                <td width="6%"  class="myform-text-11-l"><o:p>&nbsp;</o:p></td>
                                                <td width="15%" class="myform-text-11-l">Fund Cluster:</td>
                                                <td width="18%"  class="myform-text-11-l"><div class="mborder-bot">&nbsp;<b>{{ $fund }}</b></div></td>
                                                <td width="3%"  class="myform-text-11-l"><o:p>&nbsp;</o:p></td>
                                            </tr>
                                        </table><!--head table-->

                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;"><!--dividing table-->
                                            <tr>
                                                <td width="1%"><o:p>&nbsp;</o:p></td>
                                                <td width="9%"><o:p>&nbsp;</o:p></td>
                                                <td width="60%"><o:p>&nbsp;</o:p></td>
                                                <td width="1%"><o:p>&nbsp;</o:p></td>
                                                <td width="9%"><o:p>&nbsp;</o:p></td>
                                                <td width="19%"><o:p>&nbsp;</o:p></td>
                                                <td width="1%"><o:p>&nbsp;</o:p></td>
                                            </tr>

                                            <tr>
                                                <td width="1%" class="myform-text-11-l mborder-top mborder-left"><o:p>&nbsp;</o:p></td>
                                                <td width="9%" class="myform-text-11-l mborder-top">Item:</td>
                                                <td width="60%" class="myform-text-11-l mborder-top"><div class="mborder-bot">&nbsp;<b>{{ $item }}</b></div></td>
                                                <td width="1%" class="myform-text-11-l mborder-top"></td>
                                                <td width="15%" class="myform-text-11-l mborder-top">Stock No.:</td>
                                                <td width="13%" class="myform-text-11-l mborder-top"><div class="mborder-bot">&nbsp;<b>{{ $code }}</b></div></td>
                                                <td width="1%" class="myform-text-11-l mborder-top mborder-right"><o:p>&nbsp;</o:p></td>
                                            </tr>

                                            <tr>
                                                <td width="1%" class="myform-text-11-l mborder-bot mborder-left"><o:p>&nbsp;</o:p></td>
                                                <td width="9%" class="myform-text-11-l mborder-bot">Description:</td>
                                                <td width="60%" class="myform-text-11-l mborder-bot"><div class="mborder-bot">&nbsp;<b>{{ $description }}</b></div></td>
                                                <td width="1%" class="myform-text-11-l mborder-bot"></td>
                                                <td width="15%" class="myform-text-11-l mborder-bot">Re-order Point:</td>
                                                <td width="13%" class="myform-text-11-l mborder-bot"><div class="mborder-bot">&nbsp;</div></td>
                                                <td width="1%" class="myform-text-11-l mborder-bot mborder-right"><o:p>&nbsp;</o:p></td>
                                            </tr>
                                        </table><!--dividing table-->

                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;">
                                            <tr>
                                                <td width="1%" class="myform-text-11-l mborder-bot mborder-left"><o:p>&nbsp;</o:p></td>
                                                <td width="20%" class="myform-text-11-l mborder-bot">Unit of Measurement:</td>
                                                <td width="78%" class="myform-text-11-l mborder-bot"><div class="mborder-bot">&nbsp;<b>{{ $unit }}</b></div></td>
                                                <td width="1%" class="myform-text-11-l mborder-bot mborder-right"><o:p>&nbsp;</o:p></td>
                                            </tr>
                                        </table>

                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;">
                                            <tr align="center">
                                                <td width="16%" class="myform-text-11-l mborder-bot mborder-left" rowspan="2">Date</td>
                                                <td width="18%" class="myform-text-11-l mborder-bot mborder-left" rowspan="2">Reference</td>
                                                <td width="10%" class="myform-text-11-l mborder-bot mborder-left">Receipt</td>
                                                <td width="20%" class="myform-text-11-l mborder-bot mborder-left" colspan="2">Issue</td>
                                                <td width="18%" class="myform-text-11-l mborder-bot mborder-left">Balance</td>
                                                <td width="18%" class="myform-text-11-l mborder-bot mborder-left mborder-right" rowspan="2">No. of Days to Consume</td>
                                            </tr>

                                            <tr align="center">
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left">QTY</td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left">QTY</td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left">Office</td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left">QTY</td>
                                            </tr>
                                        </table>

                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;"><!--main table-->
                                            @php $currentBalance = 0; $rec_ctr = 0; @endphp

                                            @foreach ($merged_dates as $merged_date)
                                                @foreach ($r_items->where('cs_id','=',$c_id)->where('date_acquired','=',$merged_date->date) as $r_item)
                                                    @php $currentBalance += $r_item->qty_in; @endphp
                                                    
                                                    <tr>
                                                        <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;<b>{{ $r_item->date_acquired }}</b></div></td>
                                                        <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;<b>{{ $r_item->reference }}</b></div></td>
                                                        <td width="10%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;<b>{{ $r_item->qty_in }}</b></div></td>
                                                        <td width="10%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;</div></td>
                                                        <td width="10%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;</div></td>
                                                        <td width="18%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;<b>{{ $currentBalance }}</b></div></td>
                                                        <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right" align="center"><div>&nbsp;</div></td>
                                                    </tr>

                                                    @php $rec_ctr ++; @endphp
                                                @endforeach

                                                @foreach ($i_items->where('id','=',$c_id)->where('date_released','=',$merged_date->date) as $i_item)
                                                    @php $currentBalance -= $i_item->qty_out; @endphp
                                                    
                                                    <tr>
                                                        <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;<b>{{ $i_item->date_released }}</b></div></td>
                                                        <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;<b>RIS {{ $i_item->risnum }}</b></div></td>
                                                        <td width="10%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;</div></td>
                                                        <td width="10%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;<b>{{ $i_item->qty_out }}</b></div></td>
                                                        <td width="10%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;<b>{{ $i_item->office }}</b></div></td>
                                                        <td width="18%" class="myform-text-10-l mborder-bot mborder-left" align="center"><div>&nbsp;<b>{{ $currentBalance }}</b></div></td>
                                                        <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right" align="center"><div>&nbsp;</div></td>
                                                    </tr>

                                                    @php $rec_ctr ++; @endphp
                                                @endforeach
                                            @endforeach
                                        </table>

                                        @if($rec_ctr <= 10)
                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;"><!--blank table-->
                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>

                                            <tr>
                                                <td width="16%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="10%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left"><div>&nbsp;</div></td>
                                                <td width="18%" class="myform-text-10-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                                            </tr>
                                        </table>
                                        @endif

                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;">
                                            <tr>
                                                <td width="100%" class="myform-text-8-l " ><o:p>&nbsp;</o:p></td>
                                            </tr>
                                        </table>

                                        <table align="center" width="100%" style="line-height: 1; table-layout:auto;">
                                            <tr>
                                                <td width="11%" class="myform-text-9-l mborder-top mborder-left" style="padding-top: 10px; padding-left: 10px;">&nbsp;Form No.</td>
                                                <td width="2%"  class="myform-text-9-r mborder-top" style="padding-top: 10px;">&nbsp;:</td>
                                                <td width="20%" class="myform-text-9-l mborder-top mborder-right" style="padding-top: 10px;">&nbsp;FM-JRMSU-RIA-02</td>
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
                                                <td width="20%" class="myform-text-9-l mborder-right" >&nbsp;02</td>
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
                            @elseif($show_advanced_stock_card == true)
                                <div class="card card-blue">
                                    <div class="card-header noprint">
                                        <h3 class="card-title"><i class="fas fa-file-invoice mr-3"></i>ADVANCED STOCK CARD [{{ $code }}] : {{ $item }} ({{ $description }})</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" onclick="window.print()">
                                                <i class="fas fa-print"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                <i class="fas fa-expand"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" wire:click='hideAdvancedStockCard'>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6><b><u>SUPPLIES AND MATERIALS STOCK CARD</u></b></h6>
                                                <h6><b>STOCK NO. {{ strToUpper($code) }} : {{ strToUpper($item) }} ({{ strToUpper($description) }})</b></h6>
                                            </div>

                                            <div class="col-4">
                                                <div class="float-right">
                                                    <img src="{{ asset('img/siis-logo.png') }}" height="50px"/>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <table class="table table-bordered table-striped table-sm table-responsive-sm table-hover" style="font-size: 14px">
                                                    <tr class="bg-blue" align="center">
                                                        <th width="12%" rowspan="2">DATE</th>
                                                        <th width="16%" rowspan="2">REFERENCE NO.</th>
                                                        <th colspan="3">PURCHASE</th>
                                                        <th colspan="3">ISSUED</th>
                                                        <th colspan="3">BALANCE</th>
                                                    </tr>

                                                    <tr align="center">
                                                        <th width="6%">Qty</th>
                                                        <th width="8%">Unit Cost</th>
                                                        <th width="10%">Total</th>
                                                        <th width="6%">Qty</th>
                                                        <th width="8%">Unit Cost</th>
                                                        <th width="10%">Total</th>
                                                        <th width="6%">Qty</th>
                                                        <th width="8%">Unit Cost</th>
                                                        <th width="10%">Total</th>
                                                    </tr>

                                                    @php $currentBalance = 0; $currentCost = 0; $currentTotal = 0; @endphp

                                                    @foreach ($merged_dates as $merged_date)
                                                        @foreach ($r_items->where('cs_id','=',$c_id)->where('date_acquired','=',$merged_date->date) as $r_item)
                                                            @php $currentBalance += $r_item->qty_in; $currentCost = $r_item->qty_in * $r_item->price_in; $currentTotal += $currentCost; @endphp
                                                            
                                                            <tr>
                                                                <td>{{ $r_item->date_acquired }}</td>
                                                                <td>{{ $r_item->reference }}</td>
                                                                <td align="center">{{ $r_item->qty_in }}</td>
                                                                <td align="right">₱{{ $r_item->price_in }}</td>
                                                                <td align="right">₱{{ number_format($currentCost,2) }}</td>
                                                                <td align="center"></td>
                                                                <td align="right"></td>
                                                                <td align="right"></td>
                                                                <td style="color: #032e59" align="center">{{ $currentBalance }}</td>
                                                                {{-- <td style="color: #032e59" align="right">₱{{ number_format($currentTotal / $currentBalance,2) }}</td> --}}
                                                                <td style="color: #032e59" align="right">₱{{ $r_item->price_in }}</td>
                                                                <td style="color: #032e59" align="right">₱{{ number_format($currentTotal,2) }}</td>
                                                            </tr>
                                                        @endforeach

                                                        @foreach ($i_items->where('id','=',$c_id)->where('date_released','=',$merged_date->date) as $i_item)
                                                            @php $currentBalance -= $i_item->qty_out; $currentCost = $i_item->qty_out * $i_item->price_out; $currentTotal -= $currentCost; @endphp
                                                            
                                                            <tr>
                                                                <td>{{ $i_item->date_released }}</td>
                                                                <td>RIS {{ $i_item->risnum }}</td>
                                                                <td align="center"></td>
                                                                <td align="right"></td>
                                                                <td align="right"></td>
                                                                <td align="center">{{ $i_item->qty_out }}</td>
                                                                <td align="right">₱{{ $i_item->price_out }}</td>
                                                                <td align="right">₱{{ number_format($currentCost,2) }}</td>
                                                                <td class="text-maroon" align="center">{{ $currentBalance }}</td>
                                                                {{-- <td class="text-maroon" align="right">₱{{ number_format($currentTotal / $currentBalance,2) }}</td> --}}
                                                                <td class="text-maroon" align="right">₱{{ $i_item->price_out }}</td>
                                                                <td class="text-maroon" align="right">₱{{ number_format($currentTotal,2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3 text-warning"></i>Supplies and Materials Record</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                <i class="fas fa-expand"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form>
                                            @csrf
                                            
                                            <div class="row col-12">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="input-group col-md-12">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                            </div>

                                                            <input type="text" class="form-control form-control-sm" wire:model.live='searchQuery' placeholder="Search here...">
                                                        </div>
                                                    </div>
                                                </div>
                
                                                <div class="col-2">
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
                                                    <th width="12%"><i class="mr-1 fas fa-tasks"></i>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($common_supplies as $common_supply)
                                                    <tr>
                                                        <td align="center">{{ $common_supply->cs_code }}</td>
                                                        <td>{{ $common_supply->cs_item }}</td>
                                                        <td>{{ $common_supply->cs_description }}</td>
                                                        <td>{{ $common_supply->cs_category }}</td>
                                                        <td align="center">
                                                            <button class="btn btn-xs bg-green" wire:click="viewStockCard({{ $common_supply->cs_id }})"><i class="fas fa-file-alt mr-1" style="cursor: pointer"></i>Stock Card</button>
                                                            <button class="btn btn-xs bg-lightblue" wire:click="viewAdvancedStockCard({{ $common_supply->cs_id }})"><i class="fas fa-file-invoice mr-1" style="cursor: pointer"></i>Advanced SC</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-blue" align="center">
                                                <tr>
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
                            @endif
                        </div>
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
        $('#nav-report').addClass('active');
        $('#nav-report-parent').addClass('menu-open');
        $('#nav-report-cs').addClass('active');
    </script>
@endscript