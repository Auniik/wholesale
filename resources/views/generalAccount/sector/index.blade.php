@extends('layout.app')
@section('title', 'Chart of Account')
		@section('content')
        <style type="text/css">
            /*form{display: inline;}*/
            .form-group{width: 100%;height: auto; overflow: hidden; display: block !important; margin: 5px;}
            .form-control{width: 100% !important;}
            .control-label{
                color: black !important;
            }
        </style>
		<!-- begin #content -->
		<div id="content" class="content">
			<div class="row">
			    <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @can('account-settings-create')
                            <div class="panel-heading-btn pull-right">
                                <!-- Add new account -->
                                <a href="#addNew" class="btn btn-info btn-xs" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                                <!-- #addNew -->
                                <div class="modal fade" id="addNew">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(array('route' =>'chart-of-accounts.store','class'=>'form-horizontal','method'=>'POST')) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title"> Chart of Account</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4">Sector Type :</label>
                                                    <div class="col-md-3 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="type" value="2" id="radio1" checked> Income
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="type" id="radio2" value="1" > Expense
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4" for="sector_name">Sector Name * :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="text" id="sector_name" name="sector_name" />
                                                    </div>
                                                </div>

                                                {{--<div class="form-group">--}}
                                                    {{--<label for="sector-type" class="control-label col-md-4 col-sm-4">Group :</label>--}}
                                                    {{--<div class="col-md-8">--}}
{{--                                                        {{Form::select('sector_type', ['1'=>'General', '2'=>'Asset', '3'=>'Loan', '4'=>'Payroll'], '',['class'=>'form-control','required'])}}--}}
                                                        {{--<select id="sector-type" name="sector_type" class="form-control" required>--}}
                                                            {{--@foreach($sectorTypes as $sectorType)--}}
                                                                {{--<option value="{{ $sectorType->id }}">{{ $sectorType->name }}</option>--}}
                                                            {{--@endforeach--}}
                                                        {{--</select>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                    <div class="col-md-3 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" value="1" id="radio-required" checked> Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" id="radio-required2" value="0" > Inactive
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                            {!! Form::close(); !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- end edit section -->
                            </div>
                            @endcan
                            <h4 class="panel-title">Chart of Account List</h4>
                        </div>
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">Sl</th>
                                        <th>Chart of Account Name</th>
                                        <th>Chart of Account Type</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sl = $allData->firstItem();
                                ?>
                                @foreach($allData as $data)
                                    <tr class="odd gradeX">
                                        <td>{{$sl++}}</td>
                                        <td>{{$data->sector_name}}</td>
                                        <td>{{($data->type==1)? 'Expense' : 'Income' }}</td>
                                        <td>{{status($data->status)}}</td>
                                        <td>
                                            @can('account-settings-update')
                                        <!-- edit section -->
                                            <a href="#modal-dialog<?php echo $data->id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <!-- #modal-dialog -->
                                            <div class="modal fade" id="modal-dialog<?php echo $data->id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    {!! Form::open(array('route' => ['chart-of-accounts.update',$data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title">Edit Chart of Account</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4">Chart of Account Type :</label>
                                                                <div class="col-md-3 col-sm-3">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="type" value="2" id="radio1" @if($data->type=="2"){{"checked"}}@endif> Income
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="type" id="radio2" value="1" @if($data->type=="1"){{"checked"}}@endif> Expense
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4" for="sector_name">Chart of Account Name * :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" id="sector_name" name="sector_name" value="<?php echo $data->sector_name; ?>"  />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4">Account Status :</label>
                                                                <div class="col-md-3 col-sm-3">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" value="1" id="radio-required"  @if($data->status=="1"){{"checked"}}@endif> Active
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" id="radio-required2" value="0" @if($data->status=="0"){{"checked"}}@endif> Inactive
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                        </div>
                                                    {!! Form::close(); !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end edit section -->
                                        @endcan
                                        @can('account-settings-delete')
                                            <!-- delete section -->
                                            {!! Form::open(array('route'=> ['chart-of-accounts.destroy',$data->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$data->id")) !!}
                                            {{ Form::hidden('id',$data->id)}}
                                            <button type="button" onclick="return deleteConfirm('deleteForm{{$data->id}}');" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                            {!! Form::close() !!}
                                            <!-- delete section end -->
                                        @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                            <div class="pull-right">
                                {{$allData->links()}}
                            </div>

                        </div>
                    </div>
			    </div>
			</div>
		</div>
		<!-- end #content -->
    @endsection
