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
                                <label for="department" style="font-weight: 400 !important;">
                                    Department<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="department" name="department" style="text-transform: uppercase;">
                                <input type="hidden" id="id" name="id">
                                <div id="validationDepartment" class="text-danger">

                                </div>
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
