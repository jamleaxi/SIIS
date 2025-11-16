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

                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                @if($message == '' or $message == null)
                                                    <b class="text-red"><i>No message displayed on all dashboards...</i></b>
                                                @else
                                                    <b class="text-red">Current system message displayed on system users:</b>
                                                    <div class="alert bg-lightblue alert-dismissible mt-3">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                        <h5><i class="icon fas fa-info-circle mr-2"></i>SYSTEM NOTICE</h5>
                                                        {{ $message }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <form wire:submit.prevent="setSystemMessage">
                                        @csrf

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="message_new">&nbsp;&nbsp;&nbsp;Create New System Message: <i class="text-xs text-gray">(To remove displayed message, save a blank form.)</i></label>

                                                            <div class="input-group col-md-12">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-message"></i></span>
                                                                </div>

                                                                <textarea id="message_new" class="form-control" rows="10" maxlength="500" wire:model='message_new' placeholder="Enter new system message..." autofocus></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-sm text-gray float-right">
                                                    <span id="charCount">0</span>/500 characters&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2 mb-2">
                                            <div class="col-12" align="center">
                                                <button type="submit" class="btn bg-blue" id="btnSaveNew">
                                                    <i class="nav-icon fas fa-check mr-1"></i>
                                                    Save New System Message
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
        $('#nav-custom').addClass('active');
        $('#nav-custom-parent').addClass('menu-open');
        $('#nav-custom-sysmsg').addClass('active');

        $('#message_new').on('input', function(e){
            const textarea = document.getElementById('message_new');
            const counter = textarea.value.length;
            document.getElementById("charCount").textContent = '' + counter;
        });
    </script>
@endscript