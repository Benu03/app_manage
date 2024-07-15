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

    @include('livewire.s-s-o-management.modules.modules-modal')

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="text-dark text-lg">{{ $data['page_title'] }}</label>
                        </div>
                        <div class="col-md-9 text-md-right">
                            <a href="javascript:void(0)" onclick="addData()" class="btn btn-sm btn-xs btn-xl custom-btn text-primary primary-btn p-1">
                                <p style="font-size: 14px;font-weight: 600;">
                                    <img src="{{ asset('img/logo/add_circle.png') }}" alt="">
                                    Add Department
                                </p>
                            </a>
                        </div>
                    </div>
                    <hr style="width: 103%;margin-left:-21px;" id="hrx">
                    <div>
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="text-align: left;width: 85%;">DEPARTMENT</th>
                                    <th style="text-align: center;width: 10%;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['listData'] as $app)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $app->department }}</td>
                                    <td style="text-align: center;">
                                        <a href="#" class="btn btn-sm btn-xs btn-xl">
                                            <img src="{{ asset('img/logo/pencil.png') }}" alt="">
                                        </a>
                                        <a href="#" class="btn btn-sm btn-xs btn-xl">
                                            <img src="{{ asset('img/logo/delete.png') }}" alt="">
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
