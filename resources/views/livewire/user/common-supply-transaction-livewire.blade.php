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
                            @if($unconfirmed >= 1)
                                <div class="col-12">
                                    <div class="text-center mt-3 h5">
                                        <i class="fas fa-exclamation-circle mr-1"></i>You still have unconfirmed requests on your record. Please confirm receipt before creating a new request.
                                        <a href="{{ url('/request-sent') }}"> >>Go to Requests</a>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="card card-dark">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-pencil-ruler mr-3 text-warning"></i>Request for Supplies and Materials</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
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

                                                                        foreach ($added_items as $key => $added_item)
                                                                        {
                                                                            if ($added_item['id'] == $searchTerm) {
                                                                                $found = true;
                                                                                break;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    @if($found == true)
                                                                        <button class="btn btn-xs bg-green" disabled><i class="fas fa-check-circle mr-1"></i>Added</button>
                                                                    @else
                                                                        <button class="btn btn-xs bg-yellow btnPick" id="{{ $common_supply->cs_id }}" wire:ignore wire:click="addToList({{ $common_supply->cs_id }})"><i class="fas fa-plus-circle mr-1"></i>Add to List</button>
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
                                
                                <div class="col-12">
                                    <div class="card card-dark">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-list mr-3 text-warning"></i>Requested Items</h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    @if($item_count <= 0)
                                                        <span class="badge bg-warning mb-2" style="cursor: default"><i class="icon fas fa-exclamation-circle mr-1"></i>There are no items on your list.</span>
                                                    @else
                                                        @if($item_count == 1)
                                                            <span class="badge bg-success mb-2" style="cursor: default"><i class="icon fas fa-check-circle mr-1"></i>You have {{ $item_count }} item on your list.</span>
                                                        @else
                                                            <span class="badge bg-success mb-2" style="cursor: default"><i class="icon fas fa-check-circle mr-1"></i>You have {{ $item_count }} items on your list.</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                                <div class="col-12">
                                                    <form wire:submit.prevent='validateCSRequest'>
                                                        @csrf
                
                                                        <div class="row">
                                                            <table class="table table-sm table-responsive-sm table-hover">
                                                                <thead class="bg-blue">
                                                                    <tr>
                                                                        <th width="70%" class="text-center"><i class="mr-1 fas fa-cube"></i>Description</th>
                                                                        <th width="10%"><i class="mr-1 fas fa-hashtag"></i>Qty</th>
                                                                        <th width="15%"><i class="mr-1 fas fa-box"></i>Unit</th>
                                                                        <th width="5%"></th>
                                                                    </tr>
                                                                </thead>
                    
                                                                <tbody>
                                                                    @foreach($added_items as $added_item)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}. {{ $added_item['item'] }} ({{ $added_item['description'] }})</td>
                                                                            <td align="right"><input type="number" min="1" class="form-control form-control-sm" wire:model="added_items.{{ $loop->index }}.qty" placeholder="Qty" required></td>
                                                                            <td>{{ $added_item['unit'] }}</td>
                                                                            <td align="right"><button class="btn btn-xs bg-danger" tabindex="-1" style="border-radius: 20px" wire:click.prevent='removeFromList({{ $loop->index }})'>&nbsp;<i class="fas fa-times"></i>&nbsp;</button></td>
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
        
                                                        @if($item_count > 0)
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
        
                                                                            <input type="text" class="form-control" maxlength="190" wire:model='purpose' id="purpose" placeholder="State purpose of request" required>
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
                                                                        <i class="nav-icon fas fa-paper-plane mr-1"></i>
                                                                        Create Request
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
        $('#nav-transaction').addClass('active');
        $('#nav-transaction-parent').addClass('menu-open');
        $('#nav-transaction-cs').addClass('active');

        Livewire.on('transaction-added', () => {
            window.location.href = '/request-sent';
        });
    </script>
@endscript
