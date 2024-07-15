<div class="modal fade" id="moduleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="moduleModalTitle" style="font-size: 18px !important; font-weight:600;">

                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formModules">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="module" style="font-weight: 400 !important;">
                                    Module Name<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="module" name="module" style="text-transform: uppercase;">
                                <input type="hidden" id="id" name="id">
                                <div id="validationModule" class="text-danger">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="desc" style="font-weight: 400 !important;">
                                    Description<font><span style="color: red;">*</span></font>
                                </label>
                                <textarea class="form-control" name="desc" id="desc" cols="5" rows="2"></textarea>
                                <div id="validationDesc" class="text-danger">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="status" style="font-weight: 400 !important;">
                                Platform
                            </label>
                            <div class="row">
                                <div class="pl-2 mb-2 w-100">
                                    <input type="checkbox" value="web" id="platform_web" name="platform[]" style="margin-right: 8px;">
                                    <label for="platform_web" style="font-weight: 400 !important; ">
                                        <i class="fas fa-globe" style="margin-right: 8px;"></i> WEB
                                    </label>
                                </div>
                                <div class="pl-2 mb-2 w-100">
                                    <input type="checkbox" value="mobile" id="platform_mobile" style="margin-right: 8px;" name="platform[]">
                                    <label for="platform_mobile" style="font-weight: 400 !important;">
                                        <i class="fas fa-mobile-alt" style="margin-right: 8px;"></i> MOBILE
                                    </label>
                                </div>
                            </div>
                            
                            <div id="validationplatform" class="text-danger">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prod" style="font-weight: 400 !important;">
                                    Prod URL<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="pro_url" name="pro_url" placeholder="https://">
                                <div id="validationprod" class="text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dev" style="font-weight: 400 !important;">
                                    Dev URL<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="dev_url" name="dev_url" placeholder="https://">
                                <div id="validationdev" class="text-danger">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="local" style="font-weight: 400 !important;">
                                    Local URL
                                </label>
                                <input type="text" class="form-control" id="local_url" name="local_url" placeholder="https://">
                                <div id="validationlocal" class="text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="api" style="font-weight: 400 !important;">
                                    API URL
                                </label>
                                <input type="text" class="form-control" id="api_url" name="api_url" placeholder="https://">
                                <div id="validationapi" class="text-danger">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="version" style="font-weight: 400 !important;">
                                    Version<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="version" name="version" onkeypress="return isNumberKey(event)">
                                <div id="validationVersion" class="text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="status" style="font-weight: 400 !important;">
                                Status<font><span style="color: red;">*</span></font>
                            </label>
                            <div class="row">
                                <div class="pl-2 mr-4">
                                    <input type="radio" value="active" id="status_active" name="status" checked>
                                    <label for="status_active" style="font-weight: 400 !important;">
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" value="no active" id="status_non_active" name="status">
                                    <label for="status_non_active" style="font-weight: 400 !important;">
                                        Not Active
                                    </label>
                                </div>
                            </div>
                            <div id="validationStatus" class="text-danger">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                               
                                <label for="keymodule" id="keymodule" name="keymodule" style="font-weight: bold;">
                                    
                                </label>
                            </div>
                        </div>
                        
                    </div>


                </div>
                </form>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" wire:click="closeModal" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">CANCEL</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" style="background-color: #2E308A;color: white;">

                    </button>
                </div>
        </div>
    </div>
</div>

