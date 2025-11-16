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
                            <div class="card card-blue">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12" align="center">
                                            <img src="{{ asset('img/siis-logo.png') }}" height="150"/>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-6">
                                            <div class="small-box bg-maroon">
                                                <div class="inner">
                                                    <h3>{{ $superadmin_count }}</h3>
                                                    @if($superadmin_count > 1)
                                                        <b>SUPERADMINS</b>
                                                    @else
                                                        <b>SUPERADMIN</b>
                                                    @endif
                                                </div>

                                                <div class="icon">
                                                    <i class="fas fa-user-secret"></i>
                                                </div>

                                                <hr>

                                                <div class="ml-3 mb-3" wire:poll.30s>
                                                    <table>
                                                        <tr>
                                                            <td width="65px">Active:</td>
                                                            <td>{{ $superadmin_count_active }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="65px">Inactive:</td>
                                                            <td>{{ $superadmin_count_inactive }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="65px">Locked:</td>
                                                            <td>{{ $superadmin_count_locked }}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <a href="/users-superadmin" class="small-box-footer" style="cursor: pointer">
                                                    View all Superadmins<i class="fas fa-arrow-circle-right ml-2"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-6">
                                            <div class="small-box bg-cyan">
                                                <div class="inner">
                                                    <h3>{{ $administrator_count }}</h3>
                                                    @if($administrator_count > 1)
                                                        <b>ADMINISTRATORS</b>
                                                    @else
                                                        <b>ADMINISTRATOR</b>
                                                    @endif
                                                </div>

                                                <div class="icon">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>

                                                <hr>
                                                
                                                <div class="ml-3 mb-3">
                                                    <table>
                                                        <tr>
                                                            <td width="65px">Active:</td>
                                                            <td>{{ $administrator_count_active }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="65px">Inactive:</td>
                                                            <td>{{ $administrator_count_inactive }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="65px">Locked:</td>
                                                            <td>{{ $administrator_count_locked }}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <a href="/users-administrator" class="small-box-footer" style="cursor: pointer">
                                                    View all Administrators<i class="fas fa-arrow-circle-right ml-2"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-6">
                                            <div class="small-box bg-teal">
                                                <div class="inner">
                                                    <h3>{{ $user_count }}</h3>
                                                    @if($user_count > 1)
                                                        <b>USERS</b>
                                                    @else
                                                        <b>USER</b>
                                                    @endif
                                                </div>

                                                <div class="icon">
                                                    <i class="fas fa-user"></i>
                                                </div>

                                                <hr>
                                                
                                                <div class="ml-3 mb-3">
                                                    <table>
                                                        <tr>
                                                            <td width="65px">Active:</td>
                                                            <td>{{ $user_count_active }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="65px">Inactive:</td>
                                                            <td>{{ $user_count_inactive }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="65px">Locked:</td>
                                                            <td>{{ $user_count_locked }}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <a href="/users-user" class="small-box-footer" style="cursor: pointer">
                                                    View all Users<i class="fas fa-arrow-circle-right ml-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-black"><i class="fas fa-user-gear"></i></span>
                                    
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Registered</span>
                                                    <span class="info-box-number">{{ $superadmin_count + $administrator_count + $user_count }}</span>
                                                </div>
                                                <a href="/users-all" style="cursor: pointer">View all</a>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                                    
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Active</span>
                                                    <span class="info-box-number">{{ $superadmin_count_active + $administrator_count_active + $user_count_active }}</span>
                                                </div>
                                                <a href="/users-active" style="cursor: pointer">View all</a>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-danger"><i class="fas fa-user-xmark"></i></span>
                                    
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Inactive</span>
                                                    <span class="info-box-number">{{ $superadmin_count_inactive + $administrator_count_inactive + $user_count_inactive }}</span>
                                                </div>
                                                <a href="/users-inactive" style="cursor: pointer">View all</a>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning"><i class="fas fa-user-clock"></i></span>
                                    
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Locked</span>
                                                    <span class="info-box-number">{{ $superadmin_count_locked + $administrator_count_locked + $user_count_locked }}</span>
                                                </div>
                                                <a href="/users-locked" style="cursor: pointer">View all</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $('#nav-dashboard').addClass('active');
    </script>
@endscript
