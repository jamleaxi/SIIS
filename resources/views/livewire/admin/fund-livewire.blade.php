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
                                                Add Fund
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-donate mr-3"></i>Add Fund</h3>

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
                                            <form wire:submit.prevent="validateFund">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="fund_new">&nbsp;&nbsp;&nbsp;Fund Code:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-donate"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='fund_new' id="fund_new" placeholder="Input new fund code" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="description_new">&nbsp;&nbsp;&nbsp;Fund Description:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-d"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='description_new' id="description_new" placeholder="Input fund description" required>
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
                                                            Save New Fund
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($count > 0)
                                    <div class="card card-dark">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-donate mr-3"></i>Funds ({{ $count }})</h3>

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
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <div class="input-group col-md-12">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                                </div>

                                                                <input type="text" class="form-control form-control-sm" wire:model.live='searchQuery' placeholder="Search here...">
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
                                            
                                            <div class="row">
                                                @foreach($funds as $fund)
                                                    <button class="btn btn-sm btn-default col-3" wire:click="updateFund({{ $fund->id }})"><b>{{ $fund->fund }}</b><br>({{ $fund->description }})</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="text-center mt-3 h5">
                                            <i class="fas fa-info-circle mr-1"></i>You have no encoded funds as of the moment.
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="card card-blue">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-donate mr-3"></i>Update Fund</h3>

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
                                        <form wire:submit.prevent="validateFundUpdate">
                                            @csrf

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="fund_up">&nbsp;&nbsp;&nbsp;Fund Code:</label>

                                                                <div class="input-group col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-donate"></i></span>
                                                                    </div>

                                                                    <input type="text" class="form-control" wire:model='fund_up' id="fund_up" placeholder="Input updated fund code" required autofocus>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="description_up">&nbsp;&nbsp;&nbsp;Fund Description:</label>

                                                                <div class="input-group col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-d"></i></span>
                                                                    </div>

                                                                    <input type="text" class="form-control" wire:model='description_up' id="description_up" placeholder="Input updated fund description" required>
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
                                                        Save Updated Fund
                                                    </button>

                                                    <button type="submit" class="btn bg-danger" id="btnDelete" wire:click.prevent="$dispatch('triggerDelete',{{ $fund_id }})">
                                                        <i class="nav-icon fas fa-times-circle mr-1"></i>
                                                        Delete Fund
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
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
        $('#nav-custom').addClass('active');
        $('#nav-custom-parent').addClass('menu-open');
        $('#nav-custom-fund').addClass('active');

        Livewire.on('triggerDelete', fund_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this operation!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete this fund!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('delete_conf', true);
                }
            });
        });
    </script>
@endscript