@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default page-panel">
                <div class="panel-heading">
                    All Company
                    @can('company-create')
                    <div class="panel-btn pull-right">
                        <a href="{{route('companies.create')}}" class="btn btn-success btn-sm" > <i class="fa fa-plus"></i> Add New</a>
                    </div>
                    @endcan
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">SL</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Fax</th>
                            <th>Website</th>
                            <th>Status</th>
                            <th width="8%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? $i=0; ?>
                        @foreach($companies as $data)
                            <? $i++; ?>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$data->company_name}}</td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->address}}</td>
                                <td>{{$data->mobile_no}}</td>
                                <td>{{$data->fax}}</td>
                                <td>{{$data->web}}</td>
                                <td>{{status($data->web)}}</td>
                                <td style="text-align: center">
                                    {{Form::open(array('route'=>['companies.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id"))}}
                                    @can('company-update')
                                    <a href='{{route("companies.edit", $data)}}' class="btn btn-success btn-xs"> <i class="fa fa-pencil-square"></i></a>
                                    @endcan
                                    @can('company-delete')
                                    <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm('deleteForm{{$data->id}}')"><i class="fa fa-trash"></i></button>
                                    @endcan
                                    {!! Form::close() !!}

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                {{$companies->render()}}
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>



@endsection