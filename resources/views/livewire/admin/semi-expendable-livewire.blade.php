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
                                                Add new semi-expendable property
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-chalkboard mr-3"></i>Semi-Expendable Property</h3>
        
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
                                            <form wire:submit.prevent="validateSEP">
                                                @csrf
        
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="code">&nbsp;&nbsp;&nbsp;SEP No.:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='code' id="code" placeholder="Input SEP number" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="item">&nbsp;&nbsp;&nbsp;Item Name:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cube"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='item' id="item" placeholder="Item name or label" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="description">&nbsp;&nbsp;&nbsp;Description:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-feather"></i></span>
                                                                        </div>
        
                                                                        <textarea class="form-control" wire:model='description' id="description" placeholder="Item description (color, size, variation, etc.)" required></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="category">&nbsp;&nbsp;&nbsp;Classification:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-clone"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='category' id="category" required>
                                                                            <option value="" class="text-blue">••• Please select a classification:</option>
                                                                            @foreach($categories_sep as $category_sep)
                                                                                <option value="{{ $category_sep->id }}">{{ $category_sep->category }}</option>
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
                                                                    <label for="unit">&nbsp;&nbsp;&nbsp;Unit:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='unit' id="unit" required>
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
                                                                    <label for="fund">&nbsp;&nbsp;&nbsp;Fund:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-donate"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='fund' id="fund" required>
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
                                                                    <label for="date_acquired">&nbsp;&nbsp;&nbsp;Date Acquired:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
        
                                                                        <input type="date" class="form-control" wire:model='date_acquired' id="date_acquired" placeholder="Input date acquired" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="price">&nbsp;&nbsp;&nbsp;Price:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                                        </div>
        
                                                                        <input type="number" min="1" step="0.25" onblur="this.value = parseFloat(this.value).toFixed(2);" class="form-control" wire:model='price' placeholder="Input price" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="status">&nbsp;&nbsp;&nbsp;Status:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='status' id="status">
                                                                            <option value="New">New</option>
                                                                            <option value="Used">Used</option>
                                                                            <option value="Repaired">Repaired</option>
                                                                            <option value="Broken">Broken</option>
                                                                            <option value="Lost/Stolen">Lost/Stolen</option>
                                                                            <option value="Returned">Returned</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="est_life">&nbsp;&nbsp;&nbsp;Estimated Useful Life:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-leaf"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='est_life' id="est_life" placeholder="Item remarks or notes">
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
                                                            Save New SEP
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-chalkboard mr-3 text-warning"></i>Semi-Expendable Property ({{ $recordCount }})</h3>

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
                                                    <th><i class="mr-1 fas fa-check-circle"></i>Status</th>
                                                    <th><i class="mr-1 fas fa-calendar"></i>Date Acquired</th>
                                                    <th><i class="mr-1 fas fa-box"></i>Unit</th>
                                                    <th><i class="mr-1 fas fa-cash-register"></i>Price</th>
                                                    <th><i class="mr-1 fas fa-donate"></i>Fund</th>
                                                    <th><i class="mr-1 fas fa-leaf"></i>EUL</th>
                                                    <th><i class="mr-1 fas fa-person"></i>Custodian</th>
                                                    <th><i class="mr-1 fas fa-tasks"></i>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($semi_expendables as $semi_expendable)
                                                    <tr>
                                                        <td align="center">{{ $semi_expendable->sep_code }}</td>
                                                        <td>{{ $semi_expendable->sep_item }}</td>
                                                        <td>{{ $semi_expendable->sep_description }}</td>
                                                        <td>{{ $semi_expendable->sep_category }}</td>
                                                        <td align="center">{{ $semi_expendable->sep_status }}</td>
                                                        <td align="center">{{ $semi_expendable->sep_date_acquired }}</td>
                                                        <td align="center">{{ $semi_expendable->sep_unit }}</td>
                                                        <td align="right">₱{{ number_format($semi_expendable->sep_price,2) }}</td>
                                                        <td align="center">{{ $semi_expendable->sep_fund }}</td>
                                                        <td>{{ $semi_expendable->sep_est_life }}</td>
                                                        <td>{{ $semi_expendable->sep_custodian }}</td>
                                                        <td align="center">
                                                            <button class="btn btn-xs bg-green" wire:click="updateSEP({{ $semi_expendable->sep_id }})"><i class="fas fa-pen mr-1" style="cursor: pointer"></i>Edit</button>
                                                            <button class="btn btn-xs bg-danger" wire:click="transferSEP({{ $semi_expendable->sep_id }})"><i class="fas fa-arrow-right mr-1" style="cursor: pointer"></i>Transfer</button>
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
                                            {{ $semi_expendables->links(data: ['scrollTo' => false]) }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if($show_panel == 'update')
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-chalkboard mr-3"></i>Update Semi-Expendable Property</h3>

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
                                            <form wire:submit.prevent="validateSEPUpdate">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="code_up">&nbsp;&nbsp;&nbsp;SEP No.:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='code_up' id="code_up" placeholder="Input SEP number" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="item_up">&nbsp;&nbsp;&nbsp;Item Name:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cube"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='item_up' id="item_up" placeholder="Item name or label" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="description_up">&nbsp;&nbsp;&nbsp;Description:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-feather"></i></span>
                                                                        </div>
        
                                                                        <textarea class="form-control" wire:model='description_up' id="description_up" placeholder="Item description (color, size, variation, etc.)" required></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="category_up">&nbsp;&nbsp;&nbsp;Classification:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-clone"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='category_up' id="category_up" required>
                                                                            <option value="" class="text-blue">••• Please select a classification:</option>
                                                                            @foreach($categories_sep as $category_sep)
                                                                                <option value="{{ $category_sep->id }}">{{ $category_sep->category }}</option>
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
                                                                    <label for="unit_up">&nbsp;&nbsp;&nbsp;Unit:</label>
                                                                    
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
                                                                    <label for="fund_up">&nbsp;&nbsp;&nbsp;Fund:</label>
                                                                    
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
                                                                    <label for="date_acquired_up">&nbsp;&nbsp;&nbsp;Date Acquired:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
        
                                                                        <input type="date" class="form-control" wire:model='date_acquired_up' id="date_acquired_up" placeholder="Input date acquired" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="price_up">&nbsp;&nbsp;&nbsp;Price:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                                                        </div>
        
                                                                        <input type="number" min="1" step="0.25" onblur="this.value = parseFloat(this.value).toFixed(2);" class="form-control" wire:model='price_up' placeholder="Input price" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="status_up">&nbsp;&nbsp;&nbsp;Status:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='status_up' id="status_up">
                                                                            <option value="New">New</option>
                                                                            <option value="Transferred">Transferred</option>
                                                                            <option value="Repaired">Repaired</option>
                                                                            <option value="Broken">Broken</option>
                                                                            <option value="Lost/Stolen">Lost/Stolen</option>
                                                                            <option value="Disposed">Disposed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="est_life_up">&nbsp;&nbsp;&nbsp;Estimated Useful Life:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-leaf"></i></span>
                                                                        </div>
        
                                                                        <input type="text" class="form-control" wire:model='est_life_up' id="est_life_up" placeholder="Item remarks or notes">
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
                                                            Save Updated SEP
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($show_panel == 'transfer')
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-chalkboard mr-3"></i>Transfer Semi-Expendable Property</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                    <i class="fas fa-expand"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" wire:click='resetTransferForm'>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <form wire:submit.prevent="validateSEPTransfer">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="date_transferred">&nbsp;&nbsp;&nbsp;Date Transferred:</label>
        
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
        
                                                                        <input type="date" class="form-control" wire:model='date_transferred' id="date_transferred" placeholder="Input date acquired" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="status">&nbsp;&nbsp;&nbsp;Status:</label>
                                                                    
                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                                                        </div>
                                                                        
                                                                        <select class="form-control" wire:model='status' id="status">
                                                                            <option value="New">New</option>
                                                                            <option value="Transferred">Transferred</option>
                                                                            <option value="Repaired">Repaired</option>
                                                                            <option value="Broken">Broken</option>
                                                                            <option value="Lost/Stolen">Lost/Stolen</option>
                                                                            <option value="Disposed">Disposed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="new_custodian">&nbsp;&nbsp;&nbsp;Transfer to:</label>
                                                            
                                                            <div class="input-group col-md-12">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                                </div>
                                                                
                                                                <select class="form-control" wire:model='new_custodian' id="new_custodian" required>
                                                                    <option value="" class="text-blue">••• Please select new custodian:</option>
                                                                    @foreach($users as $user)
                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2 mb-2">
                                                    <div class="col-12" align="center">
                                                        <button type="submit" class="btn bg-blue" id="btnSaveUpdate">
                                                            <i class="nav-icon fas fa-arrow-circle-up mr-1"></i>
                                                            Save New Custodian
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
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
        $('#nav-masterlist-sep').addClass('active');
    </script>
@endscript