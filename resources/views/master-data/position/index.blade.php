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
            width: 120px;
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
    </style>

    @include('master-data.position.modal')

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
                                    <span style="padding-top: 1px;">Add Position</span>
                                </p>
                            </a>
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
    <script>
        let dsStore;

        $(document).ready(function() {
            getData();
        });

        function getData() {
            var table = $('#moduleTable').DataTable({
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
                    url: "{{ route('position.get_data') }}",
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
                        title: 'POSITION',
                        data: 'position',
                        name: 'position',
                        className: "text-left text-truncate",
                        width: '85%',
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
                    table.search(this.value).draw()
                }
            });
        }

        const addData = () => {
            $.blockUI();
            dsStore = 'add';
            $('.text-danger').text('');
            $('#validationPosition').text('');
            $('#formModules')[0].reset();
            $('#moduleModalTitle').html('Add New Position')
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
            $('#validationPosition').text('');
            $.ajax({
                type: "GET",
                url: "{{ route('position.edit') }}",
                data: {
                    id : id
                },
                success: function (response) {
                    $('#moduleModalTitle').html('Edit Position');
                    $('#submitBtn').html('SAVE CHANGES');
                    $('#id').val(response.data.id);
                    $('#position').val(response.data.position);
                    $('#addModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $.unblockUI();
                }
            });
        }

        $('#formModules').on('submit', function(e) {
            e.preventDefault();

            $('.text-danger').text('');

            var formData = {
                id : $('#id').val(),
                position: $('#position').val(),
            };

            var isValid = true;
            if (!formData.position) {
                $('#validationPosition').text('Position is required.');
                isValid = false;
            }

            if (isValid) {
                $.blockUI();
                $.ajax({
                    url: dsStore == 'add' ? '{{ route("position.store") }}' : '{{ route("position.update") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            getData();
                            $('#addModal').modal('hide');
                            toastr.success(response.message);
                            $('#formModules')[0].reset();
                            $.unblockUI();
                        } else if(!response.success && response.error == 'duplicate') {
                            $('#validationPosition').text(response.message);
                            $.unblockUI();
                        } else {
                            if (response.errors) {
                                if (response.errors.module) {
                                    $('#validationPosition').text(response.errors.module[0]);
                                }
                            }
                        }
                        $.unblockUI();
                    },
                    error: function(xhr) {
                       toastr.error(xhr.responseJSON.message);
                       $.unblockUI();
                    }
                });
            }
        });

        const deleteData = (id) => {
            Swal.fire({
                title: "Delete Item",
                text: "Are you sure you want to delete? This action cannot be undone.",
                confirmButtonText: "Delete",
                confirmButtonColor: '#D1293D',
                showCancelButton: true,
                reverseButtons: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    $.blockUI();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('position.delete') }}",
                        data: {
                            id : id,
                            _token : "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            getData();
                            $.unblockUI();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            $.unblockUI();
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            })

        }
    </script>
@endsection
