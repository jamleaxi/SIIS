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

                            <div class="card card-dark">
                                <div class="card-header">
                                    @if($update_signature == false)
                                        <h3 class="card-title"><i class="fas fa-signature mr-3"></i>Your E-Signature</h3>
                                    @else
                                        <h3 class="card-title"><i class="fas fa-signature mr-3"></i>Update Your E-Signature</h3>
                                    @endif

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>

                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        @if($update_signature == true)
                                        <button type="button" class="btn btn-tool" wire:click='resetFormUpdate'>
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3"></div>

                                        <div class="col-6" align="center">
                                            @error('signature_path_new')
                                                <div class="alert alert-info alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    <i class="icon fas fa-info-circle mr-2"></i>Please select an image or wait for the signature preview before clicking upload.
                                                </div>
                                            @enderror

                                            @error('signature_path_up')
                                                <div class="alert alert-info alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    <i class="icon fas fa-info-circle mr-2"></i>Please select an image or wait for the signature preview before clicking upload.
                                                </div>
                                            @enderror

                                            @forelse ($signatures as $signature)
                                                @if($update_signature == false)
                                                    <img src="storage/{{ $signature->signature_path }}" width="500" alt="E-Signature">

                                                    <div class="text-success mt-3 mb-3"><i class="fas fa-check-circle mr-1"></i><b>Your e-Signature is available.</b><br><i>Please note that your e-signature will only reflect on the digital view of forms and not on the official (printed) ones. Thank you.</i></div>

                                                    <button type="" class="btn bg-blue mt-2" wire:click="updateSignature({{ $signature->id }})">
                                                        <i class="nav-icon fas fa-refresh mr-1"></i>
                                                        Update e-Signature
                                                    </button>
                                                @else
                                                    <div class="text-success mb-3"><i class="fas fa-refresh mr-1"></i><b>Update e-Signature:</b></div>

                                                    <p>Please upload an updated e-signature file. We recommend using a PNG format with a transparent background or a JPG format with a white background for the best quality.</p>

                                                    <form wire:submit.prevent="saveSignatureUpdate">
                                                        <div class="form-group">
                                                            <label for="signature_path_up" class="mb-3">Upload an updated electronic signature:</label>

                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="signature_path_up" wire:model="signature_path_up">
                                                                    <label class="custom-file-label" for="signature_path_up">Choose file</label>
                                                                </div>

                                                                <div class="input-group-append">
                                                                    <button class="input-group-text" type="submit">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                
                                                    @if ($signature_path_up)
                                                        <div class="text-warning mb-3"><i class="fas fa-eye mr-1"></i><b>Updated e-Signature Preview:</b></div>
                                                        <img src="{{ $signature_path_up->temporaryUrl() }}" width="500" alt="Updated e-Signature Preview">
                                                    @else
                                                        <div class="text-warning mb-3"><i class="fas fa-eye mr-1"></i><b>Current e-Signature Preview:</b></div>
                                                        <img src="storage/{{ $signature->signature_path }}" width="500" alt="Previous e-Signature Preview">
                                                    @endif
                                                @endif
                                            @empty
                                                <div class="text-danger mb-3"><i class="fas fa-times-circle mr-1"></i><b>No e-Signature uploaded!</b></div>

                                                <p>Please upload an e-signature file. We recommend using a PNG format with a transparent background or a JPG format with a white background for the best quality.</p>

                                                <form wire:submit.prevent="saveSignature">
                                                    <div class="form-group">
                                                        <label for="signature_path_new" class="mb-3">Upload an electronic signature:</label>

                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="signature_path_new" wire:model="signature_path_new">
                                                                <label class="custom-file-label" for="signature_path_new">Choose file</label>
                                                            </div>

                                                            <div class="input-group-append">
                                                                <button class="input-group-text" type="submit">Upload</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            
                                                @if ($signature_path_new)
                                                    <div class="text-warning mb-3"><i class="fas fa-eye mr-1"></i><b>Preview:</b></div>
                                                    <img src="{{ $signature_path_new->temporaryUrl() }}" width="500" alt="Preview">
                                                @endif
                                            @endforelse
                                        </div>
                                        
                                        <div class="col-3"></div>
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
        $('#nav-custom').addClass('active');
        $('#nav-custom-parent').addClass('menu-open');
        $('#nav-custom-signature').addClass('active');
    </script>
@endscript