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
            width: 140px;
        }

    </style>

    @include('livewire.s-s-o-management.roles.roles-modal')

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="text-dark text-lg">{{ $data['page_title'] }}</label>
                        </div>
                        <div class="col-md-9 text-md-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1" onclick="addData()">
                                <p style="font-size: 14px;font-weight: 600;">
                                    <img src="{{ asset('img/logo/add_circle.png') }}" alt="">
                                    Add Role
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pl-2 pr-4">
                            <img src="{{ asset('img/logo/roles-blue.png') }}" alt="">
                            Total : {{ $data['totalData'] }}
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/roles-green.png') }}" alt="">
                            Active : {{ $data['active'] }}
                        </div>
                        <div class="pr-4">
                            <img src="{{ asset('img/logo/roles-red.png') }}" alt="">
                            Not Active : {{ $data['not_active'] }}
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div>
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>MODULE</th>
                                    <th>ROLE</th>
                                    <th style="text-align: center;">STATUS</th>
                                    <th style="text-align: center;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['listData'] as $app)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $app->module }}</td>
                                        <td>{{ $app->role }}</td>
                                        <td style="text-align: center;">
                                            @if ($app->is_active)
                                                <img src="{{ asset('img/logo/active.png') }}" alt=""> Active
                                            @else
                                                <img src="{{ asset('img/logo/not_active.png') }}" alt="">Not Active
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="#" class="btn btn-sm btn-xs btn-xl" onclick="editData()" wire:click="editData({{$app->id}})">
                                                <img src="{{ asset('img/logo/pencil.png') }}" alt="">
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
