<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ public_path('dist/css/adminlte.css') }}">

    <style>
        @page {
            margin: 130px 50px 80px 50px; /* top right bottom left */
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            font-size: 10px;
        }

        td {
            box-sizing: border-box;
        }
    </style>

    <title>RIS {{ $risnum }}</title>
</head>
<body>
    <header>
        <img src="{{ public_path('img/header.png') }}" width="100%">
    </header>

    <footer>
        <img src="{{ public_path('img/footer.png') }}" width="100%">
    </footer>

    <div class="content">
        <table align="center" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <td width="6%"></td>
                    <td width="6%"></td>
                    <td width="25%"></td>
                    <td width="6%"></td>
                    <td width="6%"></td>
                    <td width="6%"></td>
                    <td width="6%"></td>
                    <td width="10%"></td>
                    <td width="10%"></td>
                    <td width="19%"></td>
                </tr>

                <tr>
                    <td width="100%" colspan="10"><div class="form-text-12"><b>REQUISITION AND ISSUE SLIP (RIS)</b></div></td>
                </tr>

                <tr>
                    <td width="100%" colspan="10" class="form-text-8">&nbsp;</td>
                </tr>

                <tr class="form-text-11-l">
                    <td colspan="2"><b>Entity Name:</b></td>
                    <td colspan="3"><b><div class="mborder-bot mr-2">{{ $entity }}</div></b></td>
                    <td colspan="2"><b>Fund Cluster:</b></td>
                    <td colspan="3"><b><div class="mborder-bot mr-2">{{ $fund }}</div></b></td>
                </tr>

                <tr>
                    <td width="100%" colspan="10" class="form-text-8">&nbsp;</td>
                </tr>

                <tr class="form-text-10-l mborder-top-1">
                    <td colspan="2" class="mborder-left-1">&nbsp;Division:</td>
                    <td colspan="2" class="mborder-right-1"><b><div class="mborder-bot mr-2">{{ $division }}</div></b></td>
                    <td colspan="4" class="mborder-left-1">&nbsp;Responsibility Center Code:</td>
                    <td colspan="2" class="mborder-right-1"><b><div class="mborder-bot mr-2">{{ $ccode }}</div></b></td>
                </tr>

                <tr class="form-text-10-l mborder-bot-1">
                    <td colspan="2" class="mborder-left-1">&nbsp;Office:</td>
                    <td colspan="2" class="mborder-right-1"><b><div class="mborder-bot mr-2">{{ $office }}</div></b></td>
                    <td colspan="4" class="mborder-left-1">&nbsp;RIS No.:</td>
                    <td colspan="2" class="mborder-right-1"><b><div class="mborder-bot mr-2">{{ $risnum }}</div></b></td>
                </tr>

                <tr class="form-text-10 mborder-top-1">
                    <td colspan="4" class="mborder-left-1"><b>REQUISITION</b></td>
                    <td colspan="2" class="form-text-8 mborder-left-1"><b>STOCK AVAILABLE?</b></td>
                    <td colspan="4" class="mborder-left-1 mborder-right-1"><b>ISSUE</b></td>
                </tr>

                <tr class="form-text-9 mborder-top">
                    <td class="mborder-bot-1 mborder-right mborder-left-1">Stock<br>No.</td>
                    <td class="mborder-bot-1 mborder-right">Unit</td>
                    <td class="mborder-bot-1 mborder-right">Description</td>
                    <td class="mborder-bot-1 mborder-right">QTY</td>
                    <td class="mborder-bot-1 mborder-right mborder-left-1">Yes</td>
                    <td class="mborder-bot-1 mborder-right">No</td>
                    <td class="mborder-bot-1 mborder-right mborder-left-1">QTY</td>
                    <td class="mborder-bot-1 mborder-right">Unit Price</td>
                    <td class="mborder-bot-1 mborder-right">Total</td>
                    <td class="mborder-bot-1 mborder-right-1">Remarks</td>
                </tr>
            </thead>

            <tbody>
                @php $cur_num = ''; @endphp
                @foreach($requested_items as $requested_item)
                    @if($cur_num != $requested_item['num'])
                        <tr>
                            <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>{{ $requested_item['code'] }}</div></td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>{{ $requested_item['unit'] }}</div></td>
                            <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>{{ $requested_item['item'] }} ({{ $requested_item['description'] }})</div></td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>{{ $requested_item['qty'] }}</div></td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right">
                                @if($requested_item['avail'] == 'YES')
                                    <span style="font-family: DejaVu Sans;">✔</span>
                                @endif
                            </td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right-1">
                                @if($requested_item['avail'] == 'NO')
                                    <span style="font-family: DejaVu Sans;">✔</span>
                                @endif
                            </td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>{{ $requested_item['qtyi'] }}</div></td>
                            <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div><span style="font-family: DejaVu Sans;">₱</span>{{ number_format($requested_item['price'],2) }}</div></td>
                            <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div><span style="font-family: DejaVu Sans;">₱</span>{{ number_format($requested_item['total'],2) }}</div></td>
                            <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>{{ $requested_item['remarks'] }}</div></td>
                        </tr>
                        @php $cur_num = $requested_item['num']; @endphp
                    @else
                        <tr>
                            <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                            <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right">
                                @if($requested_item['avail'] == 'YES')
                                    <div>&nbsp;</div>
                                @endif
                            </td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right-1">
                                @if($requested_item['avail'] == 'NO')
                                    <div>&nbsp;</div>
                                @endif
                            </td>
                            <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>{{ $requested_item['qtyi'] }}</div></td>
                            <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div><span style="font-family: DejaVu Sans;">₱</span>{{ number_format($requested_item['price'],2) }}</div></td>
                            <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div><span style="font-family: DejaVu Sans;">₱</span>{{ number_format($requested_item['total'],2) }}</div></td>
                            <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>{{ $requested_item['remarks'] }}</div></td>
                        </tr>
                    @endif
                @endforeach

                @if($item_count <= 10)
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class="form-text-8 mborder-bot mborder-left-1 mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                        <td class="form-text-8 mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-r mborder-bot mborder-left mborder-right"><div>&nbsp;</div></td>
                        <td class="form-text-8-l mborder-bot mborder-left mborder-right-1"><div>&nbsp;</div></td>
                    </tr>
                @endif

                <tr>
                    <td class="form-text-8 mborder-bot-1 mborder-left-1 mborder-right mborder-top-1"><div >&nbsp;</div></td>
                    <td class="form-text-8 mborder-bot-1 mborder-left mborder-right mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8-l mborder-bot-1 mborder-left mborder-right mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8 mborder-bot-1 mborder-left mborder-right-1 mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8 mborder-bot-1 mborder-left mborder-right mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8 mborder-bot-1 mborder-left mborder-right-1 mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8 mborder-bot-1 mborder-left mborder-right mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8-r mborder-bot-1 mborder-left mborder-right mborder-top-1"><div>&nbsp;</div></td>
                    <td class="form-text-8-r mborder-bot-1 mborder-left mborder-right mborder-top-1"><b><div><span style="font-family: DejaVu Sans;">₱</span>{{ number_format($overall_total,2) }}</div></b></td>
                    <td class="form-text-8-l mborder-bot-1 mborder-left mborder-right-1 mborder-top-1"><div>&nbsp;</div></td>
                </tr>

                <tr>
                    <td class="form-text-10-l mborder-bot-1 mborder-left-1" style="vertical-align: text-top;">&nbsp;Purpose:</td>
                    <td colspan="9" class="form-text-10-l mborder-bot-1 mborder-right-1"><div class="mborder-bot mr-2"><u>{{ $purpose }}</u>&nbsp;</div></td>
                </tr>
            </tbody>
        </table>

        <table align="center" width="100%" style="line-height: 1; table-layout: fixed;" >
            <tr>
                <td width="16%" class="form-text-10-l mborder-right mborder-left-1">&nbsp;</td>
                <td width="21%" class="form-text-10-l mborder-right"><b>&nbsp;Requested by:</b></td>
                <td width="21%" class="form-text-10-l mborder-right"><b>&nbsp;Approved by:</b></td>
                <td width="21%" class="form-text-10-l mborder-right"><b>&nbsp;Issued by:</b></td>
                <td width="21%" class="form-text-10-l mborder-right-1"><b>&nbsp;Received by:</b></td>
            </tr>
            <tr>
                <td width="16%" class="form-text-10-l mborder-top mborder-right mborder-left-1">&nbsp;Signature</td>
                <td width="21%" class="form-text-10-l mborder-top mborder-right">
                    {{-- @foreach($esig_files->where('user_id','=',$requester_id) as $esig)
                        @if($sign_req == 'true')
                            <div class="text-center"><img src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                        @endif
                    @endforeach --}}
                </td>
                <td width="21%" class="form-text-10-l mborder-top mborder-right">
                    {{-- @foreach($esig_files->where('user_id','=',$approver_id) as $esig)
                        @if($sign_app == 'true')
                            <div class="text-center"><img src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                        @endif
                    @endforeach --}}
                </td>
                <td width="21%" class="form-text-10-l mborder-top mborder-right">
                    {{-- @foreach($esig_files->where('user_id','=',$issuer_id) as $esig)
                        @if($sign_iss == 'true')
                            <div class="text-center"><img src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                        @endif
                    @endforeach --}}
                </td>
                <td width="21%" class="form-text-10-l mborder-top mborder-right-1">
                    {{-- @foreach($esig_files->where('user_id','=',$receiver_id) as $esig)
                        @if($sign_rec == 'true')
                            <div class="text-center"><img src="storage/{{ $esig->signature_path }}" height="40" alt="e-Signature"></div>
                        @endif
                    @endforeach --}}
                </td>
            </tr>
            <tr>
                <td width="16%" class="form-text-10-l mborder-top mborder-right mborder-left-1">&nbsp;Printed Name</td>
                <td width="21%" class="form-text-8r mborder-top mborder-right"><div id="lbReqName">{{ $requester }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-right"><div id="lbAppName">{{ $approver }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-right"><div id="lbIssName">{{ $issuer }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-right-1"><div id="lbRecName">{{ $receiver }}&nbsp;</div></td>
            </tr>
            <tr>
                <td width="16%" class="form-text-10-l mborder-top mborder-right mborder-left-1">&nbsp;Designation</td>
                <td width="21%" class="form-text-8r mborder-top mborder-right"><div id="lbReqPos">{{ $position_req }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-right"><div id="lbAppPos">{{ $position_app }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-right"><div id="lbIssPos">{{ $position_iss }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-right-1"><div id="lbRecPos">{{ $position_rec }}&nbsp;</div></td>
            </tr>
            <tr>
                <td width="16%" class="form-text-10-l mborder-top mborder-bot-1 mborder-right mborder-left-1">&nbsp;Date</td>
                <td width="21%" class="form-text-8r mborder-top mborder-bot-1 mborder-right"><div id="lbReqDate">{{ $date_req }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-bot-1 mborder-right"><div id="lbAppDate">{{ $date_app }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-bot-1 mborder-right"><div id="lbIssDate">{{ $date_iss }}&nbsp;</div></td>
                <td width="21%" class="form-text-8r mborder-top mborder-bot-1 mborder-right-1"><div id="lbRecDate">{{ $date_rec }}&nbsp;</div></td>
            </tr>
        </table>

        <table align="center" width="100%" style="line-height: 1; table-layout: fixed;">
            <tr>
                <td width="100%" class="form-text-8-l">&nbsp;</td>
            </tr>
        </table>

        <table align="left" width="33%" cellspacing="0" cellpadding="0" style="border: 1px solid black; border-collapse: collapse;">
            <tr>
                <td width="12%" class="form-text-9-l" style="padding-top: 10px; padding-left: 10px;">&nbsp;Form No.</td>
                <td width="2%"  class="form-text-9" style="padding-top: 10px;">:</td>
                <td width="19%" class="form-text-9-l" style="padding-top: 10px;">&nbsp;FM-JRMSU-RII-03</td>
            </tr>
            <tr>
                <td width="12%" class="form-text-9-l" style="padding-left: 10px;">&nbsp;Issue Status</td>
                <td width="2%"  class="form-text-9">:</td>
                <td width="19%" class="form-text-9-l">&nbsp;06</td>
            </tr>
            <tr>
                <td width="12%" class="form-text-9-l" style="padding-left: 10px;">&nbsp;Revision No.</td>
                <td width="2%"  class="form-text-9">:</td>
                <td width="19%" class="form-text-9-l">&nbsp;03</td>
            </tr>
            <tr>
                <td width="12%" class="form-text-9-l" style="padding-left: 10px;">&nbsp;Date Effective</td>
                <td width="2%"  class="form-text-9">:</td>
                <td width="19%" class="form-text-9-l">&nbsp;10 June 2024</td>
            </tr>
            <tr>
                <td width="12%" class="form-text-9-l" style="padding-bottom: 10px; padding-left: 10px;">&nbsp;Approved by</td>
                <td width="2%"  class="form-text-9" style="padding-bottom: 10px;">:</td>
                <td width="19%" class="form-text-9-l" style="padding-bottom: 10px;">&nbsp;President</td>
            </tr>
        </table>
    </div>
</body>
</html>