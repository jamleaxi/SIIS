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

                            @if($up_status == false)
                                @if($show_add == false)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <button type="" class="btn bg-blue" wire:click='showAddPanel'>
                                                <i class="nav-icon fas fa-plus mr-1"></i>
                                                Add new supply or material
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3"></i>Add New Supply or Material</h3>
        
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>
        
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" wire:click='hideAddPanel'>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
        
                                        <div class="card-body">
                                            <form wire:submit.prevent="validateCS">
                                                @csrf
        
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="code_new">&nbsp;&nbsp;&nbsp;Item Code:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='code_new' id="code_new" placeholder="Input stock code" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="item_new">&nbsp;&nbsp;&nbsp;Item Name:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cube"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='item_new' id="item_new" placeholder="Item name or label" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="description_new">&nbsp;&nbsp;&nbsp;Description:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-feather"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='description_new' id="description_new" placeholder="Item description (color, size, variation, etc.)" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="category_new">&nbsp;&nbsp;&nbsp;Classification:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-clone"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='category_new' id="category_new" required>
                                                                            <option value="" class="text-blue">••• Please select a classification:</option>
                                                                            @foreach($categories_cs as $category_cs)
                                                                                <option value="{{ $category_cs->id }}">{{ $category_cs->category }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="unit_new">&nbsp;&nbsp;&nbsp;Unit:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='unit_new' id="unit_new" required>
                                                                            <option value="" class="text-blue">••• Please select a unit:</option>
                                                                            @foreach($units as $unit)
                                                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="fund_new">&nbsp;&nbsp;&nbsp;Fund:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-donate"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='fund_new' id="fund_new" required>
                                                                            <option value="" class="text-blue">••• Please select fund source:</option>
                                                                            @foreach($funds as $fund)
                                                                                <option value="{{ $fund->fund }}">{{ $fund->fund }} - {{ $fund->description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="low_indicator_new">&nbsp;&nbsp;&nbsp;Indicate Low Stock at:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                                                                        </div>
        
                                                                        <input type="number" min="1" class="form-control" wire:model='low_indicator_new' id="low_indicator_new" placeholder="Input number of quantity to indicate low stock status" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="remarks_new">&nbsp;&nbsp;&nbsp;Remarks:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-paperclip"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='remarks_new' id="remarks_new" placeholder="Item remarks or notes">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="row mt-2 mb-2">
                                                    <div class="col-12" align="center">
                                                        <button type="submit" class="btn bg-blue" id="btnSaveNew">
                                                            <i class="nav-icon fas fa-plus-circle mr-1"></i>
                                                            Save New Item
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3 text-warning"></i>Supplies and Materials ({{ $recordCount }})</h3>

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

                                        <table class="table table-bordered table-striped table-sm table-responsive-sm table-hover" style="font-size: 14px;">
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
                                                    <th><i class="mr-1 fas fa-check-circle"></i>Status</th>
                                                    <th><i class="mr-1 fas fa-hashtag"></i>Stock</th>
                                                    <th><i class="mr-1 fas fa-box"></i>Unit</th>
                                                    <th><i class="mr-1 fas fa-cash-register"></i>Price</th>
                                                    <th><i class="mr-1 fas fa-file-alt"></i>Source</th>
                                                    <th><i class="mr-1 fas fa-donate"></i>Fund</th>
                                                    <th><i class="mr-1 fas fa-paperclip"></i>Remarks</th>
                                                    <th><i class="mr-1 fas fa-tasks"></i>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($common_supplies as $common_supply)
                                                    <tr>
                                                        <td align="center">{{ $common_supply->cs_code }}</td>
                                                        <td>{{ $common_supply->cs_item }}</td>
                                                        <td>{{ $common_supply->cs_description }}</td>
                                                        <td>{{ $common_supply->cs_category }}</td>
                                                        
                                                        {{-- JailyCodes FIFO-SI algorithm --}}
                                                        {{-- declare variables --}}
                                                        @php
                                                            $total_in = 0; // gets total quantity in
                                                            $total_out = 0; // gets total quantity out
                                                        @endphp

                                                        {{-- get all inventory in --}}
                                                        @foreach ($inventory_cs_ins->where('cs_id','=',$common_supply->cs_id) as $inventory_cs_in)
                                                            @php
                                                                $total_in += $inventory_cs_in->qty_in; // add every quantity retrieved
                                                            @endphp
                                                        @endforeach
                                                        {{-- get all inventory out --}}
                                                        @foreach ($inventory_cs_outs->where('cs_id','=',$common_supply->cs_id) as $inventory_cs_out)
                                                            @php
                                                                $total_out += $inventory_cs_out->qty_out; // add every quantity retrieved
                                                            @endphp
                                                        @endforeach
                                                        {{-- difference: total remaining stock --}}
                                                        @php $stock_total = $total_in - $total_out; @endphp

                                                        @if($stock_total == 0)
                                                            <td align="center"><span class="badge bg-red">Out of Stock</span></td>
                                                        @elseif($stock_total <= $common_supply->cs_low_indicator)
                                                            <td align="center"><span class="badge bg-yellow">Low in Stock</span></td>
                                                        @elseif($stock_total > $common_supply->cs_low_indicator)
                                                            <td align="center"><span class="badge bg-green">In Stock</span></td>
                                                        @else
                                                            <td align="center"><span class="badge bg-dark">Undefined</span></td>
                                                        @endif
                                                        
                                                        <td align="center">{{ number_format($stock_total) }}</td>
                                                        <td>{{ $common_supply->cs_unit }}</td>

                                                        {{-- declare variables --}}
                                                        @php
                                                            $activePO = ''; // set active PO to none
                                                            $activePrice = 0; // set active price to zero
                                                            $activeBal = 0; // set active balance to zero
                                                            $excess = 0; // set excess to zero
                                                        @endphp

                                                        @foreach ($inventory_cs_ins->where('cs_id','=',$common_supply->cs_id) as $inventory_in)
                                                            @php
                                                                $activePO = $inventory_in->reference; // get first value of reference
                                                                $activePrice = $inventory_in->price_in; // get first value of price_in
                                                                $activeBal = $inventory_in->qty_in; // get first value of qty_in
                                                            @endphp

                                                            {{-- get OUT inputs if the inventory exists --}}
                                                            @foreach($inventory_cs_outs->where('cs_id','=',$common_supply->cs_id)->where('reference_out','=', $inventory_in->reference) as $inventory_out)
                                                                @php
                                                                    if($excess > 0)
                                                                    {
                                                                        $activeBal -= $excess; // deduct the current inventory out
                                                                    }
                                                                    else
                                                                    {
                                                                        $activeBal -= $inventory_out->qty_out; // deduct the current inventory out
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                            
                                                            {{-- check active balance value --}}
                                                            @php
                                                                if($activeBal > 0) // if balance is greater than 0, always break loop
                                                                {
                                                                    break;
                                                                }
                                                                elseif($activeBal == 0)
                                                                {
                                                                    $activePO = ''; // set active PO to none
                                                                    $activePrice = 0; // set active price to zero
                                                                    $activeBal = 0; // set active balance to zero
                                                                    // continue loop and get next value
                                                                }
                                                                elseif($activeBal < 0)
                                                                {
                                                                    $activePO = ''; // set active PO to none
                                                                    $activePrice = 0; // set active price to zero
                                                                    $activeBal = 0; // set active balance to zero
                                                                    $excess = abs($activeBal); // convert balance value to positive
                                                                }
                                                            @endphp
                                                        @endforeach
                                                        {{-- JailyCodes FIFO-SI algorithm end --}}

                                                        <td align="right">₱{{ number_format($activePrice,2) }}</td>

                                                        @if($activePO == '')
                                                            <td align="center">-</td>
                                                        @else
                                                            <td align="center">{{ $activePO }} ({{ number_format($activeBal) }})</td>
                                                        @endif
                                                        
                                                        <td align="center">{{ $common_supply->cs_fund }}</td>
                                                        <td>{{ $common_supply->cs_remarks }}</td>
                                                        <td align="center">
                                                            <button class="btn btn-xs bg-blue text-xs" wire:click="updateCS({{ $common_supply->cs_id }})"><i class="fas fa-pen mr-1" style="cursor: pointer"></i>Modify</button>
                                                            <button class="btn btn-xs bg-danger text-xs" wire:click="inventoryCS({{ $common_supply->cs_id }})"><i class="fas fa-plus mr-1" style="cursor: pointer"></i>Stocks</button>
                                                            <button class="btn btn-xs bg-warning text-xs" wire:click="viewSources({{ $common_supply->cs_id }})"><i class="fas fa-eye mr-1" style="cursor: pointer"></i>Sources</button>
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
                                                    <th></th>
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
                            @else
                                @if($show_panel == 'update')
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3"></i>Update Supply or Material</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" wire:click='resetUpdateForm'>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <form wire:submit.prevent="validateCSUpdate">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="code_up">&nbsp;&nbsp;&nbsp;Updated Item Code:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='code_up' id="code_up" placeholder="Input updated stock code" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="item_up">&nbsp;&nbsp;&nbsp;Updated Item Name:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cube"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='item_up' id="item_up" placeholder="Item updated name or label" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="description_up">&nbsp;&nbsp;&nbsp;Updated Description:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-feather"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='description_up' id="description_up" placeholder="Updated item description (color, size, variation, etc.)" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="category_up">&nbsp;&nbsp;&nbsp;Updated Classification:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-clone"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='category_up' id="category_up" required>
                                                                            <option value="" class="text-blue">••• Please select a classification:</option>
                                                                            @foreach($categories_cs as $category_cs)
                                                                                <option value="{{ $category_cs->id }}">{{ $category_cs->category }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="unit_up">&nbsp;&nbsp;&nbsp;Updated Unit:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='unit_up' id="unit_up" required>
                                                                            <option value="" class="text-blue">••• Please select a unit:</option>
                                                                            @foreach($units as $unit)
                                                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="fund_up">&nbsp;&nbsp;&nbsp;Updated Fund:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-donate"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='fund_up' id="fund_up" required>
                                                                            <option value="" class="text-blue">••• Please select fund source:</option>
                                                                            @foreach($funds as $fund)
                                                                                <option value="{{ $fund->fund }}">{{ $fund->fund }} - {{ $fund->description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="low_indicator_up">&nbsp;&nbsp;&nbsp;Indicate Low Stock at:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                                                                        </div>

                                                                        <input type="number" min="1" class="form-control" wire:model='low_indicator_up' id="low_indicator_up" placeholder="Input updated number of quantity to indicate low stock status" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="remarks_up">&nbsp;&nbsp;&nbsp;Updated Remarks:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-paperclip"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='remarks_up' id="remarks_up" placeholder="Item updated remarks or notes">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2 mb-2">
                                                    <div class="col-12" align="center">
                                                        <button type="submit" class="btn bg-blue" id="btnSaveUpdate">
                                                            <i class="nav-icon fas fa-arrow-circle-up mr-1"></i>
                                                            Save Updated Item
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($show_panel == 'inventory')
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3"></i>Update Inventory</h3>
        
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>
        
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" wire:click='resetInventoryForm'>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
        
                                        <div class="card-body">
                                            <form wire:submit.prevent="validateCSInventory">
                                                @csrf
                                                
                                                <div class="col-12">
                                                    <b class="text-blue">Item {{ $inv_code }}: {{ $inv_item }} ({{ $inv_description }})</b><hr>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="inv_qty_in">&nbsp;&nbsp;&nbsp;Quantity in:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                                        </div>
        
                                                                        <input type="number" min="1" step="0" class="form-control" wire:model='inv_qty_in' id="inv_qty_in" placeholder="Input number of incoming quantity" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="inv_price_in">&nbsp;&nbsp;&nbsp;Price:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                                        </div>
        
                                                                        <input type="number" min="1" step="0.01" onblur="this.value = parseFloat(this.value).toFixed(2);" class="form-control" wire:model='inv_price_in' id="inv_price_in" placeholder="Input unit price of item" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="inv_date_acquired">&nbsp;&nbsp;&nbsp;Date Acquired:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
        
                                                                        <input type="date" class="form-control" wire:model='inv_date_acquired' id="inv_date_acquired" placeholder="Input date acquired" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="inv_reference">&nbsp;&nbsp;&nbsp;Reference File:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='inv_reference' id="inv_reference" placeholder="Input reference file no." required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="row mt-2 mb-2">
                                                    <div class="col-12" align="center">
                                                        <button type="" class="btn bg-blue" id="btnSaveInventory">
                                                            <i class="nav-icon fas fa-external-link-alt mr-1"></i>
                                                            Save Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($show_panel == 'sources')
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3"></i>Update Sources</h3>
        
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>
        
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" wire:click='resetSourcesForm'>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
        
                                        <div class="card-body">
                                            <div class="col-12">
                                                <b>
                                                    <i class="text-danger">
                                                        *** Please note that modifying the quantity or price will affect the reference details of the item. 
                                                        Items that have already been deducted cannot be modified.
                                                    </i>
                                                </b>
                                                <hr>
                                                <p>
                                                    <i>Code: </i><b class="text-blue">{{ $inv_code }}</b><br>
                                                    <i>Item: </i><b class="text-blue">{{ $inv_item }}</b><br>
                                                    @if($inv_description)
                                                        <i>Description: </i><b class="text-blue">{{ $inv_description }}</b>
                                                    @else
                                                        <i>Description: </i><i class="text-gray">No description available.</i>
                                                    @endif
                                                </p>
                                                <hr>
                                            </div>

                                            @if($source_id)
                                                <form wire:submit.prevent="validateSources">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3"><!--empty--></div>

                                                            <div class="col-6">
                                                                <div class="card card-purple">
                                                                    <div class="card-header">
                                                                        <i class="fas fa-edit mr-1"></i>Edit Quantity and Price
                                                                        <div class="card-tools">
                                                                            <button type="button" class="btn btn-tool" wire:click='resetQPForm'>
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label for="source_qty">&nbsp;&nbsp;&nbsp;Quantity:</label>
            
                                                                            <div class="input-group col-md-12">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                                                </div>
            
                                                                                <input type="number" min="1" step="0" class="form-control" wire:model='source_qty' id="source_qty" placeholder="Input quantity" required>
                                                                            </div>
    
                                                                            <div class="text-right text-blue">Current Quantity: {{ $source_qty }}</div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="source_price">&nbsp;&nbsp;&nbsp;Price:</label>
                
                                                                            <div class="input-group col-md-12">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                                                </div>
                
                                                                                <input type="number" min="1" step="0.01" onblur="this.value = parseFloat(this.value).toFixed(2);" class="form-control" wire:model='source_price' id="source_price" placeholder="Input unit price" required>
                                                                            </div>

                                                                            <div class="text-right text-blue">Current Price: ₱{{ $source_price }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-3"><!--empty--></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2 mb-2">
                                                        <div class="col-12" align="center">
                                                            <button type="" class="btn bg-blue" id="btnSaveInventory">
                                                                <i class="nav-icon fas fa-external-link-alt mr-1"></i>
                                                                Save Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="col-12">
                                                    <table class="table table-bordered table-striped table-sm table-responsive-sm table-hover">
                                                        <thead class="bg-blue" align="center">
                                                            <tr>
                                                                <th width="5%"></th>
                                                                <th width="25%"><i class="mr-1 fas fa-file-alt"></i>Reference</th>
                                                                <th width="20%"><i class="mr-1 fas fa-calendar"></i>Date Acquired</th>
                                                                <th width="10%"><i class="mr-1 fas fa-hashtag"></i>Quantity In</th>
                                                                <th width="10%"><i class="mr-1 fas fa-cash-register"></i>Price</th>
                                                                <th width="10%"><i class="mr-1 fas fa-calendar"></i>Date Encoded</th>
                                                                <th width="10%"><i class="mr-1 fas fa-calendar"></i>Last Updated</th>
                                                                <th width="10%"><i class="mr-1 fas fa-tasks"></i>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($inv_sources as $source)
                                                                <tr align="center">
                                                                    <td align="right">{{ $loop->iteration }}</td>
                                                                    <td align="left">{{ $source->reference }}</td>
                                                                    <td>{{ $source->date_acquired }}<i class="text-gray text-xs"> ({{ date('F j, Y',strtotime($source->date_acquired)) }})</i></td>
                                                                    <td>{{ $source->qty_in }}</td>
                                                                    <td>₱{{ number_format($source->price_in,2) }}</td>
                                                                    <td>{{ $source->created_at }}</td>
                                                                    <td>{{ $source->updated_at }}</td>
                                                                    <td>
                                                                        @forelse($inventory_cs_outs->where('reference_out','=',$source->reference) as $existing_out)
                                                                            <button class="btn btn-xs bg-gray text-xs" disabled><i class="fas fa-ban mr-1"></i>Cannot Modify</button>
                                                                            @break
                                                                        @empty
                                                                            <button class="btn btn-xs bg-purple text-xs" wire:click="updateQP({{ $source->id }})"><i class="fas fa-edit mr-1" style="cursor: pointer"></i>Edit Quantity and Price</button>
                                                                        @endforelse
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
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <div class="mt-3">
                                                    {{ $common_supplies->links(data: ['scrollTo' => false]) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
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
        $('#nav-masterlist').addClass('active');
        $('#nav-masterlist-parent').addClass('menu-open');
        $('#nav-masterlist-cs').addClass('active');
    </script>
@endscript