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
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col text-center mb-2">
                                        <img src="{{ asset('img/siis-logo.png') }}" height="85"/>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <span class="badge badge-pill col-12 text-center text-light" style="background-color: #032e59">
                                                <i class="fas fa-user mr-1"></i>
                                                USER DASHBOARD
                                            </span>
                                        </div>

                                        {{-- Pane 1 --}}
                                        <div class="col-lg-3 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-handshake text-blue mr-2" style="width: 50px" align="center"></i>
                                                        {{ $approve_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        {{ $approve_count > 1 ? "REQUESTS YOU APPROVED" : "REQUEST YOU APPROVED" }}
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $approve_counts }} standard, 
                                                            {{ $approve_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-paper-plane text-blue mr-2" style="width: 50px" align="center"></i>
                                                        {{ $request_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        {{ $request_count > 1 ? "REQUESTS YOU CREATED" : "REQUEST YOU CREATED" }}
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $request_counts }} standard, 
                                                            {{ $request_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Pane 2 --}}
                                        <div class="col-lg-3 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-user-check text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $for_approval }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $for_approval > 1 ? "requests for approval" : "request for approval" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $for_approvals }} standard, 
                                                            {{ $for_approvalp }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-check-to-slot text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $for_assessment }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $for_assessment > 1 ? "requests for assessment" : "request for assessment" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $for_assessments }} standard, 
                                                            {{ $for_assessmentp }} project)
                                                        </i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Pane 3 --}}
                                        <div class="col-lg-3 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-clipboard-check text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $for_issuance }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $for_issuance > 1 ? "requests for issuance" : "request for issuance" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $for_issuances }} standard, 
                                                            {{ $for_issuancep }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-thumbs-up text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $for_receive }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $for_receive > 1 ? "requests received" : "request received" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $for_receives }} standard, 
                                                            {{ $for_receivep }} project)
                                                        </i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Pane 4 --}}
                                        <div class="col-lg-3 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-check-double text-success mr-2" style="width: 50px" align="center"></i>
                                                        {{ $receive_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $receive_count > 1 ? "requests confirmed" : "request confirmed" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $receive_counts }} standard, 
                                                            {{ $receive_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-xmarks-lines text-danger mr-2" style="width: 50px" align="center"></i>
                                                        {{ $nreceive_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $nreceive_count > 1 ? "requests not confirmed" : "request not confirmed" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $nreceive_counts }} standard, 
                                                            {{ $nreceive_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>
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
