@extends('layouts.t_template')

@section('content')
<div class="card shadow-lg">
    <div class="card-header text-center">
        <h1><strong>Profile</strong></h1>
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

        {{-- Profile Avatar --}}
        <div class="text-center mb-4">
            <div class="rounded-circle bg-light" style="width: 150px; height: 150px; margin: 0 auto; position: relative;">
                <img src="{{ $user->profile_picture ?? 'https://via.placeholder.com/150' }}"
                    class="rounded-circle"
                    style="width: 100%; height: 100%; object-fit: cover;"
                    alt="Profile Picture">
                <button class="btn btn-sm btn-primary position-absolute" style="bottom: 10px; right: 10px;">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
        </div>

        {{-- User Information --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-user mr-2 text-primary"></i>
                    <div>
                        <span class="text-muted">Username</span>
                        <h5>{{ $user->username }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-id-badge mr-2 text-secondary"></i>
                    <div>
                        <span class="text-muted">Name</span>
                        <h5>{{ $user->nama }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-id-badge mr-2 text-secondary"></i>
                    <div>
                        <span class="text-muted">NIP</span>
                        <h5>{{ $user->nip }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-envelope mr-2 text-warning"></i>
                    <div>
                        <span class="text-muted">Email</span>
                        <h5>{{ $user->email }}</h5>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <i class="fas fa-phone mr-2 text-success"></i>
                    <div>
                        <span class="text-muted">Phone Number</span>
                        <h5>{{ $user->no_telepon }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="text-center mt-4">
            <button onclick="modalAction('{{ url('/tProfile/edit_ajax') }}')"
                class="btn btn-warning btn-lg px-4 py-2 shadow">
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