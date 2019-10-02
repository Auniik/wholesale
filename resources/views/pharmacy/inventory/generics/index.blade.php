@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel">
                    <div class="panel-heading">
                        <div class="panel-heading-btn pull-right">
                            @can('inventory-settings-create')
                                <div class="create_button">
                                    <a href="ui_modal_notification.html#modal-dialog" class="btn btn-sm btn-success" data-toggle="modal">Add Generic Name</a>
                                </div>
                            @endcan
                        </div>
                        <h4 class="panel-title">Medicine Generics</h4>
                    </div>
                    <div class="panel-body">
                    @can('inventory-settings-create')
                        <!-- #modal-dialog -->
                            <div class="modal fade" id="modal-dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('inventory-generics.store')}}" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Set Generic Name</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4">Generic Name *:</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input type="text" class="form-control" name="name" value="" placeholder="Enter Generic Name" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" value="1" id="radio-required" checked /> Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" id="radio-required2" value="0" /> Inactive
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <!--  -->
                    <div class="view_generic_set">
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">SL</th>
                                    <th>Generic Name</th>
                                    <th class="text-center" width="10%">Status</th>
                                    <th width="5%" class="text-center" colspan="2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($sl = $generics->firstItem())
                                @foreach($generics as $generic)
                                    <tr class="odd gradeX">
                                        <td>{{$sl++}}</td>
                                        <td>{{$generic->name}}</td>
                                        <td> {{status($generic->status)}} </td>
                                        @can('inventory-settings-update')
                                            <td>
                                                <!-- edit section -->
                                                <a href="ui_modal_notification.html#modal-dialog{{$generic->id}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <!-- #modal-dialog -->
                                                <div class="modal fade" id="modal-dialog{{$generic->id}}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{route('inventory-generics.update', $generic)}}" class="form-horizontal author_form">
                                                                @csrf
                                                                @method('patch')
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title">Modal Dialog</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-4 col-sm-4" for="generic_name">Category Name * :</label>
                                                                        <div class="col-md-8 col-sm-8">
                                                                            <input class="form-control" type="text" id="generic_name" name="name" value="{{$generic->name}}" data-parsley-required="true" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                                        <div class="col-md-3 col-sm-3">
                                                                            <div class="radio">
                                                                                <label>
                                                                                    <input type="radio" name="status" value="1" id="radio-required" {{$generic->status==1 ? 'checked' : ''}}> Active
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-4">
                                                                            <div class="radio">
                                                                                <label>
                                                                                    <input type="radio" name="status" value="0" id="radio-required2" {{$generic->status==0 ? 'checked' : ''}}> Inactive
                                                                                </label>
                                                                            </div>
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
                                        @endcan
                                        @can('inventory-settings-delete')
                                            <td>
                                                <a href="{{route('inventory-generics.destroy', $generic->id)}}" class="btn btn-xs btn-danger deletable">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        @endcan
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
@endsection