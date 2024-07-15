@extends('layouts.main')
@section('content')
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
            height: 32px;
            width: 95px;
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

        .flex-container {
            display: flex;
            align-items: center;
        }

        .flex-container i {
            margin-right: 0.5rem;
        }
    </style>

    @include('sso-management.roles.modal')

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="text-dark text-lg">{{ $data['page_title'] }}</label>
                        </div>
                        <div class="col-md-9 text-md-right">
                            <a href="javascript:void(0)" onclick="addData()"
                                class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1">
                                <p style="font-size: 14px; font-weight: 600; display: flex; align-items: center;text-align: center !important;">
                                    <img src="{{ asset('img/logo/add_circle.png') }}" style="margin-right: 2px; margin-left: 4px;" >
                                    <span style="padding-top: 1px;">Add Role</span>
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pl-2 pr-4 flex-container">
                            <i class="material-symbols-outlined" style="color:#4053EE !important;font-variation-settings: 'FILL' 1;">
                                frame_person
                            </i>
                            <span id="total">Total : {{ $data['totalData'] }}</span>
                        </div>
                        <div class="pr-4 flex-container">
                            <i class="material-symbols-outlined" style="color:#32C935 !important;font-variation-settings: 'FILL' 1;">
                                frame_person
                            </i>
                            <span id="active">Active : {{ $data['active'] }}</span>
                        </div>
                        <div class="pr-4 flex-container">
                            <i class="material-symbols-outlined" style="color:#ED6C69 !important;font-variation-settings: 'FILL' 1;">
                                frame_person
                            </i>
                            <span id="notActive">Not Active : {{ $data['not_active'] }}</span>
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div>
                        <table class="table table-sm table-striped" style="width: 100%;" id="moduleTable">
                        </table>
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
    <script>
        let dsStore;
        var table;
        $('#addModal').on('shown.bs.modal', function () {
            $('.select2modal').select2({
                dropdownParent: $("#addModal")
            });
        });

        $(document).ready(function() {
            getData();
            getDataCount();
        });

        function getData() {
            table = $('#moduleTable').DataTable({
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
                    url: "{{ route('roles.get_data') }}",
                },
                columns: [{
                        title: 'NO',
                        orderable: false,
                        data: null,
                        className: "text-center",
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        title: 'MODULE',
                        data: 'module',
                        name: 'module',
                        className: "text-left text-truncate",
                        width: '20%',
                    },
                    {
                        title: 'ROLE',
                        data: 'role',
                        name: 'role',
                        className: "text-left text-truncate",
                        width: '35%',
                    },
                    {
                        title: 'STATUS',
                        data: 'is_active',
                        name: 'is_active',
                        className: "text-center text-truncate",
                        width: '15%',
                        render: function(data, type, row) {
                            if (data) {
                                return '<img src="{{ asset('img/logo/active.png') }}" alt="Active"> Active';
                            } else {
                                return '<img src="{{ asset('img/logo/not_active.png') }}" alt="Not Active"> Not Active';
                            }
                        }
                    },
                    {
                        title: 'ACTION',
                        data: 'action',
                        name: 'action',
                        className: "text-center text-truncate",
                        width: '10%',
                    },
                ],
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                initComplete: function(settings, json) {
                    $("#moduleTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
            });

            $('#moduleTable_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    var searchTerm = this.value;
                    table.search(searchTerm, true, false).draw();
                }
            });
        }

        const addData = () => {
            $.blockUI();
            dsStore = 'add';
            $('.text-danger').text('');
            $('#validationRole').text('');
            $('#formModules')[0].reset();
            $('#moduleModalTitle').html('Add New Role')
            $('#submitBtn').html('ADD')
            $('#addModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $.unblockUI();
        }

        const editData = (id) => {
            $.blockUI();
            dsStore = 'edit';
            $('.text-danger').text('');
            $('#validationRole').text('');
            $.ajax({
                type: "GET",
                url: "{{ route('roles.edit') }}",
                data: {
                    id : id
                },
                success: function (response) {
                    $('#moduleModalTitle').html('Edit Role');
                    $('#submitBtn').html('SAVE CHANGES');
                    $('#id').val(response.data.id);
                    $('#module').val(response.data.auth_module_id).trigger('change');
                    $('#role').val(response.data.role);
                    if (response.data.is_active) {
                        $('#status_active').prop('checked', true);
                    } else {
                        $('#status_non_active').prop('checked', true);
                    }
                    $('#addModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $.unblockUI();
                }
            });
        }

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            let txt = dsStore == 'add' ? 'added' : 'updated';
            $('#msgTitle').html(`Role will be ${txt}, make sure all data are correct. Are you sure to continue?`)
            $('#submitConfirmation').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        function submit() {

            $('.text-danger').text('');

            var formData = {
                id : $('#id').val(),
                module: $('#module').val(),
                role: $('#role').val(),
                status: $('input[name="status"]:checked').val()
            };

            // Client-side validation
            var isValid = true;
            if (!formData.module) {
                $('#validationModule').text('Module Name is required.');
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }
            if (!formData.role) {
                $('#validationRole').text('Role is required.');
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }
            if (!formData.status) {
                $('#validationStatus').text('Status is required.');
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }

            if (isValid) {
                $.blockUI();
                $.ajax({
                    url: dsStore == 'add' ? '{{ route("roles.store") }}' : '{{ route("roles.update") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            getDataCount();
                            getData();
                            $('#addModal').modal('hide');
                            toastr.success(response.message);
                            $('#formModules')[0].reset();
                            $.unblockUI();
                        } else if(!response.success && response.error == 'duplicate') {
                            $('#validationRole').text(response.message);
                            $.unblockUI();
                        } else {
                            if (response.errors) {
                                if (response.errors.module) {
                                    $('#validationModule').text(response.errors.module[0]);
                                }
                                if (response.errors.desc) {
                                    $('#validationRole').text(response.errors.desc[0]);
                                }
                                if (response.errors.status) {
                                    $('#validationStatus').text(response.errors.status[0]);
                                }
                            }
                        }
                        $('#submitConfirmation').modal('hide');
                        $.unblockUI();
                    },
                    error: function(xhr) {
                       toastr.error(xhr.responseJSON.message);
                       $.unblockUI();
                    }
                });
            }
        }

        function getDataCount() {
            $.ajax({
                type: "GET",
                url: "{{ route('roles.get_count') }}",
                success: function (response) {
                    $('#total').empty();
                    $('#active').empty();
                    $('#notActive').empty();
                    $('#total').append(`Total : ${response.data.totalData}`);
                    $('#active').append(`Active : ${response.data.active}`);
                    $('#notActive').append(`Not Active : ${response.data.not_active}`);
                }
            });
        }
    </script>
@endsection
