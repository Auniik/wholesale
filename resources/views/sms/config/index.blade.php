@extends('layout.app')
@push('style')
    <style>
        .modal.in .modal-dialog {
            transform: translate(15%, 10%) !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel">
                <div class="panel-heading">
                    <h4 class="panel-title">SMS Configuration</h4>
                </div>
                <div class="panel-body print_body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="box-body">
                        @can('indoor-settings-create')
                            <form method="POST" action="{{route('sms-configs.store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Company Name :</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="company_id">
                                            <option selected="selected" value="">Select any one</option>
                                            @foreach($companies as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="masking_name" class="col-md-3 control-label">Masking Name:</label>
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="Masking Name" required name="masking_name" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="space_location" class="col-md-3 control-label">User Name:</label>
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="User Name" required name="user_name" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Password:</label>
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="Password" required name="user_password" type="password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="price" class="col-md-3 control-label">SMS Quantity :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="SMS Quantity" required name="sms_quantity" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input class="btn btn-primary col-md-12" type="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <table class="table table-striped table-hover table-bordered " id="my_table">
                <thead>
                <tr>
                    <th width="5%">SL</th>
                    <th>Company Name</th>
                    <th width="20%">Masking Name</th>
                    <th width="30%">User Name</th>
                    <th width="10%">Quantity</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                @php($sl = $smsConfigs->firstItem())
                @foreach($smsConfigs as $config)
                    <tr>
                        <td class="text-center">{{$sl++}}</td>
                        <td>{{$config->company->company_name ?? ''}}</td>
                        <td>{{decrypt($config->masking_name)}}</td>
                        <td>{{decrypt($config->user_name)}}</td>
                        <td>{{decrypt($config->sms_quantity)}}</td>
                        <td class="text-center">
                            <a type="submit" href="{{route('sms-configs.destroy', $config->id)}}" class="btn btn-danger btn-xs deletable" title="delete"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pull-right">
        </div>
    </div>
@endsection