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

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 5px;
            right: 1px;
            width: 20px;
        }

        #mdmTable thead th:after {
            content: none;
        }

        #mdmTable thead th:before {
            content: none;
        }
    </style>
    <div>
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
                                        <span style="padding-top: 1px;">Add Data</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <hr style="width: 103%;margin-left:-21px;" id="hrx">
                        <div>
                            <div class="">
                                <table class="table datatable table-sm table-striped" id="mdmTable" style="width: 100%;">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 18px; font-weight: 600;" id="addTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formMdm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id" style="font-weight: 400 !important;">
                                        ID
                                    </label>
                                    <input type="text" class="form-control" id="id" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" style="font-weight: 400 !important;">
                                        Type<font color="red">*</font>
                                    </label>
                                    <select class="form-control" id="type" name="type" style="width: 100%;">
                                        <option value="" selected>-- SELECT TYPE --</option>
                                        <option value="master">master</option>
                                    </select>
                                    <div id="validation_type" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="master_name" style="font-weight: 400 !important;">
                                        Master Name<font color="red">*</font>
                                    </label>
                                    <input type="text" class="form-control" id="master_name" style="text-transform: lowercase;">
                                    <div id="validation_master_name" class="text-danger">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="query_master" style="font-weight: 400 !important;">
                                        Query Master<font color="red">*</font>
                                    </label>
                                    <textarea class="form-control" name="query_master" id="query_master" cols="5" rows="2" style="text-transform: lowercase;"></textarea>
                                    <div id="validation_query_master" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: -20px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="source" style="font-weight: 400 !important;">
                                        Source<font color="red">*</font>
                                    </label>
                                    <input type="text" class="form-control" id="source" style="text-transform: lowercase;">
                                    <div id="validation_source" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc" style="font-weight: 400 !important;">
                                        Description<font color="red">*</font>
                                    </label>
                                    <input type="text" class="form-control" id="desc" name="desc" style="text-transform: lowercase;">
                                    <div id="validation_desc" class="text-danger">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #FFFFFF !important;color:#464F60 !important; border: 1px solid #464F60;" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn" id="submitBtn" style="background-color: #2E308A;color: white;">

                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let dsStore;
        $(document).ready(function() {
            getData();
        });

        const addData = () => {
            $.blockUI();
            $('#formMdm').trigger("reset");
            getId();
            dsStore = 'add';
            $('#master_name').val('');
            $('#source').val('');
            $('#desc').val('');
            $('#type').val('').trigger('change');
            $('#query_master').val('');
            $('#addTitle').html('Add New Master Data');
            $('#submitBtn').html('ADD');
            $('#addModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $.unblockUI();
        }

        const editData = (id) => {
            $.blockUI();
            $('#formMdm').trigger("reset");
            dsStore = 'edit';
            $('#addTitle').html('Edit Master Data');
            $('#submitBtn').html('SAVE CHANGES');
            $('#addModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $.ajax({
                type: "GET",
                url: "{{ route('mdm.edit') }}",
                data: {
                    id: id
                },
                success: function (response) {
                    $('#id').val(response.data.id);
                    $('#master_name').val(response.data.name_master);
                    $('#source').val(response.data.source);
                    $('#desc').val(response.data.desc);
                    $('#type').val(response.data.type).trigger('change');
                    $('#query_master').val(response.data.query_master);
                }
            });
            $.unblockUI();
        }


        function getData()
        {
            var table = $('#mdmTable').DataTable({
                autoWidth: false,
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: false,
                scrollCollapse: false,
                pageLength: 10,
                language: {
                    processing: '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary"></i></div> <div class="text-center">Processing...</div>',
                },
                ajax: {
                    type: 'GET',
                    url: "{{ route('mdm.get_data') }}",
                },
                columns: [
                    { title: 'NO', orderable: false, data: null, className: "text-center", render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } },
                    { title: 'ID',  data: 'id', name: 'id', className: "text-left" },
                    { title: 'MASTER NAME',  data: 'name_master', name: 'name_master', className: "text-left" },
                    { title: 'SOURCE', data: 'source', name: 'source', className: "text-left" },
                    { title: 'DESCRIPTION',  data: 'desc', name: 'desc', className: "text-left" },
                    { title: 'TYPE',  data: 'type', name: 'type', className: "text-left" },
                    { title: 'QUERY MASTER',  data: 'query_master', name: 'query_master', className: "text-left" },
                    { title: 'ACTION', orderable: false, data: 'Action', className: 'text-center' }
                ],
                columnDefs: [
                    { width: '5%', targets: 0 },
                    { width: '5%', targets: 1 },
                    { width: '15%', targets: 2 },
                    { width: '10%', targets: 3 },
                    { width: '15%', targets: 4 },
                    { width: '10%', targets: 5 },
                    { width: '30%', targets: 6 },
                    { width: '10%', targets: 7 }
                ],
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                initComplete: function(settings, json) {
                    $("#mdmTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
            });

            // Filter Trigger With Enter
            $('#mdmTable_filter input').unbind();
            $('#mdmTable_filter input').bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });
        }

        function getId()
        {
            $.ajax({
                type: "GET",
                url: "{{ route('mdm.get_id') }}",
                success: function (response) {
                    $('#id').val(response.id);
                }
            });
        }

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            var name            = $('#master_name').val();
            var source          = $('#source').val();
            var desc            = $('#desc').val();
            var type            = $('#type').val();
            var query_master    = $('#query_master').val();

            $('.text-danger').text('');

            var isValid = true;

            if (!name) {
                $('#validation_master_name').text('Master Name is required.');
                isValid = false;
            }

            if (!source) {
                $('#validation_source').text('Source is required.');
                isValid = false;
            }

            if (!desc) {
                $('#validation_desc').text('Description is required.');
                isValid = false;
            }

            if (!type) {
                $('#validation_type').text('Type is required.');
                isValid = false;
            }

            if (!query_master) {
                $('#validation_query_master').text('Query Master is required.');
                isValid = false;
            }

            console.log(dsStore);
            console.log(isValid);

            if(isValid){
                $.ajax({
                    type: "POST",
                    url: dsStore == 'add' ? '{{ route('mdm.store') }}' : '{{ route('mdm.update') }}',
                    data: {
                        name_master: name,
                        source: source,
                        desc: desc,
                        type: type,
                        query_master: query_master,
                        id: $('#id').val(),
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        $('#mdmTable').DataTable().ajax.reload();
                        $('#addModal').modal('hide');
                        $('#master_name').val('');
                        $('#source').val('');
                        $('#desc').val('');
                        $('#type').val('');
                        $('#query_master').val('');
                        $('#id').val();

                        toastr.success(response.message);
                    }
                });
            }

        });

        $('#mdmTable').on('click', '.btn-delete[data-remote]', function(e) {
            e.preventDefault();
            var splitstr = $(this).data('remote');
            var arrstr = splitstr.split(",");
            var id = arrstr[0];

            Swal.fire({
                title: "Delete Item<br><br>",
                text: `Are you sure you want to delete ${arrstr[1]}? This action cannot be undone.`,
                confirmButtonText: "Delete",
                confirmButtonColor: '#D1293D',
                showCancelButton: true,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.blockUI();
                    $.ajax({
                        url: "{{ route('mdm.delete') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}",
                        },
                        dataType: "json",
                        success: function(response) {
                            $.unblockUI();
                            $('#mdmTable').DataTable().ajax.reload();
                            toastr.success(response.message);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            swal.fire("Something error !","error");
                            $.unblockUI();
                        },
                    })
                }
            })
        });
    </script>
@endsection
@section('script')
@endsection
