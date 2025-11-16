<!-- Main Sidebar Container -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark elevation-4 sidebar-dark-blue" style="font-size: 14px" wire:ignore>
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('img/JRMSU.png') }}" alt="SIIS" class="brand-image img-circle elevation-3" style="opacity: 1">
        <span class="brand-text font-weight-light">JRMSU SIIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <a href="{{ route('profile.show') }}" style="cursor: default">
                    @if(Auth::id())
                        <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2" style="cursor: pointer">
                    @else
                        <img src="{{ asset('img/unavailable.jpg') }}" class="img-circle elevation-2" style="cursor: pointer">
                    @endif
                </a>
            </div>
            <div class="info">
                <a class="d-block" style="cursor: default">{{ $my_role }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" id="sidebarSearch" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
            
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!--DASHBOARD-->
                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link" id="nav-dashboard">
                        <i class="nav-icon text-warning fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li><!--END DASHBOARD-->

                @if($my_role == 'Administrator' or $my_role == 'User')
                    <!--REQUEST-->
                    <li class="nav-item" id="nav-request-parent">
                        <a href="" class="nav-link" id="nav-request">
                            <i class="nav-icon text-warning fas fa-ticket"></i>
                            <p>
                                Requisitions
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        @if($my_role == 'Administrator')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/request-assessment') }}" class="nav-link" id="nav-request-assessment">
                                        <i class="nav-icon fas fa-check-to-slot"></i>
                                        <p>
                                            For Assessment
                                        </p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/request-issuance') }}" class="nav-link" id="nav-request-issuance">
                                        <i class="nav-icon fas fa-clipboard-check"></i>
                                        <p>
                                            For Issuance
                                        </p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/request-issued') }}" class="nav-link" id="nav-request-issued">
                                        <i class="nav-icon fas fa-thumbs-up"></i>
                                        <p>
                                            Completed
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endif

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/request-sent') }}" class="nav-link" id="nav-request-sent">
                                    <i class="nav-icon fas fa-paper-plane"></i>
                                    <p>
                                        My Requests
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/request-shared') }}" class="nav-link" id="nav-request-shared">
                                    <i class="nav-icon fas fa-handshake"></i>
                                    <p>
                                        Shared with You
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li><!--END REQUEST-->
                @endif

                @if($my_role == 'Administrator' or $my_role == 'User')
                    <!--ISSUANCES/ALL INVOLVED-->
                    <li class="nav-item" id="nav-issuance-parent">
                        <a href="" class="nav-link" id="nav-issuance">
                            <i class="nav-icon text-warning fas fa-check-circle"></i>
                            <p>
                                Issuances
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/request-received') }}" class="nav-link" id="nav-issuance-supply">
                                    <i class="nav-icon fas fa-pencil-ruler"></i>
                                    <p>
                                        Received Supplies
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li><!--END REQUEST-->
                @endif

                @if($my_role == 'Administrator' or $my_role == 'User')
                    <!--TRANSACTION-->
                    <li class="nav-item" id="nav-transaction-parent">
                        <a href="" class="nav-link" id="nav-transaction">
                            <i class="nav-icon text-warning fas fa-paper-plane"></i>
                            <p>
                                Create
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/transaction-cs') }}" class="nav-link" id="nav-transaction-cs">
                                    <i class="nav-icon fas fa-pencil-ruler"></i>
                                    <p>
                                        Supplies Request
                                    </p>
                                </a>
                            </li>

                            {{-- @if($my_role == 'Administrator')
                                <li class="nav-item">
                                    <a href="{{ url('/transaction-custom-cs') }}" class="nav-link" id="nav-transaction-custom-cs">
                                        <i class="nav-icon fas fa-file-pen"></i>
                                        <p>
                                            Project Request
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/transaction-sep') }}" class="nav-link" id="nav-transaction-sep">
                                        <i class="nav-icon fas fa-chalkboard"></i>
                                        <p>
                                            SEP Custodian
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/transaction-ppe') }}" class="nav-link" id="nav-transaction-ppe">
                                        <i class="nav-icon fas fa-computer"></i>
                                        <p>
                                            PPE Recipient
                                        </p>
                                    </a>
                                </li>
                            @endif --}}
                        </ul>
                    </li><!--END TRANSACTION-->
                @endif

                @if($my_role == 'Administrator')
                    <!--MASTERLIST-->
                    <li class="nav-item" id="nav-masterlist-parent">
                        <a href="" class="nav-link" id="nav-masterlist">
                            <i class="nav-icon text-warning fas fa-chart-bar"></i>
                            <p>
                                Inventory
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/masterlist-cs') }}" class="nav-link" id="nav-masterlist-cs">
                                    <i class="nav-icon fas fa-pencil-ruler"></i>
                                    <p>
                                        <b>Supply</b><br>Supplies and Materials
                                    </p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="{{ url('/masterlist-sep') }}" class="nav-link" id="nav-masterlist-sep">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        <b>SEP</b><br>Semi-Expendable Property
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/masterlist-ppe') }}" class="nav-link" id="nav-masterlist-ppe">
                                    <i class="nav-icon fas fa-computer"></i>
                                    <p>
                                        <b>PPE</b><br>Property, Plant & Equipment
                                    </p>
                                </a>
                            </li> --}}
                        </ul>
                    </li><!--END MASTERLIST-->
                @endif
                
                @if($my_role == 'Administrator')
                    <!--REPORTS-->
                    <li class="nav-item" id="nav-report-parent">
                        <a href="" class="nav-link" id="nav-report">
                            <i class="nav-icon text-warning fas fa-file-signature"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/report-cs') }}" class="nav-link" id="nav-report-cs">
                                    <i class="nav-icon fas fa-pencil-ruler"></i>
                                    <p>
                                        Supply Stock Card
                                    </p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="{{ url('/report-ris') }}" class="nav-link" id="nav-report-ris">
                                    <i class="nav-icon fas fa-pencil-ruler"></i>
                                    <p>
                                        RIS Report
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/report-sep') }}" class="nav-link" id="nav-report-sep">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        SEP Custodians
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/report-ics') }}" class="nav-link" id="nav-report-ics">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        ICS Report
                                    </p>
                                </a>
                            </li> --}}
                        </ul>
                    </li><!--END REPORTS-->
                @endif

                <!--LOGS-->
                {{-- <li class="nav-item">
                    <a href="" class="nav-link" id="nav-logs">
                        <i class="nav-icon text-warning fas fa-server"></i>
                        <p>
                            Logs
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/logs-data') }}" class="nav-link" id="nav-logs-data">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Data Updates
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/logs-system') }}" class="nav-link" id="nav-logs-system">
                                <i class="nav-icon fas fa-stream"></i>
                                <p>
                                    System Activities
                                </p>
                            </a>
                        </li>
                    </ul>
                </li><!--END LOGS--> --}}

                @if($my_role == 'Superadmin')
                    <!--USERS-->
                    <li class="nav-item" id="nav-users-parent">
                        <a href="" class="nav-link" id="nav-users">
                            <i class="nav-icon text-warning fas fa-id-card-alt"></i>
                            <p>
                                System Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/users-superadmin') }}" class="nav-link" id="nav-users-superadmin">
                                    <i class="nav-icon fas fa-user-secret"></i>
                                    <p>
                                        Superadmins
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/users-administrator') }}" class="nav-link" id="nav-users-admin">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        Administrators
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/users-user') }}" class="nav-link" id="nav-users-user">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/users-all') }}" class="nav-link" id="nav-users-all">
                                    <i class="nav-icon fas fa-user-gear text-gray"></i>
                                    <p>
                                        All Registered
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/users-active') }}" class="nav-link" id="nav-users-active">
                                    <i class="nav-icon fas fa-user-check text-gray"></i>
                                    <p>
                                        Active Users
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/users-inactive') }}" class="nav-link" id="nav-users-inactive">
                                    <i class="nav-icon fas fa-user-xmark text-gray"></i>
                                    <p>
                                        Inactive Users
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/users-locked') }}" class="nav-link" id="nav-users-locked">
                                    <i class="nav-icon fas fa-user-clock text-gray"></i>
                                    <p>
                                        Locked Users
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li><!--END USERS-->
                @endif

                @if($my_role == 'Superadmin' or $my_role == 'Administrator' or $my_role == 'User')
                    <!--CUSTOM INFO-->
                    <li class="nav-item" id="nav-custom-parent">
                        <a href="" class="nav-link" id="nav-custom">
                            <i class="nav-icon text-warning fas fa-columns"></i>
                            <p>
                                Custom Information
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @if($my_role == 'Administrator')
                                <li class="nav-item">
                                    <a href="{{ url('/custom-category') }}" class="nav-link" id="nav-custom-category">
                                        <i class="nav-icon fas fa-clone"></i>
                                        <p>
                                            Classifications
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/custom-unit') }}" class="nav-link" id="nav-custom-unit">
                                        <i class="nav-icon fas fa-boxes"></i>
                                        <p>
                                            Units
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/custom-entity') }}" class="nav-link" id="nav-custom-entity">
                                        <i class="nav-icon fas fa-landmark-flag"></i>
                                        <p>
                                            Entities
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/custom-division') }}" class="nav-link" id="nav-custom-division">
                                        <i class="nav-icon fas fa-building-flag"></i>
                                        <p>
                                            Divisions
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/custom-center') }}" class="nav-link" id="nav-custom-center">
                                        <i class="nav-icon fas fa-building-circle-arrow-right"></i>
                                        <p>
                                            Center Codes
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/custom-fund') }}" class="nav-link" id="nav-custom-fund">
                                        <i class="nav-icon fas fa-donate"></i>
                                        <p>
                                            Funds
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if($my_role == 'Administrator' or $my_role == 'User')
                                <li class="nav-item">
                                    <a href="{{ url('/custom-signature') }}" class="nav-link" id="nav-custom-signature">
                                        <i class="nav-icon fas fa-signature"></i>
                                        <p>
                                            E-Signature
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if($my_role == 'Superadmin' or $my_role == 'Administrator')
                                <li class="nav-item">
                                    <a href="{{ url('/custom-office') }}" class="nav-link" id="nav-custom-office">
                                        <i class="nav-icon fas fa-building"></i>
                                        <p>
                                            Offices
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/custom-position') }}" class="nav-link" id="nav-custom-position">
                                        <i class="nav-icon fas fa-address-card"></i>
                                        <p>
                                            Positions
                                        </p>
                                    </a>
                                </li>

                                @if($my_role == 'Superadmin')
                                    <li class="nav-item">
                                        <a href="{{ url('/sysmsg') }}" class="nav-link" id="nav-custom-sysmsg">
                                            <i class="nav-icon fas fa-message"></i>
                                            <p>
                                                System Message
                                            </p>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li><!--END CUSTOM INFO-->
                @endif

            </ul>
        </nav>
    </div>

    <div class="sidebar-custom">
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf

            <h1 class="btn btn-link">
                <x-responsive-nav-link href="{{ route('logout') }}"
                    @click.prevent="$root.submit();">
                    <i class="text-warning fas fa-sign-out-alt"></i>
                </x-responsive-nav-link>
            </h1>
        </form>
</aside>