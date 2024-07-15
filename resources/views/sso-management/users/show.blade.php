@extends('layouts.main')

@section('content')
    <div>
        <style>

            .custom-btn {
                min-width: 50px !important;
                border: 1px solid #2E308A !important;
                border-radius: 4px;
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 600;
                font-size: 16px;
                line-height: 14px;
                height: 36px;
                width: 140px;
            }

            .btn-primary2 {
                background-color: #0D66FA !important;
                color: white;
            }

            div.dataTables_wrapper div.dataTables_filter input {
                margin-left: .5em;
                display: inline-block;
                width: 130px;
            }

            .remove_data {
                color: red;
                cursor: pointer;
            }

            .activex {
                font-weight: 700;
                color:#212529 !important;
            }

            .dataTables_wrapper .dataTable thead th {
                background-color: #F2F2F2;
                color: #2E308A;
            }

            .dataTables_wrapper .dataTable thead th:first-child{
                border-left: 1px solid #ddd;
            }

            .dataTables_wrapper .dataTable thead th:last-child {
                border-right: 1px solid #ddd;
            }

            .dataTables_wrapper .dataTable tbody td:first-child {
                border-left: 1px solid #ddd;
            }

            .dataTables_wrapper .dataTable tbody td:last-child {
                border-right: 1px solid #ddd;
            }

            .select2-container .select2-selection--single {
                box-sizing: border-box;
                cursor: pointer;
                display: block;
                height: 38px;
                user-select: none;
                -webkit-user-select: none;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 5px;
                right: 1px;
                width: 20px;
            }
        </style>
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-dark text-lg">
                                    <a href="{{ route('users.index') }}">
                                        <img src="{{ url('img/logo/arrow_back.png') }}" alt="" height="15"
                                            width="15" class="mr-2 mb-1">
                                    </a>
                                    User Details
                                </label>
                            </div>
                        </div>
                        <hr style="width: 103%;margin-left:-21px;" id="hrx">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-home-tab"
                                                    data-toggle="pill" href="#custom-tabs-three-home" role="tab"
                                                    aria-controls="custom-tabs-three-home">
                                                    Profile
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-profile" role="tab"
                                                    aria-controls="custom-tabs-three-profile">Access
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                            <div class="tab-pane fade" id="custom-tabs-three-home"
                                                role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2" style="text-align: center;margin-left: -30px;margin-right: 30px;">
                                                            <div>
                                                                <img src="{{ asset('img/logo/user.png') }}" height="70"
                                                                    width="70" class="mb-4">
                                                                <a href="{{ url('/sso-management-users/edit/'.$user->id_users) }}" class="btn btn-primary"
                                                                    style="background-color: #2E308A; color: white;border-radius:6px;">
                                                                    UPDATE USER DETAILS
                                                                </a>
                                                                <button class="btn btn-primary mt-1"
                                                                    class="btn btn-secondary"
                                                                    style="background-color: white; color:#464F60;border: 1px solid #464F60;border-radius:6px;text-align: center;width:178px;" onclick="updatePassword()">
                                                                    CHANGE PASSWORD
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                Username
                                                            </div>
                                                            <div class="mb-3">
                                                                NIK
                                                            </div>
                                                            <div class="mb-3">
                                                                Full Name
                                                            </div>
                                                            <div class="mb-3">
                                                                Email
                                                            </div>
                                                            <div class="mb-3">
                                                                Phone Number
                                                            </div>
                                                            <div class="mb-3">
                                                                Whatsapp Number
                                                            </div>
                                                            <div class="mb-3">
                                                                Address
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                : {{ $user->username }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ strtoupper($user->nik) }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->fullname }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->email }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->phone }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->wa_number }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->address }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2" style="margin-left: 50px;">
                                                            <div class="mb-3">
                                                                Entity
                                                            </div>
                                                            <div class="mb-3">
                                                                Type
                                                            </div>
                                                            <div class="mb-3">
                                                                Division
                                                            </div>
                                                            <div class="mb-3">
                                                                Department
                                                            </div>
                                                            <div class="mb-3">
                                                                Position
                                                            </div>
                                                            <div class="mb-3">
                                                                Status
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="margin-left: -50px;">
                                                            <div class="mb-3">
                                                                : {{ $user->entity }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->type }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->division }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->department }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->position }}
                                                            </div>
                                                            <div class="mb-3">
                                                                : {{ $user->is_active ? 'Active' : 'Inactive' }} - {{ $user->validity_period }} {{ $user->validity_period == 'Limited Period' ? '(valid till '.Carbon\Carbon::parse($user->valid_till)->format('d-M-Y').')' : '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                                aria-labelledby="custom-tabs-three-profile-tab">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="text-dark text-lg" style="font-weight: 600;font-size:16px !important;">
                                                                    Mapping Access
                                                                </label>
                                                            </div>
                                                            <div class="col-md-9 text-md-right">
                                                                <a href="javascript:void(0)" class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1" onclick="addModule()">
                                                                    <p style="font-size: 14px;font-weight: 600;margin-top: 5px !important;">
                                                                        <img src="{{ asset('img/logo/add_circle.png') }}" alt="">
                                                                        Add Module
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-sm w-100" id="moduleTable">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" role="dialog" id="addModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size: 18px !important; font-weight: 600;">Add Module</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-dark text-lg" style="font-weight: 400;font-size:14px !important;">
                                    Username
                                </label>
                                <input type="text" class="form-control" name="username" id="username" readonly value="{{ $user->username }}">
                                <input type="hidden" name="id" id="id" value="{{ $user->id_users }}">
                            </div>
                            <div class="form-group">
                                <label for="module" class="text-dark text-lg" style="font-weight: 400;font-size:14px !important;">
                                    Module<font color="red">*</font>
                                </label>
                                <select name="module" id="module" class="form-control select2modal" style="width: 100%;" onchange="getRoles(this.value)">
                                    <option value="" selected>-- Select Module --</option>
                                    @foreach ($module as $item)
                                        <option value="{{ $item->id }}">{{ $item->module }}</option>
                                    @endforeach
                                </select>
                                <div id="validationModule" class="text-danger">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="text-dark text-lg" style="font-weight: 400;font-size:14px !important;">
                                    Role<font color="red">*</font>
                                </label>
                                <select name="role" id="role" class="form-control select2modal" style="width: 100%;">
                                    <option value="" selected>-- Select Role --</option>
                                </select>
                                <div id="validationRole" class="text-danger">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" style="background-color: #FFFFFF !important;color:#464F60 !important; border: 1px solid #464F60;" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn" id="submitBtn" style="background-color: #2E308A;color: white;">
                            ADD
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" role="dialog" id="updatePassword">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size: 18px !important; font-weight: 600;">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-dark text-lg" style="font-weight: 400;font-size:14px !important;">
                                    Username
                                </label>
                                <input type="text" class="form-control" name="username" id="username" readonly value="{{ $user->username }}">
                                <input type="hidden" name="id_user" id="id_user" value="{{ $user->id_users }}">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-dark text-lg" style="font-weight: 400;font-size:14px !important;">
                                    New Password<font color="red">*</font>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="password" name="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;" onclick="togglePassword('password', 'toggle-password')">
                                            <img id="eyeIcon" src="{{ asset('img/logo/eye-open.png') }}" alt="Show Password">
                                        </span>
                                    </div>
                                </div>
                                <div id="validationPassword" class="text-danger">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="text-dark text-lg" style="font-weight: 400;font-size:14px !important;">
                                    Confirm Password<font color="red">*</font>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="confirm_password" name="confirm_password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password-conf" style="cursor: pointer;" onclick="togglePassword('confirm_password', 'toggle-password-conf')">
                                            <img id="eyeIcon" src="{{ asset('img/logo/eye-open.png') }}" alt="Show Password">
                                        </span>
                                    </div>
                                </div>
                                <div id="validationConfPassword" class="text-danger">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" style="background-color: #FFFFFF !important;color:#464F60 !important; border: 1px solid #464F60;" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn" id="updatePasswordBtn" style="background-color: #2E308A;color: white;">
                            SAVE CHANGES
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                getData();

                // $('.select2modal').select2({
                //     dropdownParent: $("#addModal"),
                // })

                // Fungsi untuk menambahkan hash ke URL tanpa memuat ulang halaman
                function addHashToURL(hash) {
                    history.pushState(null, null, hash);
                }

                // Tambahkan event handler saat tab di klik
                $('#custom-tabs-three-tab .nav-link').click(function(e) {
                    e.preventDefault();

                    var hash = $(this).attr('href');
                    addHashToURL(hash);

                    // Hapus kelas 'active' dan 'activex' dari semua tab
                    $('#custom-tabs-three-tab .nav-link').removeClass('active activex');

                    // Tambahkan kelas 'active' dan 'activex' ke tab yang diklik
                    $(this).addClass('active activex');
                    $(this).attr('aria-selected', 'true');

                    // Atur atribut 'aria-selected' untuk semua tab ke 'false', kecuali tab yang dipilih
                    $('#custom-tabs-three-tab .nav-link').not(this).attr('aria-selected', 'false');

                    $('#custom-tabs-three-tabContent .tab-pane').removeClass('show active');

                    // Tampilkan tab-pane yang sesuai dengan tab yang dipilih
                    var targetPaneId = $(this).attr('aria-controls');
                    $('#' + targetPaneId).addClass('show active');
                });

                // Set default tab based on hash
                var hash = window.location.hash;
                if (hash === '#custom-tabs-three-home' || hash === '') {
                    $('#custom-tabs-three-home-tab').addClass('active activex').attr('aria-selected', 'true');
                    $('#custom-tabs-three-home').addClass('show active');
                } else if (hash === '#custom-tabs-three-profile') {
                    $('#custom-tabs-three-profile-tab').addClass('active activex').attr('aria-selected', 'true');
                    $('#custom-tabs-three-profile').addClass('show active');
                }
            });

            $('#addModal').on('shown.bs.modal', function () {
                $('.select2modal').select2({
                    dropdownParent: $("#addModal")
                });
            });

            function getData()
            {
                var table = $('#moduleTable').DataTable({
                    autoWidth: false,
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: true,
                    paging: true,
                    ordering: false,
                    language: {
                        processing: '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary"></i></div> <div class="text-center">Processing...</div>',
                    },
                        ajax: {
                        type: 'GET',
                        url: "{{ route('users.get_data') }}",
                        data : {
                            id : "{{ $user->id_users }}",
                        }
                    },
                    columns: [
                        {
                            title: 'No',
                            orderable: false,
                            data: null,
                            className: "text-center",
                            width: '5%',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                        },
                        {
                            title: 'Module',
                            data: 'module',
                            name: 'module',
                            className: "text-left text-truncate",
                            width: '50%',
                        },
                        {
                            title: 'Role',
                            data: 'role',
                            name: 'role',
                            className: "text-left text-truncate",
                            width: '35%',
                        },
                        {
                            title: 'Delete',
                            data: 'delete',
                            name: 'delete',
                            className: "text-center text-truncate",
                            width: '10%',
                        },
                    ],
                    drawCallback: function(settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                });
            }

            const addModule = () => {
                $.blockUI();
                $('#role').val('');
                $('#module').val('');
                $('#validationRole').html('');
                $('#validationModule').html('');
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $.unblockUI();
            }

            const updatePassword = () => {
                $.blockUI();
                $('#password').val('');
                $('#confirm_password').val('');
                $('#validationPassword').html('');
                $('#validationConfPassword').html('');
                $('#updatePassword').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $.unblockUI();
            }

            const deleteData = (id) => {
                Swal.fire({
                    title: "Delete Item",
                    text: "Are you sure you want to delete? This action cannot be undone.",
                    confirmButtonText: "Delete",
                    confirmButtonColor: '#D1293D',
                    showCancelButton: true,
                    reverseButtons: true,

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.blockUI();
                        $.ajax({
                            type: "POST",
                            url: "{{ route('users.delete.module') }}",
                            data: {
                                id : id,
                                _token : "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                getData();
                                $.unblockUI();
                                toastr.success(response.message);
                            },
                            error: function(xhr) {
                                $.unblockUI();
                                toastr.error(xhr.responseJSON.message);
                            }
                        });
                    }
                })
            }


            const getRoles = (id) => {
                $.ajax({
                    type: "GET",
                    url: "{{ route('users.get_roles') }}",
                    data: {
                        id : id,
                        user_id : "{{ $user->id_users }}",
                    },
                    success: function(response) {
                       $('#role').empty();
                       $('#role').append('<option value="" selected>-- Select Role --</option>');
                       response.data.forEach(element => {
                           $('#role').append(`<option value="${element.id}">${element.role}</option>`);
                       });
                    }
                });
            }


            $('#submitBtn').on('click', function(e) {
                e.preventDefault();
                $.blockUI();
                let id          = $('#id').val();
                let username    = $('#username').val();
                let role        = $('#role').val();
                let module      = $('#module').val();

                console.log(role);

                let isValid = true;

                if(module == '' || module == null){
                    $('#validationModule').html('*Module is required');
                    isValid = false;
                    $.unblockUI();
                    return false;
                }else{
                    $('#validationModule').html('');
                }

                if(role == '' || role == null){
                    $('#validationRole').html('*Role is required');
                    isValid = false;
                    $.unblockUI();
                    return false;
                }else{
                    $('#validationRole').html('');
                }

                if(isValid){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('users.update.module') }}",
                        data: {
                            id : id,
                            username : username,
                            role : role,
                            module : module,
                            _token : "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#addModal').modal('hide');
                            getData();
                            $.unblockUI();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            $.unblockUI();
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }

            });


            $('#updatePasswordBtn').on('click', function(e) {
                e.preventDefault();
                $.blockUI();
                let id          = $('#id_user').val();
                let password    = $('#password').val();
                let confPwd     = $('#confirm_password').val();

                let isValid = true;

                if(password == '' || password == null){
                    $('#validationPassword').html('*Password is required');
                    isValid = false;
                    $.unblockUI();
                    return false;
                }else{
                    isValid = true;
                    $('#validationPassword').html('');
                }

                if(confPwd == '' || confPwd == null){
                    $('#validationConfPassword').html('*Confirmation Password is required');
                    isValid = false;
                    $.unblockUI();
                    return false;
                }else{
                    isValid = true;
                    $('#validationConfPassword').html('');
                }

                if(confPwd && (confPwd != password)){
                    $('#validationConfPassword').html('*Confirmation Password does not match');
                    isValid = false;
                    $.unblockUI();
                    return false;
                }else{
                    isValid = true;
                    $('#validationConfPassword').html('');
                }

                if(isValid){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('users.update.password') }}",
                        data: {
                            id : id,
                            password : password,
                            _token : "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#updatePassword').modal('hide');
                            $.unblockUI();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            $('#updatePassword').modal('hide');
                            $.unblockUI();
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }

            });



            function togglePassword(input, nameClass) {
                var passwordInput       = document.getElementById(`${input}`);
                var eyeIcon             = document.getElementById("eyeIcon");
                const togglePasswordBtn = document.querySelector(`.${nameClass}`);
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'password') {
                    togglePasswordBtn.innerHTML = '<img src="{{ asset('img/logo/eye-close.png') }}">';
                } else {
                    togglePasswordBtn.innerHTML = '<img src="{{ asset('img/logo/eye-open.png') }}" style="margin-bottom:3px;">';
                }
            }

        </script>
    </div>
@endsection
@livewireScripts
