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
                                                Add Unit
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-blue">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-boxes mr-3"></i>Add Unit</h3>

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
                                            <form wire:submit.prevent="validateUnit">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="unit_new">&nbsp;&nbsp;&nbsp;Unit:</label>

                                                                    <div class="input-group col-md-12">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                                        </div>

                                                                        <input type="text" class="form-control" wire:model='unit_new' id="unit_new" placeholder="Input new unit" required autofocus>
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
                                                            Save New Unit
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-boxes mr-3"></i>Encoded Units ({{ $count }})</h3>

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
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach($units as $unit)
                                                <button class="btn btn-sm btn-default mt-1" wire:click="updateUnit({{ $unit->id }})">{{ $unit->unit }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card card-blue">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-boxes mr-3"></i>Update Unit</h3>

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
                                        <form wire:submit.prevent="validateUnitUpdate">
                                            @csrf

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="unit_up">&nbsp;&nbsp;&nbsp;Unit:</label>

                                                                <div class="input-group col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                                    </div>

                                                                    <input type="text" class="form-control" wire:model='unit_up' id="unit_up" placeholder="Input updated unit" required autofocus>
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
                                                        Save Updated Unit
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
        $('#nav-custom-unit').addClass('active');
    </script>
@endscript
