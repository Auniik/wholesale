@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel">
            <div class="panel-heading">
                <h4 class="panel-title">User Roles</h4>
            </div>
            <div class="panel-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="box-body">
                    <form method="POST" action="{{route('roles.store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="ward" class="col-md-2 control-label">Role Name</label>
                            <div class="col-md-6">
                                <input class="form-control" placeholder="Role Name" required name="name" type="text" value="" autocomplete="off">
                            </div>

                            <div class="col-md-2">
                                <input class="btn btn-success" type="submit" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-hover table-bordered " id="my_table">
                        <thead>
                        <tr>
                            <th width="5%">SL</th>
                            <th>Role Name</th>
                            <th colspan="3" width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sl = $roles->firstItem(); ?>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="text-center">{{$sl++}}</td>
                                <td>{{$role->name}}</td>
                                <td><a href="{{route('permissions.edit',$role->id)}}" class="btn btn-default btn-xs" title="Set Permission">Set Permission</a></td>
                                <td> <a href="ui_modal_notification.html#modal-dialog{{$role->id}}" class="btn btn-info btn-xs" title="edit" data-toggle="modal"><i class="fa fa-pencil-square-o"></i></a></td>
                                <td class="text-center">
                                    <button type="submit" href="{{route('roles.destroy', $role->id)}}" class="btn btn-danger btn-xs deletable" title="delete"><i class="fa fa-trash-o"></i></button>
                                    <!-- #modal-dialog -->
                                    <div class="modal fade" id="modal-dialog{{$role->id}}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="POST" action="{{route('roles.update', $role->id)}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Role Information</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4" for="role_name">Role Name * :</label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <input class="form-control" type="text" name="name" value="{{$role->name}}" data-parsley-required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end edit section -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{$roles->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection