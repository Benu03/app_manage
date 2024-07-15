@extends('layouts.main')
@section('content')
<div>
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
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
            top: 4px;
            right: 1px;
            width: 20px;
        }

        .btn-primary2 {
            background-color: #0D66FA !important;
            color: white;
        }

        .form-group {
            height: 80px;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: 0;
        }
        .input-group-append .input-group-text {
            background: transparent;
            border: 1px solid #ced4da;
            border-left: 0;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .input-group .form-control:focus {
            z-index: 3;
        }
        .toggle-password i {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eye-icon-button {
            outline: none;
        }

        .eye-icon-button:focus,
        .eye-icon-button:hover {
            background-color: transparent;
            border: none;
        }
    </style>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card shadow-none">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="formUser">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="text-dark text-lg">
                                <a href="{{ route('users.index') }}">
                                    <img src="{{ url('img/logo/arrow_back.png') }}" alt="" height="15" width="15"
                                        class="mr-2 mb-1">
                                </a>
                                Add New User
                            </label>
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-11">
                                    <label for="username" style="font-weight: 400 !important;">Username<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="username" name="username">
                                    <span role="alert" id="usernameError" class="error-message"  style="color: red;font-size:12px;">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="nik" style="font-weight: 400 !important;">NIK<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="nik" name="nik">
                                    <span id="nikError" role="alert" class="error-message" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="fullname" style="font-weight: 400 !important;">Full Name<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="fullname" name="fullname">
                                    <span id="fullnameError" role="alert" class="error-message" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="email" style="font-weight: 400 !important;">Email<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="email" name="email">
                                    <span id="emailError" role="alert" style="color: red;font-size:12px;"></span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="phone" style="font-weight: 400 !important;">
                                        Phone Number<font color="red">*</font>
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    <span id="phoneError" role="alert" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="whatsapp" style="font-weight: 400 !important;">Whatsapp Number<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    <span id="whatsappError" role="alert" style="color: red;font-size:12px;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="address" style="font-weight: 400 !important;">Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="entity" style="font-weight: 400 !important;">Entity<font color="red">*</font></label>
                                    <select name="entity" id="entity" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Entity --</option>
                                        @foreach ($data['entity'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->entity }}</option>
                                        @endforeach
                                    </select>
                                    <span id="entityError" role="alert" style="color: red;font-size:12px;">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="type" style="font-weight: 400 !important;">Type<font color="red">*</font></label>
                                    <select name="type" id="type" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Type --</option>
                                        @foreach ($data['type'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                    <span id="typeError" role="alert" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="division" style="font-weight: 400 !important;">Division<font color="red">*</font></label>
                                    <select name="division" id="division" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Division --</option>
                                        @foreach ($data['division'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->division }}</option>
                                        @endforeach
                                    </select>
                                    <span id="divisionError" role="alert"   style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="department" style="font-weight: 400 !important;">
                                        Department<font color="red">*</font>
                                    </label>
                                    <select name="department" id="department" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Department --</option>
                                        @foreach ($data['department'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->department }}</option>
                                        @endforeach
                                    </select>
                                    <span id="departmentError" role="alert"   style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="position" style="font-weight: 400 !important;">Position<font color="red">*</font></label>
                                    <select name="position" id="position" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Position --</option>
                                        @foreach ($data['position'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->position }}</option>
                                        @endforeach
                                    </select>
                                    <span id="positionError" role="alert" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="password" style="font-weight: 400 !important;">Password<font color="red">*</font></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="password" name="password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" onclick="togglePassword('password', 'toggle-password')">
                                                <i class="nav-icon material-symbols-rounded eye-icon-button" style="font-size: 19px!important;color:#2E308A">
                                                    visibility
                                                </i>
                                            </span>
                                        </div>
                                    </div>
                                    <span id="passwordError" role="alert" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="confirm_password" style="font-weight: 400 !important;">Confirm Password<font color="red">*</font></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="confirm_password" name="confirm_password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password-conf" onclick="togglePassword('confirm_password', 'toggle-password-conf')">
                                                <i class="nav-icon material-symbols-rounded eye-icon-button" style="font-size: 19px!important;color:#2E308A;">
                                                    visibility
                                                </i>
                                            </span>
                                        </div>
                                    </div>
                                    <span id="confirm_passwordError" role="alert"   style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="status" style="font-weight: 400 !important;">Status<font><span style="color: red;">*</span></font></label>
                                    <div class="row">
                                        <div class="ml-2 mr-4">
                                            <input type="radio" value="active" id="status_active" name="status" checked>
                                            <label for="status_active" style="font-weight: 400 !important;"> Active</label>
                                        </div>
                                        <div>
                                            <input type="radio" value="not_active" id="status_not_active" name="status">
                                            <label for="status_not_active" style="font-weight: 400 !important;"> Not Active</label>
                                        </div>
                                    </div>
                                    <span id="statusError" role="alert"   style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group" id="validityPeriod">
                                    <label for="validity" style="font-weight: 400 !important;">Validity Period<font><span style="color: red;">*</span></font></label>
                                    <div class="row">
                                        <div class="ml-2 mr-4">
                                            <input type="radio" value="Permanent" id="permanen" name="validity" checked>
                                            <label for="permanen" style="font-weight: 400 !important;"> Permanen</label>
                                        </div>
                                        <div>
                                            <input type="radio" value="Limited Period" id="limited" name="validity">
                                            <label for="limited" style="font-weight: 400 !important;"> Limited Period</label>
                                        </div>
                                    </div>
                                    <span id="validityError" role="alert"   style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group" id="validTillInput" style="display: none;">
                                    <label for="valid_till" style="font-weight: 400 !important;">
                                        Valid Till<font color="red">*</font>
                                    </label>
                                    <div class="input-group date" id="validTillGroup" data-target-input="nearest">
                                        <input type="text" id="validTill" name="validTill" class="form-control datetimepicker-input" data-target="#validTill"/>
                                        <div class="input-group-append" data-target="#validTill"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="validTillError" role="alert"  style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="width: 100%;" id="hrx">
            </form>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between" style="padding: 20px !important;padding-top:0px !important;">
                        <a onclick="resetForm()" type="button" class="btn btn-secondary" id="resetBtn" style="background-color: white; color:#464F60;border: 1px solid #464F60;">
                            <img src="{{ asset('img/logo/restart_alt.png') }}"> RESET
                        </a>
                        <div>
                            <a href="{{ route('users.index') }}" type="button" class="btn btn-secondary mr-2" id="cancelBtn" style="background-color: white; color:#464F60;border: 1px solid #464F60;">
                                CANCEL
                            </a>
                            <button type="button" class="btn btn-primary" id="createBtn" style="background-color: #2E308A; color: white;" onclick="submitForm()">
                                ADD
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="submitConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: 600;font-size:18px !important;">
                    Submit Confirmation
                </h5>
            </div>
            <div class="modal-body" style="margin-top: 0;margin-bottom: 0;">
                <div style="font-size: 14px;font-weight: 400;" id="msgTitle">
                    User will be created, make sure all data are correct. Are you sure to continue?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: #FFFFFF !important;color:#464F60 !important; border: 1px solid #464F60;" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn" onclick="submit()" style="background-color: #2E308A;color: white;">
                    YES
                </button>
            </div>
        </div>
    </div>
</div>

@push('js-custom')
<script>

    $(document).ready(function() {
        $('span[role="alert"]').text('');
    });

    function togglePassword(input, nameClass) {
        var passwordInput       = document.getElementById(`${input}`);
        var eyeIcon             = document.getElementById("eyeIcon");
        const togglePasswordBtn = document.querySelector(`.${nameClass}`);
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        if (type === 'password') {
            togglePasswordBtn.innerHTML = '<i class="nav-icon material-symbols-rounded" style="font-size: 19px!important;color:#2E308A">visibility_off</i>';
        } else {
            togglePasswordBtn.innerHTML = '<i class="nav-icon material-symbols-rounded" style="font-size: 19px!important;color:#2E308A">visibility</i>';
        }
    }

    function submitForm() {
        $('#submitConfirmation').modal({
            backdrop: 'static',
            keyboard: false
        });
    };

    function submit()
    {
        let isValid = true;
        let fields = ['username', 'password', 'confirm_password', 'nik', 'entity', 'fullname', 'type', 'status', 'email', 'division', 'phone', 'department', 'whatsapp', 'position'];

        $('span[role="alert"]').text('');

        fields.forEach(function(field) {
            if ($('#' + field).val() == '') {
                $('#' + field + 'Error').text(` ${field} is required.`);
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }
        });

        if ($('#password').val() !== $('#confirm_password').val()) {
            $('#confirm_passwordError').text('Passwords do not match.');
            $('#submitConfirmation').modal('hide');
            isValid = false;
        }

        if ($('input[name="validity"]:checked').val() === 'Limited Period' && $('#validTill').val().trim() === '') {
            $('#validTillError').text('This field is required.');
            $('#submitConfirmation').modal('hide');
            isValid = false;
        }

        if(isValid){
            let formData = new FormData(document.getElementById('formUser'));
            $.blockUI();
            $.ajax({
                type: "POST",
                url: "{{ route('users.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $('#submitConfirmation').modal('hide');
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    } else {
                        $('#submitConfirmation').modal('hide');
                        if (response.code == 409 && response.errors) {
                            response.errors.forEach(function(error) {
                                $(`#${error.tags}`).text(error.message);
                                $(`#${error.target}`).focus();
                            });
                        } else if (response.code == 422) {
                            toastr.error(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    }
                    $.unblockUI();
                }
            });
        }
    }

    function resetForm()
    {
        $('#formUser').trigger("reset");
        $('#entity').val('').change();
        $('#type').val('').change();
        $('#division').val('').change();
        $('#department').val('').change();
        $('#position').val('').change();
        $('#createBtn').css('display', 'inline-block');
        $('#spinner').css('display', 'none');
        $('#cancelBtn').css('display', 'inline-block');
    }

    $('#limited').click(function () {
        $('#validTillInput').show();
    });

    $('#permanen').click(function () {
        $('#validTillInput').hide();
    });

    $('#status_active').click(function () {
        $('#validityPeriod').show();
        if($('input[name="validity"]:checked').val() == 'Limited Period'){
            $('#validTillInput').show();
        }
    });

    $('#status_not_active').click(function () {
        $('#validityPeriod').hide();
        $('#validTillInput').hide();
    });

    $(function(){
        $('#validTill').datetimepicker({
            format: 'DD-MMM-yyyy',
            autoclose: true,
        });

    })
</script>
@endpush

@endsection
