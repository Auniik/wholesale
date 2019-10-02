@extends('layout.app')
@push('style')
    <style>
        /*form{display: inline;}*/
        /*.form-group{width: 100%;height: auto; overflow: hidden; display: block !important; margin: 5px;}*/
        .form-control{width: 100% !important;}
        /**/
    </style>
@endpush
@section('content')
    <!-- begin #content -->
<div id="content" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('task-list')
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href="{{route('tasks.create')}}"><i class="fa fa-plus"></i>&nbsp;New Task</a>
                    </div>
                    @endcan
                    <h4 class="panel-title"><!-- <i class="fa fa-users">&nbsp;</i> -->All Task </h4>
                </div>
                <div class="panel-body">
                    <div class="row search-report">
                        <div class="col-md-12">
                            <form method="get">
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="startDate">Start Date :</label>
                                    <input class="form-control datepicker" autocomplete="off" placeholder="Date" value="{{ request('startDate', date('d-m-Y')) }}" required name="startDate" type="text">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label"> &nbsp;</label>
                                    <input class="form-control text-center" type="text" value="TO" readonly="" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="endDate">End Date :</label>
                                    <input class="form-control datepicker" autocomplete="off" placeholder="Date" value="{{request('endDate', date('d-m-Y'))}}" required name="endDate" type="text">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="status">Status:</label>
                                    <div class="col-md-12">
                                        <select name="status" id="" class="form-control select">
                                            <option value="">Select All</option>
                                            <option value="pending" {{request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in-progress" {{request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="control-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-success col-md-12">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-bordered " width="100%">
                        <thead>
                        <tr>
                            <th width="1">Sl</th>
                            <th width="25%">Task Name</th>
                            <th>Description</th>
                            <th width="12%">Date</th>
                            <th width="8%">Remarks</th>
                            <th width="8%">Status</th>
                            <th width="12%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sl = $tasks->firstItem()
                        @endphp
                        @foreach($tasks ?? [] as $task)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ $task->name }}</td>
                                <td>{{ str_limit($task->description, 160) }}</td>
                                <td>{{ $task->date->format('d/m/Y') }}</td>
                                <td>{{ $task->remarks }}</td>
                                <td>{{ $task->status() }}</td>
                                <td>
                                    @can('task-update')
                                    <a href="#modal-dialog{{$task->id}}" class="btn btn-success btn-xs" data-toggle="modal"><i class="fa fa-star-half"></i> </a>
                                    <a class="btn btn-info btn-xs" href="{{ route('tasks.edit',$task->id) }}"><i class="fa fa-pencil"></i></a>
                                    @endcan
                                    @can('task-delete')
                                    <a type="button" href="{{route('tasks.destroy', $task->id)}}" class="btn-xs btn btn-danger deletable">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @can('task-update')
                            <div class="modal fade" id="modal-dialog{{$task->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('tasks.update', $task)}}" accept-charset="UTF-8" class="form form-horizontal">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Task Name: {{ $task->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 text-right" for="status">Task Status  :</label>
                                                            <div class="col-md-8">
                                                                <select name="status" class="form-control">
                                                                    <option value="pending" {{$task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="in-progress" {{$task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                                    <option value="completed" {{$task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                    <option value="canceled" {{$task->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="form-group">
                                                            <label class="control-label  col-md-3 text-right" for="brand_name">Feedback  :</label>
                                                            <div class="col-md-8">
                                                                <textarea class="form-control" name="feedback">{{ $task->feedback }}</textarea>
                                                            </div>
                                                        </div>
                                                        <br><br>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 text-right">Remarks</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="remarks" value="{{ $task->remarks }}" autocomplete="off" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

