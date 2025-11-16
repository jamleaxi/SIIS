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
                            <div class="col-6">
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-chalkboard mr-3 text-warning"></i>Semi-Expendable Property</h3>
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
                                                        SEP#
                                                        <span wire:click="sortBy('semi_expendables.code')" class="float-right" style="cursor: pointer">
                                                            <i class="fas fa-arrow-up {{ $sortColumn === 'semi_expendables.code' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                            <i class="fas fa-arrow-down {{ $sortColumn === 'semi_expendables.code' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                                        </span>
                                                    </th>
                                                    <th><i class="mr-1 fas fa-cube"></i>
                                                        Item
                                                        <span wire:click="sortBy('semi_expendables.item')" class="float-right" style="cursor: pointer">
                                                            <i class="fas fa-arrow-up {{ $sortColumn === 'semi_expendables.item' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                            <i class="fas fa-arrow-down {{ $sortColumn === 'semi_expendables.item' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
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
                                                    {{-- <th><i class="mr-1 fas fa-box"></i>Unit</th> --}}
                                                    <th><i class="mr-1 fas fa-tasks"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($semi_expendables as $semi_expendable)
                                                    @if($semi_expendable->sep_custodian == '' or $semi_expendable->sep_custodian == null)
                                                        <tr>
                                                            <td align="center">{{ $semi_expendable->sep_code }}</td>
                                                            <td>{{ $semi_expendable->sep_item }}</td>
                                                            <td>{{ $semi_expendable->sep_description }}</td>
                                                            <td>{{ $semi_expendable->sep_category }}</td>
                                                            {{-- <td>{{ $semi_expendable->sep_unit }}</td> --}}
                                                            <td align="center">
                                                                @php
                                                                    $searchTerm = $semi_expendable->sep_id;
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
                                                                    <button class="btn btn-xs bg-yellow btnPick" id="{{ $semi_expendable->sep_id }}" wire:ignore wire:click="addToList({{ $semi_expendable->sep_id }})"><i class="fas fa-plus-circle mr-1"></i>Add to List</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td align="center">{{ $semi_expendable->sep_code }}</td>
                                                            <td>{{ $semi_expendable->sep_item }}</td>
                                                            <td>{{ $semi_expendable->sep_description }}</td>
                                                            <td>{{ $semi_expendable->sep_category }}</td>
                                                            {{-- <td>{{ $semi_expendable->sep_unit }}</td> --}}
                                                            <td align="center">
                                                                <button class="btn btn-xs bg-light" disabled><i class="fas fa-times mr-1"></i>Assigned</button>
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
                                                    {{-- <th></th> --}}
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="mt-3">
                                            {{ $semi_expendables->links(data: ['scrollTo' => false]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-list mr-3 text-warning"></i>Items for Custody</h3>
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
                                                <form wire:submit.prevent='validateSEPRequest'>
                                                    @csrf
            
                                                    <div class="row">
                                                        <table class="table table-sm table-responsive-sm table-hover">
                                                            <thead class="bg-blue" align="center">
                                                                <tr>
                                                                    <th width="70%"><i class="mr-1 fas fa-cube"></i>Description</th>
                                                                    {{-- <th width="10%"><i class="mr-1 fas fa-hashtag"></i>Qty</th>
                                                                    <th width="15%"><i class="mr-1 fas fa-box"></i>Unit</th> --}}
                                                                    <th width="5%"><i class="mr-1 fas fa-tasks"></i></th>
                                                                </tr>
                                                            </thead>
                
                                                            <tbody>
                                                                @foreach($added_items as $added_item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}. {{ $added_item['item'] }} ({{ $added_item['description'] }})</td>
                                                                        {{-- <td align="right"><input type="number" min="1" class="form-control form-control-sm" wire:model="added_items.{{ $loop->index }}.qty" placeholder="Qty" required></td> --}}
                                                                        {{-- <td>{{ $added_item['unit'] }}</td> --}}
                                                                        <td align="right"><button class="btn btn-xs bg-danger" tabindex="-1" style="border-radius: 20px" wire:click.prevent='removeFromList({{ $loop->index }})'>&nbsp;<i class="fas fa-times"></i>&nbsp;</button></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot class="bg-blue" align="center">
                                                                <tr>
                                                                    <th></th>
                                                                    {{-- <th></th>
                                                                    <th></th> --}}
                                                                    <th></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    @if($item_count > 0)
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="icsnum">&nbsp;&nbsp;&nbsp;ICS Number:</label>
    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-list-numeric"></i></span>
                                                                        </div>
    
                                                                        <input type="text" class="form-control" wire:model='icsnum' id="icsnum" placeholder="Input ICS number" required disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="fund">&nbsp;&nbsp;&nbsp;Fund:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-donate"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='fund' id="fund" required autofocus>
                                                                            <option value="" class="text-blue">••• Please select a fund:</option>
                                                                            @foreach($funds as $funding)
                                                                                <option value="{{ $funding->fund }}">{{ $funding->fund }} - {{ $funding->description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="office">&nbsp;&nbsp;&nbsp;Office/Unit:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='office' id="office" required>
                                                                            <option value="" class="text-blue">••• Please select an office:</option>
                                                                            @foreach($offices as $office)
                                                                                <option value="{{ $office->initial }}">{{ $office->initial }} - {{ $office->office }}</option>
                                                                            @endforeach
                                                                        </select>
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
    
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="custodian_id">&nbsp;&nbsp;&nbsp;Received by:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='custodian_id' id="custodian_id" wire:click='getCusPos' required>
                                                                            <option value="" class="text-blue">••• Please select a custodian:</option>
                                                                            @foreach($users as $user)
                                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="position_cus">&nbsp;&nbsp;&nbsp;Position/Designation:</label>
    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                        </div>
    
                                                                        <input type="text" class="form-control" wire:model='position_cus' id="position_cus" placeholder="Select custodian to auto generate" required disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-6">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="date_cus">&nbsp;&nbsp;&nbsp;Date Received by Custodian:</label>
                
                                                                            <div class="input-group col-md-12">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                                </div>
                
                                                                                <input type="date" class="form-control" wire:model='date_cus' id="date_cus" placeholder="Input date received" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="issuer_id">&nbsp;&nbsp;&nbsp;Issued by:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='issuer_id' id="issuer_id" wire:click='getIssPos' required>
                                                                            <option value="" class="text-blue">••• Please select an issuer:</option>
                                                                            @foreach($issuers as $issuer)
                                                                                <option value="{{ $issuer->id }}">{{ $issuer->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="position_iss">&nbsp;&nbsp;&nbsp;Position/Designation:</label>
    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                        </div>
    
                                                                        <input type="text" class="form-control" wire:model='position_iss' id="position_iss" placeholder="Select issuer to auto generate" required disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="date_iss">&nbsp;&nbsp;&nbsp;Date Issued:</label>
                
                                                                            <div class="input-group col-md-12">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                                </div>
                
                                                                                <input type="date" class="form-control" wire:model='date_iss' id="date_iss" placeholder="Input date issued" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                    
                                                        <div class="row mb-3">
                                                            <div class="col-12" align="center">
                                                                <button type="submit" class="btn bg-blue">
                                                                    <i class="nav-icon fas fa-arrows-down-to-people mr-1"></i>
                                                                    Assign Custodian
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
        $('#nav-transaction-sep').addClass('active');

        Livewire.on('transaction-added', () => {
            window.location.href = '/masterlist-sep';
        });
    </script>
@endscript
