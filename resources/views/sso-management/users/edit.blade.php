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
            height: 37px;
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

        #preview-box {
            border: 2px solid #d0d0e0;
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100px;
            cursor: pointer;
            text-align: center;
        }

        #preview-box img {
            height: 100%;
            width: 100%;
            display: none;
        }

        #preview-box span {
            color: #aaa;
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

        #tableModule tbody td:nth-child(1) {
            text-align: center;
        }

        #tableModule tbody td:nth-child(3) {
            text-align: center;
        }

        .form-group {
            height: 80px;
        }
    </style>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card shadow-none">
                <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data" id="formUser">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="text-dark text-lg">
                                <a href="{{ url('/sso-management-users/detail/' . $user->id) }}">
                                    <img src="{{ url('img/logo/arrow_back.png') }}" alt="" height="15" width="15"class="mr-2 mb-1">
                                </a>
                               Update User Details
                            </label>
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div class="row gt-3">
                        <div class="col-md-4">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="username" style="font-weight: 400 !important;">Username<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                                    <input type="hidden" name="username_old" value="{{ $user->username }}">
                                    <span role="alert" id="usernameError" class="mb-2" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="nik" style="font-weight: 400 !important;">NIK<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ $user->personal->nik }}">
                                    <input type="hidden" class="form-control" id="nik_old" name="nik_old" value="{{ $user->personal->nik }}">
                                    <span id="nikError" role="alert" class="mb-2" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="fullname" style="font-weight: 400 !important;">Full Name<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $user->personal->fullname }}">
                                    <input type="hidden" name="id_personal" value="{{ $user->personal->id }}">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <span id="fullnameError" role="alert" class="mb-2" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="email" style="font-weight: 400 !important;">Email<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                    <input type="hidden" class="form-control" id="email_old" name="email_old" value="{{ $user->email }}">
                                    <span id="emailError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="phone" style="font-weight: 400 !important;">
                                        Phone Number<font color="red">*</font>
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ $user->personal->phone }}">
                                    <input type="hidden" name="phone_old" value="{{ $user->personal->phone }}">
                                    <span id="phoneError" role="alert" class="mb-2" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="whatsapp" style="font-weight: 400 !important;">Whatsapp Number<font color="red">*</font></label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ $user->personal->wa_number }}">
                                    <input type="hidden" name="whatsapp_old" value="{{ $user->personal->wa_number }}">
                                    <span id="whatsappError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="address" style="font-weight: 400 !important;">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->personal->address }}">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="entity" style="font-weight: 400 !important;">Entity<font color="red">*</font></label>
                                    <select name="entity" id="entity" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Entity --</option>
                                        @foreach ($data['entity'] as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $user->personal->auth_entity_id ? 'selected' : '' }}>{{ $item->entity }}</option>
                                        @endforeach
                                    </select>
                                    <span id="entityError" role="alert" class="mb-2" style="color: red;font-size:12px;">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="type" style="font-weight: 400 !important;">Type<font color="red">*</font></label>
                                    <select name="type" id="type" class="form-control select2" style="width: 100%;">
                                        <option value="" selected>-- Select Type --</option>
                                        @foreach ($data['type'] as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $user->personal->auth_type_id ? 'selected' : '' }}>{{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                    <span id="typeError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="division" style="font-weight: 400 !important;">Division<font color="red">*</font></label>
                                    <select name="division" id="division" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Select Division --</option>
                                        @foreach ($data['division'] as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $user->personal->auth_mst_division_id ? 'selected' : '' }}>{{ $item->division }}</option>
                                        @endforeach
                                    </select>
                                    <span id="divisionError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="department" style="font-weight: 400 !important;">
                                        Department<font color="red">*</font>
                                    </label>
                                    <select name="department" id="department" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Select Department --</option>
                                        @foreach ($data['department'] as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $user->personal->auth_mst_department_id ? 'selected' : '' }}>{{ $item->department }}</option>
                                        @endforeach
                                    </select>
                                    <span id="departmentError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="position" style="font-weight: 400 !important;">Position<font color="red">*</font></label>
                                    <select name="position" id="position" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Select Position --</option>
                                        @foreach ($data['position'] as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $user->personal->auth_mst_position_id ? 'selected' : '' }}>{{ $item->position }}</option>
                                        @endforeach
                                    </select>
                                    <span id="positionError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="status" style="font-weight: 400 !important;">Status<font><span style="color: red;">*</span></font></label>
                                    <div class="row">
                                        <div class="ml-2 mr-4">
                                            <input type="radio" value="active" id="status_active" name="status" {{ $user->is_active ? 'checked' : '' }}>
                                            <label for="status_active" style="font-weight: 400 !important;"> Active</label>
                                        </div>
                                        <div>
                                            <input type="radio" value="not_active" id="status_not_active" name="status" {{ !$user->is_active ? 'checked' : '' }}>
                                            <label for="status_not_active" style="font-weight: 400 !important;"> Not Active</label>
                                        </div>
                                    </div>
                                    <span id="statusError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11" id="validityPeriod" style="{{ $user->is_active ? 'display:inline-block' : 'display:none' }}">
                                <div class="form-group">
                                    <label for="validity" style="font-weight: 400 !important;">Validity Period<span style="color: red;">*</span></label>
                                    <div class="row">
                                        <div class="ml-2 mr-4">
                                            <input type="radio" value="Permanent" id="permanen" name="validity" {{ $user->personal->validity_period == 'Permanent' ? 'checked' : '' }}>
                                            <label for="permanen" style="font-weight: 400 !important;"> Permanen</label>
                                        </div>
                                        <div>
                                            <input type="radio" value="Limited Period" id="limited" name="validity" {{ $user->personal->validity_period == 'Limited Period' ? 'checked' : '' }}>
                                            <label for="limited" style="font-weight: 400 !important;"> Limited Period</label>
                                        </div>
                                    </div>
                                    <span id="validityError" role="alert" class="mb-2" style="color: red;font-size:12px;">

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11" id="validTillInput" style="{{ $user->personal->validity_period != 'Permanent' ? 'display:inline-block' : 'display:none' }}">
                                <div class="form-group">
                                    <label for="valid_till" style="font-weight: 400 !important;">
                                        Valid Till<font color="red">*</font>
                                    </label>
                                    <div class="input-group date" id="validTillGroup" data-target-input="nearest">
                                        <input type="text" id="validTill" name="validTill" class="form-control datetimepicker-input" data-target="#validTill" value="{{($user->personal->valid_till) ?\Carbon\Carbon::parse($user->personal->valid_till)->format('d-M-Y'):''}}"/>
                                        <div class="input-group-append" data-target="#validTill"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="validTillError" role="alert" class="mb-2" style="color: red;font-size:12px;"></span>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="width: 100%;" id="hrx">
            </form>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end" style="padding: 20px !important;padding-top:0px !important;">
                        <div>
                            <a href="{{ route('users.index') }}" type="button" class="btn btn-secondary mr-2" id="cancelBtn" style="background-color: white; color:#464F60;border: 1px solid #464F60;">
                                CANCEL
                            </a>
                            <button type="button" class="btn btn-primary" id="createBtn" style="background-color: #2E308A; color: white;" onclick="submitForm()">
                                SAVE CHANGES
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
                    User will be updated, make sure all data are correct. Are you sure to continue?
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

    function submitForm() {
        $('#submitConfirmation').modal({
            backdrop: 'static',
            keyboard: false
        });
    };

    function submit()
    {
        let isValid = true;
        let fields = ['username', 'nik', 'entity', 'fullname', 'type', 'status', 'email', 'division', 'phone', 'department', 'whatsapp', 'position'];

        $('span[role="alert"]').text('');

        fields.forEach(function(field) {
            if ($('#' + field).val() == '') {
                $('#' + field + 'Error').text(` ${field} is required.`);
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }
        });

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
                url: "{{ route('users.update') }}",
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
        $('#createBtn').css('display', 'inline-block');
        $('#spinner').css('display', 'none');
        $('#resetBtn').css('display', 'none');
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
