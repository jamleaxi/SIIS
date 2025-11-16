<!-- Navbar -->
@if ($dark_setting == 'ON')
    <nav class="main-header navbar navbar-expand navbar-dark" wire:ignore>
@else
    <nav class="main-header navbar navbar-expand navbar-light" wire:ignore>
@endif

    <!-- SEARCH FORM -->
    <!--form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
            </div>
        </div>
    </form-->

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link text-blue" style="cursor: default"><b>Hello, {{ $my_name }}!</b> • <i>{{ $my_position_full }} ({{ $my_office }})</i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                @if ($dark_setting == 'ON')
                    <i class="fas fa-moon" style="color: #3f6791"></i>
                @else
                    <i class="fas fa-sun" style="color: #fcd53f"></i>
                @endif

                @if($system_message != '' or $system_message != null)
                    @if ($dark_setting == 'ON')
                        <span class="badge navbar-badge"><i class="fas fa-info-circle text-info"></i></span>
                    @else
                        <span class="badge navbar-badge"><i class="fas fa-info-circle text-info"></i></span>
                    @endif
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{ asset('img/JRMSU.png') }}" alt="User Avatar" class="img-size-50 mr-3">
                        <div class="media-body">
                            @if($system_message != '' or $system_message != null)
                                <h3 class="dropdown-item-title">
                                    System Notice
                                    <span class="float-right text-sm text-danger"><i class="fab fa-laravel"></i></span>
                                </h3>

                                <p class="text-sm text-justify">{{ $system_message }}</p>
                            @else
                                <p class="text-sm text-muted"><i>There are no system messages at the moment...</i></p>
                            @endif
                        </div>
                    </div>
                </a>

                <div class="dropdown-divider"></div>

                <a href="{{ route('profile.show') }}" class="dropdown-item dropdown-footer">Update My Profile</a>
            </div>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->