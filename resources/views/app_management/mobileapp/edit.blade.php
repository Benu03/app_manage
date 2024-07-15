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

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: .5em;
        display: inline-block;
        width: 120px;
    }

    .remove_data {
        color: red;
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

    #tableModule tbody td:nth-child(1),
    #tableModule tbody td:nth-child(3) {
        text-align: center;
    }

    #tblApp thead {
        background-color: #F2F2F2;
        color: #2E308A !important;
    }

    #tblApp thead th:nth-child(1),th:nth-child(2),th:nth-child(3),th:nth-child(4),th:nth-child(5) {
        border-right: 0px !important;
    }

    #tblApp thead th{
        font-weight: 600 !important;
    }

    #tblApp tbody td:nth-child(1),
    #tblApp tbody td:nth-child(3),
    #tblApp tbody td:nth-child(5),
    #tblApp tbody td:nth-child(6) {
        text-align: center;
    }

    #tblAndroid thead {
        background-color: #F2F2F2;
        color: #2E308A !important;
    }

    #tblAndroid thead th:nth-child(1),th:nth-child(2),th:nth-child(3),th:nth-child(4) {
        border-right: 0px !important;
    }

    #tblAndroid thead th{
        font-weight: 600 !important;
    }

    #tblAndroid tbody td:nth-child(1),
    #tblAndroid tbody td:nth-child(2),
    #tblAndroid tbody td:nth-child(4),
    #tblAndroid tbody td:nth-child(5){
        text-align: center;
    }

    #tblIOS thead {
        background-color: #F2F2F2;
        color: #2E308A !important;
    }

    #tblIOS thead th:nth-child(1),th:nth-child(2),th:nth-child(3),th:nth-child(4) {
        border-right: 0px !important;
    }

    #tblIOS thead th{
        font-weight: 600 !important;
    }

    #tblIOS tbody td:nth-child(1),
    #tblIOS tbody td:nth-child(2),
    #tblIOS tbody td:nth-child(4),
    #tblIOS tbody td:nth-child(5){
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-dark text-lg">
                            <a href="{{ route('mobile-management.index') }}">
                                <img src="{{ url('img/logo/arrow_back.png') }}" alt="" height="15" width="15"
                                    class="mr-2 mb-1">
                            </a>
                            Edit Mobile App
                        </label>
                    </div>
                </div>
                <hr style="width: 103%;margin-left:-21px;" id="hrx">
                <form action="{{ route('mobile-management.update') }}" method="POST" enctype="multipart/form-data" id="formApp">
                    @csrf
                <input type="hidden" name="tableDataDev" id="tableDataDev">
                <input type="hidden" name="tableDataProdAndro" id="tableDataProdAndro">
                <input type="hidden" name="tableDataProdIOS" id="tableDataProdIOS">
                <input type="hidden" name="id" value="{{ $data['mobile']->id }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="app" style="font-weight: 400 !important;">
                                        App Name<font><span style="color: red;">*</span></font>
                                    </label>
                                    <input type="text" class="form-control" id="app" name="app" style="text-transform: uppercase;" value="{{ $data['mobile']->app }}">
                                    <input type="hidden" name="app_old" value="{{ $data['mobile']->app }}">
                                    <input type="hidden" id="image_url" value="{{ $data['mobile']->image_url }}">
                                    <div id="app_error" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="status" style="font-weight: 400 !important;">Status<font><span
                                                style="color: red;">*</span></font></label>
                                    <div class="row">
                                        <div class="pl-2 mr-4">
                                            <input type="radio" value="active" name="status"
                                                id="status_active" name="status" {{ $data['mobile']->is_active ? 'checked' : '' }}>
                                            <label for="status_active" style="font-weight: 400 !important;">
                                                Active
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" value="not_active" name="status"
                                                id="status_not_active" name="status" {{ !$data['mobile']->is_active ? 'checked' : '' }}>
                                            <label for="status_not_active" style="font-weight: 400 !important;">
                                                Not Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="status_error" class="text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="description" style="font-weight: 400 !important;">
                                        Description<font><span style="color: red;">*</span></font>
                                    </label>
                                    <textarea name="description" id="description" class="form-control" rows="2">{{ $data['mobile']->description }}</textarea>
                                </div>
                                <div id="description_error" class="text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="app" style="font-weight: 400 !important;">
                                        Note
                                    </label>
                                    <input type="text" class="form-control" id="note" name="note" value="{{ $data['mobile']->note }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="logo" style="font-weight: 400 !important;">Logo</label>
                                    <input class="form-control" type="file" id="logo" name="logo" accept=".png,.jpeg,.jpg">
                                    <input type="file" id="croppedLogo" name="croppedLogo" style="display: none;">
                                    <input type="hidden" id="image_url" value="{{ $data['mobile']->image_url }}">
                                    <small id="logoHelp" class="form-text text-muted">
                                        <i>Maximum file size 2MB (.png/.jpeg)</i>
                                    </small>
                                    <div id="logo_error" class="mb-2" style="color: red;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" >
                                <div id="preview-box" data-toggle="modal" data-target="#cropModal">
                                    @if (file_exists(public_path('img/mobile-app' .$data['mobile']->image_url)) && $data['mobile']->image_url)
                                        <img id="preview-image" src="{{ asset('img/mobile-app'.$data['mobile']->image_url) }}"
                                            alt="Logo Preview">
                                        <span id="no-logo-text" style="display:none;">No Logo</span>
                                    @else
                                        <img id="preview-image" src="#" style="display:none;">
                                        <span id="no-logo-text">No Logo</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-11">
                                <div class="card">
                                    <div class="card-header"
                                        style="color: #2E308A !important;font-weight: 600 !important;">
                                        Mapping Module
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-10">
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
                                            <div class="col-md-2">
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
                                                        @foreach ($data['mobileModule'] as $item)
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="text-dark text-lg" style="font-size: 16px !important; font-weight: 600 !important;color: #2E308A !important;">
                                            Development
                                        </label>
                                    </div>
                                    <div class="col-md-9 text-md-right">
                                        <button type="button" class="btn btn-sm btn-primary" style="background-color:#0D66FA !important;color:white !important; border-radius: 6px !important;border: 0px solid #0D66FA !important;font-size:14px;" onclick="addDev()">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblApp" class="table-sm table-bordered w-100" style="width: 100% !important;">
                                            <thead style="border-right: 0px !important;font-size:14px !important;color:#2E308A !important;">
                                                <tr>
                                                    <th class="text-center" style="width: 5%;text-align: center;">No</th>
                                                    <th style="width: 60%;text-align: left;">URL</th>
                                                    <th style="width: 5%;text-align: center;">Version</th>
                                                    <th style="width: 10%;text-align: left;">Remark</th>
                                                    <th style="width: 10%;text-align: center;">Status</th>
                                                    <th style="width: 10%;text-align: center !important;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['listDev'] as $itemDev)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ $itemDev->url }}" style="text-decoration: underline;font-weight: 400;color: #4053EE !important;font-size:14px;" target="_blank">
                                                                <input type="hidden" value="{{ $itemDev->url }}" id="url_dev_{{ $loop->iteration }}">
                                                                <input type="hidden" value="{{ $itemDev->id }}" id="dev_ids_{{ $loop->iteration }}">
                                                                {{ $itemDev->url }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $itemDev->version }}</td>
                                                        <td>{{ $itemDev->remark }}</td>
                                                        <td>{{ $itemDev->is_active ? 'Active' : 'Not Active' }}</td>
                                                        <td>
                                                            <a href="javascript:;" class="edit_data_dev" style="color: #2E308A;">
                                                                <img src="/img/logo/pencil.png" width="18px" height="18px">
                                                            </a>
                                                            <a href="javascript:;" class="remove_data_dev" style="color: red;" data-id="{{ $itemDev->id }}">
                                                                <img src="/img/logo/delete.png" width="18px" height="18px">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="text-dark text-lg"
                                            style="font-size: 16px !important; font-weight: 600 !important;color: #2E308A !important;">
                                            Production (Android)
                                        </label>
                                    </div>
                                    <div class="col-md-9 text-md-right">
                                        <button type="button" class="btn btn-sm btn-primary" style="background-color:#0D66FA !important;color:white !important; border-radius: 6px !important;border: 0px solid #0D66FA !important;font-size:14px;" onclick="addAndro()">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" style="font-size: 14px; font-weight:400;">URL (Play Store)</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <textarea name="url_android" id="url_android" cols="5" rows="2" class="form-control">{{ $data['mobile']->prod_android_url }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblAndroid" class="table-sm table-bordered w-100"
                                            style="width: 100% !important;">
                                            <thead
                                                style="border-right: 0px !important;font-size:14px !important;color:#2E308A !important;">
                                                <tr>
                                                    <th class="text-center" style="width: 5%;text-align: center;">
                                                        No
                                                    </th>
                                                    <th style="width: 10%;text-align: center;">Version</th>
                                                    <th style="width: 65%;text-align: left;">Remark</th>
                                                    <th style="width: 10%;text-align: center;">Status</th>
                                                    <th style="width: 10%;text-align: center !important;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['listProdAndro'] as $itemAndro)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $itemAndro->version }}
                                                        </td>
                                                        <td>{{ $itemAndro->remark }}</td>
                                                        <td>{{ $itemAndro->is_active ? 'Active' : 'Not Active' }}</td>
                                                        <td>
                                                            <a href="javascript:;" class="edit_data_andro" style="color: #2E308A;">
                                                                <input type="hidden" value="{{ $itemAndro->id }}" id="prod_andro_ids_{{ $loop->iteration }}">
                                                                <img src="/img/logo/pencil.png" width="18px" height="18px">
                                                            </a>
                                                            <a href="javascript:;" class="remove_data_andro" style="color: red;" data-id="{{ $itemAndro->id }}">
                                                                <img src="/img/logo/delete.png" width="18px" height="18px">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-footer bg-white">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="text-dark text-lg"
                                            style="font-size: 16px !important; font-weight: 600 !important;color: #2E308A !important;">
                                            Production (IOS)
                                        </label>
                                    </div>
                                    <div class="col-md-9 text-md-right">
                                        <button type="button" class="btn btn-sm btn-primary" style="background-color:#0D66FA !important;color:white !important; border-radius: 6px !important;border: 0px solid #0D66FA !important;font-size:14px;" onclick="addIOS()">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" style="font-size: 14px; font-weight:400;">URL (App Store)</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <textarea name="url_app_store" id="url_app_store" cols="5" rows="2" class="form-control">{{ $data['mobile']->prod_ios_url }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblIOS" class="table-sm table-bordered w-100"
                                            style="width: 100% !important;">
                                            <thead
                                                style="border-right: 0px !important;font-size:14px !important;color:#2E308A !important;">
                                                <tr>
                                                    <th class="text-center" style="width: 5%;text-align: center;">
                                                        No
                                                    </th>
                                                    <th style="width: 10%;text-align: center;">Version</th>
                                                    <th style="width: 65%;text-align: left;">Remark</th>
                                                    <th style="width: 10%;text-align: center;">Status</th>
                                                    <th style="width: 10%;text-align: center !important;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['listProdIOS'] as $itemIOS)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $itemIOS->version }}
                                                        </td>
                                                        <td>{{ $itemIOS->remark }}</td>
                                                        <td>{{ $itemIOS->is_active ? 'Active' : 'Not Active' }}</td>
                                                        <td>
                                                            <a href="javascript:;" class="edit_data_ios" style="color: #2E308A;">
                                                                <input type="hidden" value="{{ $itemIOS->id }}" id="prod_ios_ids_{{ $loop->iteration }}">
                                                                <img src="/img/logo/pencil.png" width="18px" height="18px">
                                                            </a>
                                                            <a href="javascript:;" class="remove_data_ios" style="color: red;">
                                                                <img src="/img/logo/delete.png" width="18px" height="18px">
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
                    <a href="{{ route('mobile-management.index') }}" class="btn btn-secondary mr-2"
                        style="background-color: white; color:#464F60;border: 1px solid #464F60;">CANCEL</a>
                    <button type="button" class="btn btn-primary" id="createBtn" style="background-color: #2E308A; color: white;" disabled>
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
<div class="modal fade" id="devModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px !important; font-weight:600;">Add New Development APK</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="app" style="font-weight: 400 !important;">
                                Dev URL (Google Drive)<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="dev_url" placeholder="https://">
                            <div id="dev_url_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="app" style="font-weight: 400 !important;">
                                Version<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="version" onkeypress="return isNumberKey(event)">
                            <div id="version_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="app" style="font-weight: 400 !important;">
                                Remark<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="remark">
                            <div id="remark_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" style="font-weight: 400 !important;">
                                Status
                            </label>
                            <div class="row">
                                <div class="pl-2 mr-4">
                                    <input type="radio" value="Active" id="status_dev_act" name="status_dev" checked>
                                    <label for="status_dev_act" style="font-weight: 400 !important;">
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" value="Not Active" id="status_dev_nact" name="status_dev">
                                    <label for="status_dev_nact" style="font-weight: 400 !important;">
                                        Not Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">
                    CANCEL
                </button>
                <button type="button" class="btn btn-primary" id="saveDevBtn" style="background-color: #2E308A;color: white;">
                    ADD
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="androidModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px !important; font-weight:600;">
                    Add New Version on Production - Play Store
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="version_android" style="font-weight: 400 !important;">
                                Version<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="version_android" onkeypress="return isNumberKey(event)">
                            <div id="version_android_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="remark_android" style="font-weight: 400 !important;">
                                Remark<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="remark_android">
                            <div id="remark_android_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" style="font-weight: 400 !important;">
                                Status
                            </label>
                            <div class="row">
                                <div class="pl-2 mr-4">
                                    <input type="radio" value="Active" id="status_android_act" name="status_android" checked>
                                    <label for="status_android_act" style="font-weight: 400 !important;">
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" value="Not Active" id="status_android_nact" name="status_android">
                                    <label for="status_android_nact" style="font-weight: 400 !important;">
                                        Not Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">
                    CANCEL
                </button>
                <button type="button" id="saveAndroidBtn" class="btn btn-primary" style="background-color: #2E308A;color: white;">
                    ADD
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="iosModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px !important; font-weight:600;">
                    Add New Version on Production - App Store
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="version_ios" style="font-weight: 400 !important;">
                                Version<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="version_ios" onkeypress="return isNumberKey(event)">
                            <div id="version_ios_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="remark_ios" style="font-weight: 400 !important;">
                                Remark<font><span style="color: red;">*</span></font>
                            </label>
                            <input type="text" class="form-control" id="remark_ios">
                            <div id="remark_ios_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" style="font-weight: 400 !important;">
                                Status
                            </label>
                            <div class="row">
                                <div class="pl-2 mr-4">
                                    <input type="radio" value="Active" id="status_ios_act" name="status_ios" checked>
                                    <label for="status_ios_act" style="font-weight: 400 !important;">
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" value="Not Active" id="status_ios_nact" name="status_ios">
                                    <label for="status_ios_nact" style="font-weight: 400 !important;">
                                        Not Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">
                    CANCEL
                </button>
                <button type="button" id="saveIosBtn" class="btn btn-primary" style="background-color: #2E308A;color: white;">
                    ADD
                </button>
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
                <button type="button" class="btn" style="background-color: #FFFFFF !important;color:#464F60 !important; border: 1px solid #464F60;" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn" onclick="submit(event)" style="background-color: #2E308A;color: white;">
                    YES
                </button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/update-app.js') }}" defer></script>
<script>
    const submitProses = () => {
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
            let formData = new FormData(document.getElementById('formApp'));
            $.blockUI();
            $.ajax({
                type: "POST",
                url: "{{ route('mobile-management.update') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#submitConfirmation').modal('hide');
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    } else {
                        if (response.code == 409) {
                            $('#submitConfirmation').modal('hide');
                            $('#app_error').html(response.message);
                            $('#app').focus();
                        } else if (response.code == 422) {
                            toastr.error(response.message);
                        }
                    }
                    $.unblockUI();
                },
            });
        }

    }
</script>
@endsection
