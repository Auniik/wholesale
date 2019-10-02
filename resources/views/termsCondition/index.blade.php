@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info page-panel">
                <div class="panel-heading">
                    Terms &amp; Condition
                    <div class="panel-btn pull-right">
                        <a href="{{URL::to('terms-condition/create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i>  Add New </a>
                    </div>
                </div>
                <div class="panel-body">

                    <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Link </th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? $i=1; ?>
                        @foreach($allData as $data)
                            <tr>
                                <td>{{$i++}}</td>
                                <td><a href="{{route('terms-condition.show',$data->id)}}">{{$data->title}}</a></td>
                                <td><a href="{{URL::to('terms-condition/'.$data->link)}}">{{$data->link}}</a></td>

                                <td><i class="{{($data->status==1)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['terms-condition.destroy',$data->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$data->id")) !!}
                                    <a class="btn btn-xs btn-info" href='{{URL::to("terms-condition/$data->id/edit")}}'> <i class="fa fa-edit"></i> </a>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="return deleteConfirm('deleteForm{{$data->id}}')"><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{$allData->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
