<div class="modal fade myModal" id="addModal">
    <div class="modal-dialog">
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
                                    Module<font><span style="color: red;">*</span></font>
                                </label>
                                <div wire:ignore>
                                    <select class="select2modal form-control" style="width: 100%;" id="module" name="module">
                                        <option value="" selected>-- Select Module --</option>
                                        @foreach ($data['listModule'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->module }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="validationModule" class="text-danger">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="version" style="font-weight: 400 !important;">
                                    Role Name<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="role" name="role" style="text-transform: uppercase;">
                                <input type="hidden" id="id" name="id">
                                <div id="validationRole" class="text-danger">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
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
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" wire:click="closeModal" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">CANCEL</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="background-color: #2E308A;color: white;">

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
