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
    </style>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="text-dark text-lg">{{ $data['page_title'] }}</label>
                        </div>
                        <div class="col-md-9 text-md-right">
                            <a href="{{ route('users.create') }}"
                                class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1">
                                <p
                                    style="font-size: 14px; font-weight: 600; display: flex; align-items: center;text-align: center !important;">
                                    <img src="{{ asset('img/logo/add_circle.png') }}"
                                        style="margin-right: 2px; margin-left: 4px;">
                                    <span style="padding-top: 1px;">Add User</span>
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pl-2 pr-4">
                            <img src="{{ asset('img/logo/group-blue.png') }}" alt="">
                            Total : {{ $data['totalData'] }}
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/group-green.png') }}" alt="">
                            Active : {{ $data['active'] }}
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/group-red.png') }}" alt="">
                            Not Active : {{ $data['not_active'] }}
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
        window.Laravel = {!! json_encode([ 'app_env' => config('app.env'),]) !!};
        var table;
        $(document).ready(function() {
            table = $('#moduleTable').DataTable({
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
                    url: "{{ route('users.get_all_data') }}",
                },
                columns: [
                {
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
                    title: 'USERNAME',
                    data: 'username',
                    name: 'username',
                    className: "text-left text-truncate",
                    width: '20%',
                },
                {
                    title: 'NIK',
                    data: 'nik',
                    name: 'nik',
                    className: "text-left text-truncate",
                    width: '10%',
                },
                {
                    title: 'FULL NAME',
                    data: 'fullname',
                    name: 'fullname',
                    className: "text-left text-truncate",
                    width: '15%',
                },
                {
                    title: 'EMAIL',
                    data: 'email',
                    name: 'email',
                    className: "text-left text-truncate",
                    width: '20%',
                },
                {
                    title: 'TYPE',
                    data: 'type',
                    name: 'type',
                    className: "text-left text-truncate",
                    width: '10%',
                },
                {
                    title: 'STATUS',
                    data: 'is_active',
                    name: 'is_active',
                    className: "text-center text-truncate",
                    render: function(data, type, row, meta) {
                        if (data) {
                            return '<img src="/img/logo/active.png" alt=""> Active';
                        } else {
                            return '<img src="/img/logo/not_active.png" alt=""> Not Active';
                        }
                    },
                    width: '10%',
                },
                {
                    title: 'ACTION',
                    data: 'id',
                    className: 'text-center text-truncate',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        var appEnv = window.Laravel.app_env;

                        if (appEnv === 'local') {
                            return '<a href="/sso-management-users/detail/' + data + '" class="btn btn-sm btn-xs btn-xl"><i class="nav-icon material-symbols-rounded" style="font-size: 22px!important;color:#2E308A">visibility</i></a>';
                        } else {
                            return '<a href="/4/sso-management-users/detail/' + data + '" class="btn btn-sm btn-xs btn-xl"><i class="nav-icon material-symbols-rounded" style="font-size: 22px!important;color:#2E308A">visibility</i></a>';
                        }

                       
                    },
                    width: '10%',
                }
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
        });
    </script>
@endsection
