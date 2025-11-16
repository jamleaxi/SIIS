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
                                                Add Office
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-building mr-3"></i>Add Office</h3>

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
                                            <form wire:submit.prevent="validateOffice">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="initial_new">&nbsp;&nbsp;&nbsp;Office Initials:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-i"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='initial_new' id="initial_new" placeholder="Input office initials" required autofocus>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="office_new">&nbsp;&nbsp;&nbsp;Office Name:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='office_new' id="office_new" placeholder="Input new office name" required>
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
                                                            Save New Office
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
                                            <h3 class="card-title"><i class="fas fa-building mr-3"></i>Offices ({{ $count }})</h3>

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
                                                <div class="col-12">
                                                    @foreach($offices as $office)
                                                        <button class="btn btn-sm btn-default mt-1" wire:click="updateOffice({{ $office->id }})"><b>{{ $office->initial }}</b><br>({{ $office->office }})</button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="text-center mt-3 h5">
                                            <i class="fas fa-info-circle mr-1"></i>You have no encoded offices as of the moment.
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="card card-blue">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-building mr-3"></i>Update Office</h3>

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
                                        <form wire:submit.prevent="validateOfficeUpdate">
                                            @csrf

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="initial_up">&nbsp;&nbsp;&nbsp;Office Initials:</label>

                                                                <div class="input-group col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-i"></i></span>
                                                                    </div>

                                                                    <input type="text" class="form-control" wire:model='initial_up' id="initial_up" placeholder="Input updated office initials" required autofocus>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="office_up">&nbsp;&nbsp;&nbsp;Office Name:</label>

                                                                <div class="input-group col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                    </div>

                                                                    <input type="text" class="form-control" wire:model='office_up' id="office_up" placeholder="Input updated office name" required>
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
                                                        Save Updated Office
                                                    </button>

                                                    <button type="submit" class="btn bg-danger" id="btnDelete" wire:click.prevent="$dispatch('triggerDelete',{{ $office_id }})">
                                                        <i class="nav-icon fas fa-times-circle mr-1"></i>
                                                        Delete Office
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
        $('#nav-custom-office').addClass('active');

        Livewire.on('triggerDelete', office_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this operation!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete this office!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('delete_conf', true);
                }
            });
        });
    </script>
@endscript