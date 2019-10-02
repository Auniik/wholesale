@extends('layout.app')
@push('style')
    <style>
        .modal.in .modal-dialog {
            transform: translate(15%, 10%) !important;
        }
    </style>
@endpush
@section('content')
<div id="content" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading-btn pull-right">
                        <a href="{{route('users.create')}}" class="btn btn-sm btn-success pull-right">  <i class="ion
                         ion-navicon-round"></i> Add new user</a>
                    </div>
                    <h4 class="panel-title">View All User </h4>
                </div>
                <div class="panel-body">
                    <div class="row search-samples">
                        <form method="get">
                            <div class="form-group col-md-3">
                                <label class="control-label col-md-12">Name :</label>
                                <div class="col-md-12">
                                    <input type="name" name="name" value="{{request('name')}}" class="form-control"
                                           placeholder="User Name" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label col-md-12">Role :</label>
                                <div class="col-md-12">

                                    <select name="role_id" class="form-control select2">
                                        <option value="">Select All</option>
                                        @foreach($roles as $role)

                                            <option value="{{$role->id}}" {{request('role_id')==$role->id ? 'selected' : ''}}>
                                                {{$role->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-md-12 no-padding" >&nbsp;</label>
                                <div class="col-sm-12 no-padding">
                                    <button type="submit" style="margin-top: 2px;" class="btn btn-success col-md-12">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="3%">Status</th>
                            <th width="10%">Created At</th>
                            <th colspan="2" width="5%">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i=1; ?>
                        @foreach($allUsers as $data)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <a href="#changePassModal{{$data->id}}" class="btn btn-xs btn-link" data-toggle="modal">{{$data->name}}</a>

                                    <div class="modal fade" id="changePassModal{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">                                            
                                                <form action="{{action('UsersController@changePass', $data->id)}}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Change Password</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4">Old Password *:</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="password" class="form-control" name="old_password"  >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4">New Password *:</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="password" class="form-control" name="password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4">Re Enter Password *:</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="password" class="form-control" name="password_confirmation">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                                                    <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                                </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->role->name}}</td>
                                <td>{{status($data->status==1)}}</td>
                                <td>{{date('d-M-Y',strtotime($data->created_at))}}</td>

                                @if(auth()->id() == $data->id || auth()->user()->role->name == 'Admin')
                                <td>
                                    <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-xs btn-info"><i class="fa fa-pencil-square"></i></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">{{$data->name}}</h4>
                                                </div>
                                                {!! Form::open(array('route' => ['users.update',$data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name" class="col-md-2 control-label">Name</label>
                                                        <div class="col-md-9">
                                                            {{Form::text('name',$data->name,array('class'=>'form-control','placeholder'=>'Name','required'))}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">

                                                        <label for="email" class="col-md-2 control-label">Email</label>
                                                        <div class="col-md-9">
                                                            {{Form::email('email',$data->email,array('class'=>'form-control','placeholder'=>'Email','required'))}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone_number" class="col-md-2 control-label">Phone Number</label>
                                                        <div class="col-md-9">
                                                            {{Form::text('phone_number',$data->phone_number,array('class'=>'form-control','placeholder'=>'Mobile','required'))}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address" class="col-md-2 control-label">Address</label>
                                                        <div class="col-md-9">
                                                            {{Form::text('address',$data->address,array('class'=>'form-control','placeholder'=>'Address','required'))}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-md-2 control-label">Role</label>
                                                        <div class="col-md-9">
                                                            <select name="role_id" id="" class="form-control">
                                                                <option value="">Select One</option>
                                                                @foreach($roles as $role)
                                                                    <option value="{{$role->id}}" {{$data->role_id == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{Form::hidden('id',$data->id)}}

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    {{Form::submit('Save changes',array('class'=>'btn btn-success'))}}
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                </td>
                                @endif
                                @if (auth()->user()->role->name == 'Admin')
                                    <td>
                                        {!! Form::open(array('route' => ['users.destroy',$data->id],'method'=>'DELETE')) !!}
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirmDelete();"><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif


                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{$allUsers->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
