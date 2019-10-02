@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @can('inventory-settings-create')
                <div class="panel-heading-btn pull-right">
                    <div class="create_button">
                        <a href="ui_modal_notification.html#modal-dialog" class="btn btn-sm btn-success" data-toggle="modal">Add New Unit</a>
                    </div>
                </div>
                @endcan
                <h4 class="panel-title">Small Unit</h4>
            </div>
            <div class="panel-body">
            @can('inventory-settings-create')
                <!-- #modal-dialog -->
                <div class="modal fade" id="modal-dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{route('inventory-units.store')}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Small Unit</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Unit Name *:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="name" value="" placeholder="Enter uom Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Type *:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <select name="type" class="form-control" id="">
                                                <option value="retail">Retail</option>
                                                <option value="wholesale">Wholesale</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Status :</label>
                                        <div class="col-md-2 col-sm-2">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" id="radio-required" checked required /> Active
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
            </div>
            @endcan
            <!--  -->
            <div class="view_uom_set">
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                            <th width="5%">Sl</th>
                            <th>Unit Name</th>
                            <th>Type</th>
                            <th width="10%">Status</th>
                            <th width="10%" colspan="2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = $units->firstItem(); ?>
                        @foreach($units as $unit)
                            <tr class="odd gradeX">
                            <td>{{$i++}}</td>
                            <td>{{$unit->name}}</td>
                            <td>{{ucfirst($unit->type)}}</td>
                            <td>{{status($unit->status)}}</td>
                            @can('inventory-settings-update')
                            <td>
                                <!-- edit section -->
                                <a href="ui_modal_notification.html#modal-dialog{{$unit->id}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <!-- #modal-dialog -->
                                <div class="modal fade" id="modal-dialog{{$unit->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{route('inventory-units.update', $unit->id)}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Edit Unit</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="small_unit_name">Unit Name * :</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input class="form-control" type="text" id="small_unit_name" name="name" value="{{$unit->name}}" data-parsley-required="true" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="small_unit_name">Unit Name * :</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <select name="type" class="form-control" id="">
                                                                <option value="retail" {{$unit->type=='retail' ? 'selected' : ''}}>Retail</option>
                                                                <option value="wholesale" {{$unit->type=='wholesale' ? 'selected' : ''}}>Wholesale</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                        <div class="col-md-3 col-sm-3">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" {{$unit->status ? 'checked' : ''}}> Active
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" id="radio-required2" value="0" {{$unit->status ? '' : 'checked'}}> Inactive
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
                                <!-- delete section -->
                                <form method="POST" class="del-btn" action="{{route('inventory-units.destroy', $unit->id)}}" accept-charset="UTF-8">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirmDelete();" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <!-- delete section end -->
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
@endsection
