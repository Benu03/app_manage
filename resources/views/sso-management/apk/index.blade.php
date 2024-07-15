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
            width: 110px;
        }
    </style>

    @include('sso-management.apk.modal')

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
                                    <span style="padding-top: 1px;">Add APK</span>
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pl-2 pr-4">
                            <img src="{{ asset('img/logo/m_blue.png') }}" alt="">
                            <span id="total">Total : {{ $data['totalData'] }}</span>
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/m_green.png') }}" alt="">
                            <span id="active">Active : {{ $data['active'] }}</span>
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/m_red.png') }}" alt="">
                            <span id="notActive">Not Active : {{ $data['not_active'] }}</span>
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div class="">
                        <table class="table table-sm table-striped" style="width: 100%;" id="apkTable">
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
        $(document).ready(function() {
            getDataCount();
            table = $('#apkTable').DataTable({
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
                    url: "{{ route('apk.get_data') }}",
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
                        title: 'APK',
                        data: 'name_app',
                        name: 'name_app',
                        className: "text-left text-truncate",
                        width: '20%',
                    },
                    {
                        title: 'DESCRIPTION',
                        data: 'description',
                        name: 'description',
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
                        title: 'VERSION',
                        data: 'version',
                        name: 'version',
                        className: "text-center text-truncate",
                        width: '15%',
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
                    $("#apkTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
            });

            $('#apkTable_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    var searchTerm = this.value;
                    table.search(searchTerm, true, false).draw();
                }
            });
        });

        const addData = () => {
            $.blockUI();
            dsStore = 'add';
            $('.text-danger').text('');
            $('#validationapk').text('');
            $('#formApk')[0].reset();
            $('#apkModalTitle').html('Add New APK')
            $('#submitBtn').html('ADD')
            $('#apkModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $.unblockUI();
        }

        const editData = (id) => {
            $.blockUI();
            dsStore = 'edit';
            $('.text-danger').text('');
            $('#validationApk').text('');
            $.ajax({
                type: "GET",
                url: "{{ route('apk.edit') }}",
                data: {
                    id : id
                },
                success: function (response) {
                    $('#apkModalTitle').html('Edit APK');
                    $('#submitBtn').html('SAVE CHANGES');

                    $('#id').val(response.data.id);
                    $('#apk').val(response.data.name_app);
                    $('#desc').val(response.data.description);
                    $('#version').val(response.data.version);
                    if (response.data.is_active) {
                        $('#status_active').prop('checked', true);
                    } else {
                        $('#status_non_active').prop('checked', true);
                    }
                    $('#apkModal').modal({
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
            $('#msgTitle').html(`APK will be ${txt}, make sure all data are correct. Are you sure to continue?`)
            $('#submitConfirmation').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        function submit(){

            $('.text-danger').text('');
            var formData = {
                id : $('#id').val(),
                apk: $('#apk').val(),
                desc: $('#desc').val(),
                version: $('#version').val(),
                status: $('input[name="status"]:checked').val()
            };

            $('input[name="platform[]"]:checked').each(function() {
                formData.platform.push($(this).val());
            });

            // Client-side validation
            var isValid = true;
            if (!formData.apk) {
                $('#validationapk').text('APK Name is required.');
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }
            if (!formData.desc) {
                $('#validationDesc').text('Description is required.');
                isValid = false;
                $('#submitConfirmation').modal('hide');
            }
     
            if (!formData.version) {
                $('#validationVersion').text('Version is required.');
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
                    url: dsStore == 'add' ? '{{ route("apk.store") }}' : '{{ route("apk.update") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            getDataCount();
                            table.ajax.reload();
                            $('#apkModal').modal('hide');
                            toastr.success(response.message);
                            $('#formApk')[0].reset();
                            $.unblockUI();
                        } else if(!response.success && response.error == 'duplicate') {
                            $('#validationapk').text(response.message);
                            $.unblockUI();
                        } else {
                            if (response.errors) {
                                if (response.errors.apk) {
                                    $('#validationapk').text(response.errors.apk[0]);
                                }
                                if (response.errors.desc) {
                                    $('#validationDesc').text(response.errors.desc[0]);
                                }
                                if (response.errors.version) {
                                    $('#validationVersion').text(response.errors.version[0]);
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
                url: "{{ route('apk.get_count') }}",
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var clipboard = new ClipboardJS('#copyButton');
    
            clipboard.on('success', function (e) {
                console.log('Copied!');
                e.clearSelection();
            });
    
            clipboard.on('error', function (e) {
                console.error('Error copying text.');
            });
        });
    </script>
    
@endsection
