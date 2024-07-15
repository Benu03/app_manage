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
            width: 140px;
        }

        .table-responsive-sm img {
            max-width: 100%;
            height: auto;
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
                            <a href="{{ route('web-management.create') }}"
                                class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1">
                                <p style="font-size: 14px; font-weight: 600; display: flex; align-items: center;">
                                    <img src="{{ asset('img/logo/add_circle.png') }}" alt=""
                                        style="margin-right: 2px;margin-left: 3px;">
                                    <span style="padding-top: 1px;">Add Application</span>
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pl-2 pr-4">
                            <img src="{{ asset('img/logo/cp_blue.png') }}" alt="">
                            Total : {{ $data['totalData'] }}
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/cp_green.png') }}" alt="">
                            Active : {{ $data['active'] }}
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/cp_red.png') }}" alt="">
                            Not Active : {{ $data['not_active'] }}
                        </div>
                        <div class="col-md-12">
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div class="">
                        <table class="table table-sm table-striped" style="width: 100%;" id="tblWeb">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let table;
       $(document).ready(function() {
            table = $('#tblWeb').DataTable({
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
                    type: "GET",
                    url: "{{ route('web-management.get_data') }}",
                },
                columns: [
                    {
                        title: 'NO',
                        orderable: false,
                        data: null,
                        className: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        title: 'APP NAME',
                        data: 'app'
                    },
                    {
                        title: 'DEV URL',
                        data: 'dev_url',
                        render: function(data, type, row) {
                            return data ? `<a href="${data}" target="_blank">${data}</a>` : '';
                        }
                    },
                    {
                        title: 'PROD URL',
                        data: 'prod_url',
                        render: function(data, type, row) {
                            return data ? `<a href="${data}" target="_blank">${data}</a>` : '';
                        }
                    },
                    {
                        title: 'LOGO',
                        data: 'image_url',
                        render: function(data, type, row) {
                            let baseUrl = "{{ asset('img/portal-app') }}";
                            let imageUrl = row.image_url ? row.image_url : 'default-logo.png';
                            return `<img src="${baseUrl}/${imageUrl}" alt="" style="width: 50px; height: 50px; border-radius: 10px;">`;
                        }
                    },
                    {
                        title: 'STATUS',
                        data: 'is_active',
                        className: 'text-center',
                        render: function(data, type, row) {
                            let statusImage = data ? 'img/logo/active.png' : 'img/logo/not_active.png';
                            let statusText = data ? 'Active' : 'Not Active';
                            let baseUrl = "{{ asset('') }}";
                            return `<img src="${baseUrl}${statusImage}" alt=""> ${statusText}`;
                        }
                    },
                    {
                        title: 'ACTION',
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row) {
                            let editUrl = `{{ url('app-management-web/edit') }}/${data}`;
                            return `<a href="${editUrl}" class="btn btn-sm btn-xs btn-xl">
                                        <img src="{{ asset('img/logo/pencil.png') }}" alt="">
                                    </a>`;
                        }
                    }
                ],
                initComplete: function(settings, json) {
                    $("#tblWeb").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }

            });

            $('#tblWeb_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    var searchTerm = this.value;
                    table.search(searchTerm, true, false).draw();
                }
            });

        });
    </script>
@endsection
