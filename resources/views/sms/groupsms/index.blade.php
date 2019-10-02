
@extends('layout.app')
@section('content')
    <!-- begin #content -->
    <div id="content" class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('sms-group-create')
                        <div class="panel-heading-btn pull-right">
                            <div class="create_button">
                                <a href="#modal-dialog" class="btn btn-sm btn-success" data-toggle="modal">Add New Group</a>
                            </div>
                        </div>
                        @endcan
                        <h4 class="panel-title">SMS Group </h4>
                    </div>
                    <div class="panel-body">
                        @can('sms-group-create')
                        <!-- #modal-dialog -->
                        <div class="modal fade" id="modal-dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    {!! Form::open(array('route' => 'sms-group.store','enctype'=>'multipart/form-data','class'=>'form-horizontal author_form','method'=>'POST','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Group Settings</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4">Group Name *:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="text" class="form-control" name="group_name" value="" placeholder="Enter Group Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4">File *:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="file" class="form-control" name="csv_file" class="form-controller">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                    </div>
                                    {!! Form::close(); !!}
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                    <!--  -->
                    <div class="view_brand_set">
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="1%">Sl</th>
                                    <th width="15%">Group Name</th>
                                    <th>Numbers</th>
                                    <th width="8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($groups as $group)
                                    <?php $i++; ?>
                                    <tr class="odd gradeX">
                                        <td>{{$i}}</td>
                                        <td>{{$group->group_name}}</td>
                                        <td>{{ $group->numbers }}</td>
                                        <td>
                                            @can('sms-group-update')
                                            <!-- edit section -->
                                            <a href="#modal-dialog<?php echo $group->id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <!-- #modal-dialog -->
                                            <div class="modal fade" id="modal-dialog<?php echo $group->id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        {!! Form::open(array('route' => ['sms-group.update',$group->id],'class'=>'form-horizontal author_form','method'=>'PUT','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title">Update {{ $group->group_name }} Information</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4" for="brand_name">Group Name * :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" id="group_name" name="group_name" value="<?php echo $group->group_name; ?>" data-parsley-required="true" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4">Phone Numbers :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <textarea name="numbers" class="form-control">{{ $group->numbers }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                                                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                        </div>
                                                        {!! Form::close(); !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end edit section -->
                                            @endcan
                                            @can('sms-group-destroy')
                                            <!-- delete section -->
                                            {!! Form::open(array('route'=> ['sms-group.destroy',$group->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$group->id")) !!}
                                            {{ Form::hidden('id',$group->id)}}
                                            <button type="button" onclick="return deleteConfirm('deleteForm{{$group->id}}');" class="btn-xs btn btn-danger">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                            {!! Form::close() !!}
                                            @endcan
                                        <!-- delete section end -->
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
    <!-- end #content -->

@endsection
