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
                        </div>

                        @if($show_view == true)
                        <div class="col-md-12 mt-3">
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-user-tie mr-3"></i>Profile View</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>

                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <button type="button" class="btn btn-tool" wire:click='hideViewPane'>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            @if($profile_photo_path == '' or $profile_photo_path == null)
                                                <img src="{{ asset('img/unavailable.jpg') }}" class="img-circle" width="100%">
                                            @else
                                                <img src="{{ 'storage/'.$profile_photo_path }}" class="img-circle" width="100%">
                                            @endif
                                        </div>

                                        <div class="col-10">
                                            <div class="col-12 ml-3">
                                                <h4 class="text-danger"><b>{{ strToUpper($role) }}</b></h4>
                                                <hr>
                                                <h1><b>{{ strToUpper($name) }}</b></h1>
                                                <h5>{{ $position_full }} ({{ $position }})</h5>
                                                <h5>{{ $office_full }} ({{ $office }})</h5>
                                                <hr>
                                                <h6>
                                                    @if($status == "ACTIVE")
                                                        <div class="text-success"><i class="fas fa-user-check mr-1"></i>Active ({{ $email }})</div>
                                                    @elseif($status == "INACTIVE")
                                                        <div class="text-danger"><i class="fas fa-user-xmark mr-1"></i>Inactive ({{ $email }})</div>
                                                    @else
                                                        <div class="text-warning"><i class="fas fa-user-clock mr-1"></i>Locked ({{ $email }})</div>
                                                    @endif
                                                </h6>
                                                <h6>Account created: {{ $created_at }} <i class="text-gray"> » {{ $created_at_parsed }} ago</i></h6>
                                                <h6>Last updated: {{ $updated_at }} <i class="text-gray"> » {{ $updated_at_parsed }} ago</i></h6>
                                                <hr>
                                                <h6>
                                                    @if($profile_photo_path == '' or $profile_photo_path == null)
                                                        Photo status: UNAVAILABLE<i class="fas fa-times-circle text-danger ml-1"></i>
                                                    @else
                                                        Photo status: AVAILABLE<i class="fas fa-check-circle text-success ml-1"></i>
                                                    @endif
                                                </h6>
                                                <h6>
                                                    @if($dark_mode == 'OFF')
                                                        Dark mode status: {{ $dark_mode }}<i class="fas fa-sun text-warning ml-1"></i>
                                                    @else
                                                        Dark mode status: {{ $dark_mode }}<i class="fas fa-moon text-purple ml-1"></i>
                                                    @endif
                                                </h6>
                                                <hr>
                                                <h6>
                                                    @if($supply_staff == 'YES')
                                                        Supply staff: {{ $supply_staff }}<i class="fas fa-unlock text-success ml-1"></i>
                                                    @else
                                                        Supply staff: {{ $supply_staff }}<i class="fas fa-lock text-warning ml-1"></i>
                                                    @endif
                                                </h6>
                                                <h6>
                                                    @if($issuer_level == 'YES')
                                                        Issuer: {{ $issuer_level }}<i class="fas fa-unlock text-success ml-1"></i>
                                                    @else
                                                        Issuer: {{ $issuer_level }}<i class="fas fa-lock text-warning ml-1"></i>
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($show_edit == true)
                            <div class="col-md-12 mt-3">
                                <div class="card card-blue">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-user-tie mr-3"></i>Profile Update</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                <i class="fas fa-expand"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <button type="button" class="btn btn-tool" wire:click='hideEditPane'>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mt-3 ml-3">
                                                    <h6><b>SIIS Profile Information</b></h6>
                                                    <h6>Update email, office and position information.</h6>
                                                </div>
                                            </div>

                                            <div class="col-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <form wire:submit.prevent="validateChanges">
                                                                    <div class="form-group">
                                                                        <label for="email_up">&nbsp;&nbsp;&nbsp;Email Address:</label>
    
                                                                        <div class="input-group col-md-12">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                                                            </div>
    
                                                                            <input type="text" class="form-control" wire:model='email_up' id="email_up" placeholder="Input new email address" required>
                                                                        </div>

                                                                        <div class="text-right text-blue">Current: {{ $email }}</div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label for="office_full_up">&nbsp;&nbsp;&nbsp;Office/Unit:</label>
        
                                                                        <div class="input-group col-md-12">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                            </div>
        
                                                                            <select class="form-control" wire:model='office_full_up' id="office_full_up" wire:click='getOffice' required>
                                                                                <option value="" class="text-blue">••• Please select an office:</option>
                                                                                @foreach($offices as $ofc)
                                                                                    <option value="{{ $ofc->office }}">{{ $ofc->office }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="text-right text-blue">Current: {{ $office_full }}</div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="office_up">&nbsp;&nbsp;&nbsp;Office/Unit Initials:</label>
        
                                                                        <div class="input-group col-md-12">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-font"></i></span>
                                                                            </div>
        
                                                                            <input type="text" class="form-control" wire:model='office_up' id="office_up" placeholder="Office/Unit Initials" disabled required>
                                                                        </div>

                                                                        <div class="text-right text-blue">Current: {{ $office }}</div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="position_full_up">&nbsp;&nbsp;&nbsp;Position/Designation:</label>
        
                                                                        <div class="input-group col-md-12">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                            </div>
        
                                                                            <select class="form-control" wire:model='position_full_up' id="position_full_up" wire:click='getPosition' required>
                                                                                <option value="" class="text-blue">••• Please select a position title:</option>
                                                                                @foreach($positions as $pos)
                                                                                    <option value="{{ $pos->position }}">{{ $pos->position }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="text-right text-blue">Current: {{ $position_full }}</div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="position_up">&nbsp;&nbsp;&nbsp;Position/Designation Initials:</label>
        
                                                                        <div class="input-group col-md-12">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-font"></i></span>
                                                                            </div>
        
                                                                            <input type="text" class="form-control" wire:model='position_up' id="position_up" placeholder="Position/Designation Initials" disabled required>
                                                                        </div>

                                                                        <div class="text-right text-blue">Current: {{ $position }}</div>
                                                                    </div>

                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn bg-blue"><i class="fas fa-save mr-2"></i>Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12 mt-3">
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-user-tie mr-3"></i>Administrators ({{ $count }})</h3>

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
                                        
                                        @if($admin_issuer < 1)
                                            <span class="badge badge-danger mb-3"><i class="fas fa-info-circle mr-1"></i>Please select an issuer!</span>
                                        @else
                                            <span class="badge badge-success mb-3"><i class="fas fa-info-circle mr-1"></i>Issuer: {{ $admin_issuer_set }}</span>
                                        @endif

                                        <table class="table table-sm table-responsive-sm table-hover">
                                            <thead class="bg-blue">
                                                <tr>
                                                    <th width="3%"></th>
                                                    <th width="3%"></th>
                                                    <th width="18%">Name</th>
                                                    <th width="18%">Email</th>
                                                    <th width="20%">Office</th>
                                                    <th width="20%">Position</th>
                                                    <th width="8%">Status</th>
                                                    <th width="10%"><i class="fas fa-tasks"></i></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($administrators as $administrator)
                                                    <tr>
                                                        <td align="center">{{ $loop->iteration }}</td>
                                                        <td><img src="{{ $administrator->profile_photo_url }}" class="img-circle" width="25" height="25"></td>
                                                        <td>
                                                            @if($administrator->issuer_level == 'YES')
                                                                <b>{{ $administrator->name }} (Issuer)</b>
                                                            @else
                                                                {{ $administrator->name }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $administrator->email }}</td>
                                                        <td>{{ $administrator->office }} ({{ $administrator->office_full }})</td>
                                                        <td>{{ $administrator->position }} ({{ $administrator->position_full }})</td>
                                                        <td>
                                                            @if($administrator->status == "ACTIVE")
                                                                <div class="text-success"><i class="fas fa-user-check mr-1"></i>Active</div>
                                                            @elseif($administrator->status == "INACTIVE")
                                                                <div class="text-danger"><i class="fas fa-user-xmark mr-1"></i>Inactive</div>
                                                            @else
                                                                <div class="text-warning"><i class="fas fa-user-clock mr-1"></i>Locked</div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-xs bg-primary" wire:click="viewAdministrator({{ $administrator->id }})"><i class="fas fa-eye" style="cursor: pointer"></i></a>
                                                            <a class="btn btn-xs bg-purple" wire:click="editAdministrator({{ $administrator->id }})"><i class="fas fa-building-user" style="cursor: pointer"></i></a>
                                                            
                                                            @if($administrator->status == "ACTIVE")
                                                                @if($count > 1 and $administrator_active > 2)
                                                                    @if($administrator->issuer_level == "NO")
                                                                        <a class="btn btn-xs bg-danger" wire:click="setDeactivate({{ $administrator->id }})"><i class="fas fa-user-xmark" style="cursor: pointer"></i></a>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <a class="btn btn-xs bg-success" wire:click.prevent="setActivate({{ $administrator->id }})"><i class="fas fa-user-check" style="cursor: pointer"></i></a>
                                                            @endif

                                                            @if($administrator->supply_staff == "YES")
                                                                @if($administrator->issuer_level == "NO")
                                                                    <a class="btn btn-xs bg-pink" wire:click.prevent="setStaffRemove({{ $administrator->id }})"><i class="fas fa-user-minus" style="cursor: pointer"></i></a>
                                                                @endif
                                                            @endif

                                                            @if($admin_issuer < 1 and $administrator->supply_staff == "YES")
                                                                <a class="btn btn-xs bg-navy" wire:click.prevent="setIssuer({{ $administrator->id }})"><i class="fas fa-user-lock" style="cursor: pointer"></i></a>
                                                            @endif

                                                            @if($administrator->issuer_level == "YES")
                                                                <a class="btn btn-xs bg-gray" wire:click.prevent="setIssuerRemove({{ $administrator->id }})"><i class="fas fa-user-slash" style="cursor: pointer"></i></a>
                                                            @endif
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

                                        <div class="mt-3">
                                            {{ $administrators->links(data: ['scrollTo' => false]) }}
                                        </div>

                                        <div class="col-12 mt-3 text-right"><a class="text-success">Active: {{ $administrator_active }}</a> | <a class="text-danger">Inactive: {{ $administrator_inactive }}</a> | <a class="text-warning">Locked: {{ $administrator_locked }}</a></div>
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
        $('#nav-users').addClass('active');
        $('#nav-users-parent').addClass('menu-open');
        $('#nav-users-admin').addClass('active');

        Livewire.on('triggerActivate', s_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be ACTIVATED upon confirmation.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, activate this user!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('confirm_activate', true);
                }
            });
        });

        Livewire.on('triggerDeactivate', s_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This account will be DEACTIVATED and will automatically be logged out upon confirmation.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, deactivate this account!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('confirm_deactivate', true);
                }
            });
        });

        Livewire.on('triggerIssuer', s_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This account will be SET AS THE GLOBAL ISSUER for the whole system.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, make this account as the issuer!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('confirm_issuer', true);
                }
            });
        });

        Livewire.on('triggerIssuerRemove', s_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This account will be REMOVED AS THE GLOBAL ISSUER for the whole system upon confirmation.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove this account as the issuer!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('confirm_issuer_remove', true);
                }
            });
        });

        Livewire.on('triggerStaffRemove', s_id => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This account will be REMOVED AS AN ADMINISTRATOR upon confirmation.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d9970',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove this account as an administrator!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('confirm_staff_remove', true);
                }
            });
        });
    </script>
@endscript