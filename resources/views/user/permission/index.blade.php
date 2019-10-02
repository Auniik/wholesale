@extends('layout.app')
@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn pull-right">
                            <a href="{{URL::to('roles')}}" class="btn btn-success btn-xs">Set Permission to Roles</a>
                        </div>
                        <h4 class="panel-title">ACL Permission</h4>
                    </div>
                    <div class="panel-body">
                        {{--{!! Form::open(array('route' => 'acl-permission.store','class'=>'form-horizontal','method'=>'POST','role'=>'form','data-parsley-validate novalidate')) !!}--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="control-label col-md-3">Permission Name *:</label>--}}
                            {{--<div class="col-md-7">--}}
                                {{--<input type="text" class="form-control" name="name" value="" placeholder="Permission Name">--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                                {{--<button type="submit" class="btn btn-success">Submit</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--{!! Form::close(); !!}--}}
                    </div>
                    <!--  -->
                    <div class="view_uom_set">
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="4%">Sl</th>
                                    <th width="30%">Permission</th>
                                    <th width="30%">Name</th>
                                    <th width="30%">Group</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($permissions as $permission)
                                    <?php $i++; ?>
                                    <tr class="odd gradeX">
                                        <td>{{$i}}</td>
                                        <td>{{$permission->permission_name}}</td>
                                        <td>{{$permission->name}}</td>
                                        <td>{{$permission->group_name}}</td>
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