@extends('layouts.a_template')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title text-center">Profile</h3>
    </div>
    <div class="card-body">
        {{-- Success and Error messages --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif


        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-user mr-2 text-primary"></i>
                    <div>
                        <span class="text-muted">Username</span>
                        <h5>{{ $user->username }}</h5>
                    </div>
                </div>
                <hr>
                <hr>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-layer-group mr-2 text-warning"></i>
                    <div>
                        <span class="text-muted">Level</span>
                        <h5>{{ $user->nama }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-layer-group mr-2 text-warning"></i>
                    <div>
                        <span class="text-muted">Level</span>
                        <h5>{{ $user->level->level_nama }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-layer-group mr-2 text-warning"></i>
                    <div>
                        <span class="text-muted">NIM</span>
                        <h5>{{ $user->nip }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-layer-group mr-2 text-warning"></i>
                    <div>
                        <span class="text-muted">Email</span>
                        <h5>{{ $user->email }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-layer-group mr-2 text-warning"></i>
                    <div>
                        <span class="text-muted">No Telepon</span>
                        <h5>{{ $user->no_telepon }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Button placed at the bottom --}}
        <div class="text-center mt-4">
            <button onclick="modalAction('{{ url('/aProfile/edit_ajax') }}')" class="btn btn-warning btn-lg px-4 py-2 shadow">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>
    </div>
</div>

{{-- Modal for AJAX actions --}}
<div id="modalAction" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalActionTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- Content will be loaded via AJAX --}}
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#modalAction').load(url, function() {
            $('#modalAction').modal('show');
        });
    }

    function submitForm() {
        const form = document.getElementById('formAction');
        const formData = new FormData(form);

        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    $('#modalAction').modal('hide');
                    location.reload();
                } else {
                    let errorMessages = '';
                    for (const field in response.msgField) {
                        errorMessages += response.msgField[field].join('\n') + '\n';
                    }
                    alert(errorMessages);
                }
            }
        });
    }
</script>
@endpush