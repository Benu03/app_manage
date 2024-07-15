<div wire:ignore.self class="modal fade" id="moduleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="moduleModalTitle" style="font-size: 18px !important; font-weight:600;">
                    Add New Module
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="saveData">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="module" style="font-weight: 400 !important;">
                                    Module Name<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="module" name="module" wire:model.defer="module" style="text-transform: uppercase;">
                                @error('module')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc" style="font-weight: 400 !important;">
                                    Description<font><span style="color: red;">*</span></font>
                                </label>
                                <textarea class="form-control" name="desc" id="desc" cols="5" rows="2" wire:model.defer="desc"></textarea>
                                @error('desc')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="version" style="font-weight: 400 !important;">
                                    Version<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="version" name="version" wire:model.defer="version" onkeypress="return isNumberKey(event)">
                            </div>
                            @error('version')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" style="font-weight: 400 !important;">
                                Status<font><span style="color: red;">*</span></font>
                            </label>
                            <div class="row">
                                <div class="pl-2 mr-4">
                                    <input type="radio" value="active" id="status_active" name="status" wire:model.defer="status">
                                    <label for="status_active" style="font-weight: 400 !important;">
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" value="no active" id="status_non_active" name="status" wire:model.defer="status">
                                    <label for="status_non_active" style="font-weight: 400 !important;">
                                        Not Active
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" wire:click="closeModal" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">CANCEL</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="background-color: #2E308A;color: white;">
                        ADD
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Update Modal --}}
<div wire:ignore.self class="modal fade" id="updateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="moduleModalTitle" style="font-size: 18px !important; font-weight:600;">
                    Edit Module
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="updateData">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="module" style="font-weight: 400 !important;">
                                    Module Name<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="module" name="module" wire:model.defer="module" style="text-transform: uppercase;">
                                @error('module')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc" style="font-weight: 400 !important;">
                                    Description<font><span style="color: red;">*</span></font>
                                </label>
                                <textarea class="form-control" name="desc" id="desc" cols="5" rows="2" wire:model.defer="desc"></textarea>
                                @error('desc')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="version" style="font-weight: 400 !important;">
                                    Version<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="version" name="version" wire:model.defer="version" onkeypress="return isNumberKey(event)">
                            </div>
                            @error('version')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" style="font-weight: 400 !important;">
                                Status<font><span style="color: red;">*</span></font>
                            </label>
                            <div class="row">
                                <div class="pl-2 mr-4">
                                    <input type="radio" value="active" id="status_active" name="status" wire:model.defer="status">
                                    <label for="status_active" style="font-weight: 400 !important;">
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" value="no active" id="status_non_active" name="status" wire:model.defer="status">
                                    <label for="status_non_active" style="font-weight: 400 !important;">
                                        Not Active
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" wire:click="closeModal" data-dismiss="modal" style="background-color: white;color: #000000;outline-color:#464F60;">CANCEL</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="background-color: #2E308A;color: white;">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

