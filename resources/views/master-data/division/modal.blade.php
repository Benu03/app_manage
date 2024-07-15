<div class="modal fade myModal" id="addModal">
    <div class="modal-dialog modal-xl">
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
                                <label for="division" style="font-weight: 400 !important;">
                                    Division<font><span style="color: red;">*</span></font>
                                </label>
                                <input type="text" class="form-control" id="division" name="division" style="text-transform: uppercase;">
                                <input type="hidden" id="id" name="id">
                                <div id="validationDivision" class="text-danger">

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <label for="position" class="text-left" style="font-weight: 600 !important;font-size: 16px !important;color:#2E308A;">
                                        Available Department
                                    </label>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm w-100" id="tblAvailable">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">No</th>
                                                <th style="width:85%;">Department</th>
                                                <th style="width:10%;" class="text-center">Add</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($data['listDepartment'] as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                    <input type="hidden" id="id_depart" name="id_depart" value="{{ $item->id }}">
                                                </td>
                                                <td>{{ $item->department }}</td>
                                                <td class="text-center">
                                                    <i class="fa fa-plus-circle add-dept" style="background-color: white;color: #36A834; cursor: pointer;"></i>
                                                </td>
                                            </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <label for="position" class="text-left" style="font-weight: 600 !important;font-size: 16px !important;color:#2E308A;">
                                        Selected Department
                                    </label>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm w-100" id="tblSelected">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">No</th>
                                                <th style="width:85%;">Department</th>
                                                <th style="width:10%;text-align:center !important;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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
