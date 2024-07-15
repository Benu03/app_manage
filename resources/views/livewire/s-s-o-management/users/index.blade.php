<div>
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
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1">
                                <p style="font-size: 14px; font-weight: 600; display: flex; align-items: center;text-align: center !important;">
                                    <img src="{{ asset('img/logo/add_circle.png') }}" style="margin-right: 2px; margin-left: 4px;" >
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
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>USERNAME</th>
                                    <th>NIK</th>
                                    <th>FULL NAME</th>
                                    <th>EMAIL</th>
                                    <th>TYPE</th>
                                    <th style="text-align: center;">STATUS</th>
                                    <th style="text-align: center;width: 10%;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['listData'] as $app)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $app->username }}</td>
                                        <td>{{ strtoupper($app->nik) }}</td>
                                        <td>{{ $app->fullname }}</td>
                                        <td>{{ $app->email }}</td>
                                        <td>{{ $app->type }}</td>
                                        <td style="text-align: center;">
                                            @if ($app->is_active)
                                                <img src="{{ asset('img/logo/active.png') }}" alt=""> Active
                                            @else
                                                <img src="{{ asset('img/logo/not_active.png') }}" alt=""> Not Active
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ url('/sso-management-users/detail/' . $app->id) }}" class="btn btn-sm btn-xs btn-xl">
                                                <img src="{{ asset('img/logo/eye-open.png') }}" alt="">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
