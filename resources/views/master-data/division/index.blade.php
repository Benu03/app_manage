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

        #tblAvailable_length{
            display: none;
        }

        #tblAvailable_wrapper .dataTable thead th {
            background-color: #F2F2F2;
            color: #2E308A;
        }

        #tblAvailable_wrapper .dataTable thead th:first-child{
            border-left: 1px solid #ddd;
        }

        #tblAvailable_wrapper .dataTable thead th:last-child {
            border-right: 1px solid #ddd;
        }

        #tblAvailable_wrapper .dataTable tbody td:first-child {
            border-left: 1px solid #ddd;
        }

        #tblAvailable_wrapper .dataTable tbody td:last-child {
            border-right: 1px solid #ddd;
        }

        #tblSelected_length{
            display: none;
        }

        #tblSelected_wrapper .dataTable thead th {
            background-color: #F2F2F2;
            color: #2E308A;
        }

        #tblSelected_wrapper .dataTable thead th:first-child{
            border-left: 1px solid #ddd;
        }

        #tblSelected_wrapper .dataTable thead th:last-child {
            border-right: 1px solid #ddd;
        }

        #tblSelected_wrapper .dataTable tbody td:first-child {
            border-left: 1px solid #ddd;
        }

        #tblSelected_wrapper .dataTable tbody td:last-child {
            border-right: 1px solid #ddd;
        }

        #tblSelected .dataTable tbody td:nth-child(3){
            text-align: center !important;
        }
    </style>

    @include('master-data.division.modal')

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
                                    <span style="padding-top: 1px;">Add Division</span>
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
            getDepartment();
            $('#tblSelected').DataTable({
                autoWidth: false,
                searching: true,
                info: false,
                ordering: false,
                paging: false,
                scrollX: false,
                scrollCollapse: false,
            });

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
                    url: "{{ route('division.get_data') }}",
                    data: function(d) {
                        var searchTerm = $('#moduleTable_filter input').val();
                        d.search = {
                            value: searchTerm,
                            regex: true
                        };
                    }
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
                        title: 'DIVISION',
                        data: 'division',
                        name: 'division',
                        className: "text-left text-truncate",
                        width: '40%',
                    },
                    {
                        title: 'DEPARTMENTS',
                        data: 'departments',
                        name: 'departments',
                        className: "text-left",
                        width: '45%',
                        render: function(data, type, row) {
                            return data;
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
                    table.search(this.value).draw()
                }
            });
        }

        const addData = () => {
            $.blockUI();
            getDepartment();
            dsStore = 'add';
            $('#tblSelected tbody').empty();
            $('.text-danger').text('');
            $('#validationDivision').text('');
            $('#formModules')[0].reset();
            $('#moduleModalTitle').html('Add New Division')
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
            $('#validationDivision').text('');
            $.ajax({
                type: "GET",
                url: "{{ route('division.edit') }}",
                data: {
                    id : id
                },
                success: function (response) {
                    getDepartment();
                    $('#moduleModalTitle').html('Edit Division');
                    $('#submitBtn').html('SAVE CHANGES');
                    $('#id').val(response.data.id);
                    $('#division').val(response.data.division);

                    if (response.departments.length === 0) {
                        $('#tblSelected tbody').empty();
                    } else {
                        let table = $('#tblSelected').DataTable({
                            autoWidth: false,
                            searching: true,
                            info: false,
                            ordering: false,
                            paging: false,
                            scrollX: false,
                            scrollCollapse: false,
                            destroy: true,
                            language: {
                                processing: '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary"></i></div> <div class="text-center">Processing...</div>',
                            },
                            columnDefs: [
                                { "className": "text-center", "targets": [0, 2] }
                            ]
                        });

                        table.clear();

                        // Menambahkan data baru
                        $.each(response.departments, function(index, value) {
                            table.row.add([
                                `<td class="text-center">${index + 1}</td>`,
                                `<td>${value.department}</td>`,
                                `<td class="text-center">
                                    <input type="hidden" name="selected_departments[]" value="${value.id_department}">
                                    <i class="fa fa-times delete-dept" style="color: red; cursor: pointer;"></i>
                                </td>`
                            ]).draw();
                        });
                    }


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
            var selectedDepartments = $('#tblSelected input[name="selected_departments[]"]').map(function() {
                return $(this).val();
            }).get();

            var formData = {
                id : $('#id').val(),
                division: $('#division').val(),
                selectedDepart : selectedDepartments
            };

            var isValid = true;
            if (!formData.division) {
                $('#validationDivision').text('Division is required.');
                isValid = false;
            }

            if (selectedDepartments.length == 0) {
                toastr.error('Error : Department is mandatory.');
                isValid = false;
            }

            if (isValid) {
                $.blockUI();
                $.ajax({
                    url: dsStore == 'add' ? '{{ route("division.store") }}' : '{{ route("division.update") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            getData();
                            getDepartment();
                            $('#addModal').modal('hide');
                            toastr.success(response.message);
                            $('#formModules')[0].reset();
                            $.unblockUI();
                        } else if(!response.success && response.error == 'duplicate') {
                            $('#validationDivision').text(response.message);
                            $.unblockUI();
                        } else {
                            if (response.errors) {
                                if (response.errors.module) {
                                    $('#validationDivision').text(response.errors.module[0]);
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
                        url: "{{ route('division.delete') }}",
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

        function getDepartment()
        {
            var table = $('#tblAvailable').DataTable({
                autoWidth: false,
                searching: true,
                pageLength: 5,
                info: false,
                destroy: true,
                ordering: false,
                scrollX: false,
                scrollCollapse: false,
                pageLength: 5,
                language: {
                    processing: '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary"></i></div> <div class="text-center">Processing...</div>',
                },
                ajax: {
                    type: 'GET',
                    url: "{{ route('division.get_department') }}",
                },

                columns: [
                    { data: 'id', className: "text-center", render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1 +
                                '<input type="hidden" id="id_depart" name="id_depart" value="' + data + '">';
                        }
                    },
                    { data: 'department' },
                    { data: 'id', className: "text-center", render: function(data, type, row) {
                            return '<i class="fa fa-plus-circle add-dept" style="background-color: white;color: #36A834; cursor: pointer;"></i>';
                        }
                    }
                ]
            });
        }
    </script>
    <script src="{{ asset('js/division.js') }}"></script>
@endsection
