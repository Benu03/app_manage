@extends('layouts.main')
@section('content')
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

    #tableModule thead{
        background-color: #F2F2F2;
        color: #2E308A !important;
        border-radius-top-left-radius: 10px !important;
        border-radius-top-right-radius: 10px !important;
    }

    #tableModule thead th{
        font-weight: 600 !important;
    }

    #tableModule thead th:nth-child(1), th:nth-child(2) {
        border-right: 0px;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-dark text-lg">
                            <a href="{{ route('web-management.index') }}">
                                <img src="{{ url('img/logo/arrow_back.png') }}" alt="" height="15"
                                    width="15" class="mr-2 mb-1">
                            </a>
                            Edit Web App
                        </label>
                    </div>
                </div>
                <hr style="width: 103%;margin-left:-21px;" id="hrx">
                @if(session()->has('errors'))
                    @foreach(session('errors') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @endif
                <form action="{{ route('web-management.update') }}" method="POST" enctype="multipart/form-data" id="formWeb">
                    @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="app" style="font-weight: 400 !important;">
                                        App Name<font><span style="color: red;">*</span></font>
                                    </label>
                                    <input type="text" class="form-control" id="app" name="app" value="{{ $data['portal']->app }}" style="text-transform: uppercase;">
                                    <input type="hidden" name="app_old" value="{{ $data['portal']->app }}">
                                    <input type="hidden" name="id" value="{{ $data['portal']->id }}">
                                    <div id="app_error" class="text-danger">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="margin-left: 50px !important;">
                                    <label for="status" style="font-weight: 400 !important;">Status<font><span
                                                style="color: red;">*</span></font></label>
                                    <div class="row">
                                        <div class="mr-4">
                                            <input type="radio" value="active"
                                                id="status_active" name="status"
                                                {{ $data['portal']->is_active ? 'checked' : '' }}>
                                            <label for="status_active" style="font-weight: 400 !important;">
                                                Active</label>
                                        </div>
                                        <div>
                                            <input type="radio" value="not_active"
                                                id="status_not_active"
                                                {{ !$data['portal']->is_active ? 'checked' : '' }} name="status">
                                            <label for="status_not_active" style="font-weight: 400 !important;"> Not
                                                Active</label>
                                        </div>
                                    </div>
                                    <div id="status_error" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" style="font-weight: 400 !important;">Description<font><span
                                                style="color: red;">*</span></font></label>
                                    <textarea name="description" id="description" class="form-control" rows="3">{{ $data['portal']->description }}</textarea>
                                    <div id="description_error" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dev_url" style="font-weight: 400 !important;">Dev URL</label>
                                    <input type="text" class="form-control" id="dev_url" name="dev_url"
                                        placeholder="https://" value="{{ $data['portal']->dev_url }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="prod_url" style="font-weight: 400 !important;">Prod URL</label>
                                    <input type="text" class="form-control" id="prod_url"
                                        name="prod_url" placeholder="https://"
                                        value="{{ $data['portal']->prod_url }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="logo" style="font-weight: 400 !important;">Logo</label>
                                    <input class="form-control" type="file" id="logo" name="logo" accept=".png,.jpeg,.jpg">
                                    <input type="file" id="croppedLogo" name="croppedLogo" style="display: none;">
                                    <input type="hidden" id="image_url" value="{{ $data['portal']->image_url }}">
                                    <small id="logoHelp" class="form-text text-muted">
                                        <i>Maximum file size 2MB (.png/.jpeg)</i>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="preview-box" data-toggle="modal" data-target="#cropModal">
                                    @if (file_exists(public_path('img/portal-app' .$data['portal']->image_url)) && $data['portal']->image_url)
                                        <img id="preview-image" src="{{ asset('img/portal-app'.$data['portal']->image_url) }}"
                                            alt="Logo Preview">
                                        <span id="no-logo-text" style="display:none;">No Logo</span>
                                    @else
                                        <img id="preview-image" src="#" alt="Logo Preview" style="display:none;">
                                        <span id="no-logo-text">No Logo</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header" style="color: #2E308A !important;font-weight: 600 !important;">
                                Mapping Module
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="module" style="font-weight: 400 !important;">Module</label>
                                            <select name="module" class="form-control select2" id="module">
                                                <option value="">-- Select Module --</option>
                                                @foreach ($data['listModule'] as $item)
                                                    <option value="{{ $item->id }}" data-module="{{ $item->module }}">{{ $item->module }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="selectedModulesInput" name="selectedModules">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-primary2 add_data clickable" style="margin-top: 30px !important;">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tableModule" class="table table-sm table-bordered w-100">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5%;text-align: center;">No</th>
                                                    <th style="width: 90%;text-align: left;">Module</th>
                                                    <th style="width: 5%;text-align: center !important;">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['portalModule'] as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input type="hidden" name="module_ids[]" value="{{ $item->id }}">
                                                        {{ $item->module }}
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="remove_data">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <hr style="width: 100%;" id="hrx">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end"
                    style="padding: 20px !important;padding-top:0px !important;">
                    <a href="{{ route('web-management.index') }}" class="btn btn-secondary mr-2"
                        style="background-color: white; color:#464F60;border: 1px solid #464F60;">CANCEL</a>
                    <button type="button" class="btn btn-primary" id="updateBtn" style="background-color: #2E308A; color: white;">
                        SAVE CHANGES
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel" style="font-size:18px !important; font-weight:600 !important;">
                    Preview Logo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:38px !important;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container" id="crop-container">
                    <img id="image-to-crop" src="#" alt="Picture" style="height: 50% !important;width: 50% !important;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: white; color:#464F60;border: 1px solid #464F60;">CANCEL</button>
                <button type="button" class="btn btn-primary" id="crop-button" style="background-color: #2E308A; color: white;">UPLOAD</button>
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
                <div style="font-size: 14px;font-weight: 400;">
                    App will be updated, make sure all data are correct. Are you sure to continue?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn"
                    style="background-color: #FFFFFF !important;color:#464F60 !important; border: 1px solid #464F60;"
                    data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn" onclick="submit()"
                    style="background-color: #2E308A;color: white;">
                    YES
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/update-web.js') }}" defer></script>
<script>
     const submit = () => {
        let isValid = true;

        if ($('#app').val() == '') {
            isValid = false;
            $('#app_error').html('App name is required');
            $('#app').focus();
            $('#submitConfirmation').modal('hide');
        } else {
            $('#app_error').html('');
        }

        if (!$('input[name="status"]:checked').val()) {
            isValid = false;
            $('#status_error').html('Status is required');
            $('#submitConfirmation').modal('hide');
        } else {
            $('#status_error').html('');
        }

        if ($('#description').val() == '') {
            isValid = false;
            $('#description_error').html('Description is required');
            $('#description').focus();
            $('#submitConfirmation').modal('hide');
        } else {
            $('#description_error').html('');
        }

        if (isValid) {
            let formData = new FormData(document.getElementById('formWeb'));
            $.blockUI();
            $.ajax({
                type: "POST",
                url: "{{ route('web-management.update') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    } else {
                        if (response.code == 409) {
                            $('#app_error').html(response.message);
                            $('#app').focus();
                        } else if (response.code == 422) {
                            toastr.error(response.message);
                        }
                    }
                    $('#submitConfirmation').modal('hide');
                    $.unblockUI();
                },
            });
        }

    }
</script>
@endsection
