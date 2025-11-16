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

                            <div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="fw-bold">Year</label>
                                        <select wire:model="year" class="form-control">
                                            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                            
                                    <div class="col-md-3">
                                        <label class="fw-bold">Month</label>
                                        <select wire:model="month" class="form-control">
                                            @foreach (range(1, 12) as $m)
                                                <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Monthly Supplies Summary</h5>
                                    </div>
                            
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Item</th>
                                                    <th class="text-end">Beg. Balance</th>
                                                    <th class="text-end">Total In</th>
                                                    <th class="text-end">Total Out</th>
                                                    <th class="text-end">Ending Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($summary as $s)
                                                    <tr>
                                                        <td>{{ $s->code }}</td>
                                                        <td>{{ $s->item }}</td>
                                                        <td class="text-end">{{ $s->beginning_balance }}</td>
                                                        <td class="text-end text-success fw-bold">{{ $s->total_in }}</td>
                                                        <td class="text-end text-danger fw-bold">{{ $s->total_out }}</td>
                                                        <td class="text-end fw-bold">{{ $s->ending_balance }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-3">
                                                            No data found for this month.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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
        $('#nav-masterlist').addClass('active');
        $('#nav-masterlist-parent').addClass('menu-open');
        $('#nav-masterlist-cs').addClass('active');
    </script>
@endscript