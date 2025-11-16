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
                                <div class="card-body" wire:poll.30s>
                                    <div class="col text-center mb-2">
                                        <img src="{{ asset('img/siis-logo.png') }}" height="85"/>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <span class="badge badge-pill col-12 text-center text-light" style="background-color: #032e59">
                                                <i class="fas fa-user-tie mr-1"></i>
                                                ADMINISTRATIVE DASHBOARD
                                            </span>
                                        </div>

                                        {{-- Pane 1 --}}
                                        <div class="col-lg-4 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <span class="badge bg-info">
                                                    <i class="fas fa-chart-column mr-1"></i>General Information on Requests
                                                </span>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-database text-blue mr-2" style="width: 50px" align="center"></i>
                                                        {{ $assessment_count + $issuance_count + $complete_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        {{ ($assessment_count + $issuance_count + $complete_count) > 1 ? "TOTAL SUPPLY REQUESTS" : "TOTAL SUPPLY REQUEST" }}
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $assessment_count_s + $issuance_count_s + $complete_count_s }} standard, 
                                                            {{ $assessment_count_p + $issuance_count_p + $complete_count_p }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <hr>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-clipboard-check text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $assessment_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $assessment_count > 1 ? "pending assessments" : "pending assessment" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $assessment_count_s }} standard, 
                                                            {{ $assessment_count_p }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-thumbs-up text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $issuance_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $issuance_count > 1 ? "pending issuances" : "pending issuance" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $issuance_count_s }} standard, 
                                                            {{ $issuance_count_p }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold" style="line-height: 1;">
                                                        <i class="fas fa-check-circle text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $complete_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            completely processed
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $complete_count_s }} standard, 
                                                            {{ $complete_count_p }} project)
                                                        </i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Pane 2 --}}
                                        <div class="col-lg-4 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <span class="badge bg-info">
                                                    <i class="fas fa-chart-bar mr-1"></i>Your Involvements as an Administrator
                                                </span>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-handshake-simple text-blue mr-2" style="width: 50px" align="center"></i>
                                                        {{ $involvement_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        {{ $involvement_count > 1 ? "SUPPLY INVOLVEMENTS" : "SUPPLY INVOLVEMENT" }}
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $involvement_counts }} standard, 
                                                            {{ $involvement_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <hr>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-clipboard-check text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $assess_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $assess_count > 1 ? "requests assessed" : "request assessed" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $assess_counts }} standard, 
                                                            {{ $assess_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>

                                                <div class="col-12 mt-3" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-clipboard-check text-cyan mr-2" style="width: 50px" align="center"></i>
                                                        {{ $issue_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $issue_count > 1 ? "requests issued" : "request issued" }}
                                                        </i>
                                                    </span>

                                                    <span class="text-muted text-xs">
                                                        <i>
                                                            <br>
                                                            ({{ $issue_counts }} standard, 
                                                            {{ $issue_countp }} project)
                                                        </i>
                                                    </span>
                                                </div>
                                                
                                                <hr>

                                                <div class="col-12 mt-3 text-muted" style="line-height: 1;">
                                                    <div class="text-xl text-bold">
                                                        <i class="fas fa-magnifying-glass-arrow-right mr-2" style="width: 50px" align="center"></i>
                                                        {{ $incoming_count }}
                                                    </div>

                                                    <span class="text-bold text-sm">
                                                        <i>
                                                            {{ $incoming_count > 1 ? "incoming requests" : "incoming request" }}
                                                        </i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Pane 3 --}}
                                        <div class="col-lg-4 col-md-12 col-sm-12 mt-3">
                                            <div class="callout callout-outline callout-success">
                                                <span class="badge bg-info">
                                                    <i class="fas fa-chart-simple mr-1"></i>Top 10 Requesting Offices/Units
                                                </span>

                                                <div class="col-12 mt-3 text-muted" style="line-height: 1;" align="center">
                                                    <hr>

                                                    @foreach($top_requesters as $top_requester)
                                                        <div class="row mb-2">
                                                            <span class="badge badge-pill col-1 text-sm bg-blue text-center">{{ $loop->iteration }}</span>

                                                            @foreach($centers->where('code','=',$top_requester->ccode) as $center)
                                                                <span class="badge badge-pill col-9 text-sm bg-gray-light text-left">{{ $center->center }}</span>
                                                            @endforeach

                                                            <span class="badge badge-pill col-2 text-sm bg-cyan text-center">{{ $top_requester->total_requests }}</span>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <div class="mt-2"><i class="fas fa-info-circle mt-1 mr-1"></i><i class="text-sm">Ranking is based on number of overall requests ***</i></div>
                                                </div>
                                            </div>
                                        </div>
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

                    <div class="row" wire:ignore>
                        <div class="col-12">
                            <span class="badge badge-pill col-12 text-center text-light" style="background-color: #032e59">
                                <i class="fas fa-chart-line mr-1"></i>
                                MONTHLY SUPPLIES OVERVIEW
                            </span>
                        </div>
                    
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-line mr-2"></i>
                                        Monthly Item Requests Trend
                                    </h3>
                                    <div class="card-tools">
                                        <a href="{{ url('/monthly-report-supplies') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-external-link-alt mr-1"></i>View Detailed Report
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(isset($monthly_chart_data) && count($monthly_chart_data['labels']) > 0)
                                        <div style="position: relative; height: 300px; width: 100%;">
                                            <canvas id="monthlySuppliesChart"></canvas>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            No transaction data available for the selected period.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <span class="badge badge-pill col-12 text-center text-light" style="background-color: #032e59">
                                <i class="fas fa-chart-line mr-1"></i>
                                MONTHLY SUPPLIES OVERVIEW
                            </span>
                        </div>
                    
                        <div class="col-12 col-md-12 col-sm-12 mt-3">
                            <div class="callout callout-outline callout-success">
                                <span class="badge bg-info">
                                    <i class="fas fa-chart-simple mr-1"></i>Top 10 Items Requested
                                </span>

                                <div class="col-12 mt-3 text-muted" style="line-height: 1;" align="center">
                                    <hr>

                                    @foreach($top_items as $top_item)
                                        <div class="row mb-2">
                                            <span class="badge badge-pill col-1 text-sm bg-blue text-center">{{ $loop->iteration }}</span>

                                            <span class="badge badge-pill col-9 text-sm bg-gray-light text-left">{{ $top_item->item_name }}</span>

                                            <span class="badge badge-pill col-2 text-sm bg-cyan text-center">{{ $top_item->total_requested }}</span>
                                        </div>
                                    @endforeach
                                    
                                    <div class="mt-2"><i class="fas fa-info-circle mt-1 mr-1"></i><i class="text-sm">Ranking is based on number of overall requests ***</i></div>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let monthlyChart = null;

            function createMonthlyChart() {
                if (typeof Chart === 'undefined') {
                    setTimeout(createMonthlyChart, 100);
                    return;
                }

                const canvas = document.getElementById('monthlySuppliesChart');
                if (!canvas) return;

                if (monthlyChart) {
                    monthlyChart.destroy();
                }

                @if(isset($monthly_chart_data) && count($monthly_chart_data['labels']) > 0)
                
                const chartData = {
                    labels: {!! json_encode($monthly_chart_data['labels']) !!},
                    total: {!! json_encode($monthly_chart_data['total']) !!},
                    received: {!! json_encode($monthly_chart_data['received']) !!},
                    issued: {!! json_encode($monthly_chart_data['issued']) !!}
                };

                console.log('Chart data:', chartData);

                monthlyChart = new Chart(canvas.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [
                            {
                                label: 'Total Requests',
                                data: chartData.total,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#3B82F6',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Items Received',
                                data: chartData.received,
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#10B981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Items Issued',
                                data: chartData.issued,
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#F59E0B',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                console.log('✓ Chart created successfully!');
                @endif
            }

            createMonthlyChart();
        });
    </script>

    @livewireScripts
</body>

@script
    <script>
        $('#nav-dashboard').addClass('active');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <script>
        (function() {
            'use strict';
            
            function initMonthlySuppliesChart() {
                const canvas = document.getElementById('monthlySuppliesChart');
                if (!canvas) {
                    console.log('Canvas not found');
                    return;
                }
        
                if (typeof Chart === 'undefined') {
                    console.log('Chart.js not loaded, waiting...');
                    setTimeout(initMonthlySuppliesChart, 200);
                    return;
                }
        
                @if(isset($monthly_chart_data) && count($monthly_chart_data['labels']) > 0)
                
                const chartData = {
                    labels: {!! json_encode($monthly_chart_data['labels']) !!},
                    total: {!! json_encode($monthly_chart_data['total']) !!},
                    received: {!! json_encode($monthly_chart_data['received']) !!},
                    issued: {!! json_encode($monthly_chart_data['issued']) !!}
                };
        
                console.log('Chart data:', chartData);
        
                const ctx = canvas.getContext('2d');
                
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [
                            {
                                label: 'Total Requests',
                                data: chartData.total,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#3B82F6',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Items Received',
                                data: chartData.received,
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#10B981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Items Issued',
                                data: chartData.issued,
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#F59E0B',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.parsed.y;
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });
        
                console.log('Chart created successfully:', myChart);
                
                @else
                console.log('No monthly chart data available');
                @endif
            }
        
            // Initialize when page loads
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMonthlySuppliesChart);
            } else {
                // DOM already loaded
                initMonthlySuppliesChart();
            }
        })();
    </script>
@endscript