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
                        <a href="ui_modal_notification.html#modal-dialog" class="btn btn-sm btn-success" data-toggle="modal">Add New Category</a>
                    </div>
                    @endcan
                </div>
                <h4 class="panel-title">Inventory Product Categories </h4>
            </div>
            <div class="panel-body">
                @can('inventory-settings-create')
                <!-- #modal-dialog -->
                <div class="modal fade" id="modal-dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{route('inventory-categories.store')}}" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Set Category</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Category Name *:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="  name" value="" placeholder="Enter category Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Category status :</label>
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
            <div class="view_category_set">
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                            <th width="5%">SL</th>
                            <th>Category Name</th>
                            <th class="text-center" width="10%">Status</th>
                            <th width="5%" class="text-center" colspan="2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($sl = $categories->firstItem())
                        @foreach($categories as $category)
                            <tr class="odd gradeX">
                            <td>{{$sl++}}</td>
                            <td>{{$category->name}}</td>
                            <td> {{status($category->status)}} </td>
                            @can('inventory-settings-update')
                            <td>
                                <!-- edit section -->
                                <a href="ui_modal_notification.html#modal-dialog{{$category->id}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <!-- #modal-dialog -->
                                <div class="modal fade" id="modal-dialog{{$category->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{route('inventory-categories.update', $category->id)}}" class="form-horizontal author_form">
                                                @csrf
                                                @method('patch')
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Modal Dialog</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="category_name">Category Name * :</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input class="form-control" type="text" id="category_name" name="name" value="{{$category->name}}" data-parsley-required="true" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                        <div class="col-md-3 col-sm-3">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" value="1" id="radio-required" {{$category->status==1 ? 'checked' : ''}}> Active
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" value="0" id="radio-required2" {{$category->status==0 ? 'checked' : ''}}> Inactive
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
                                <a href="{{route('inventory-categories.destroy', $category->id)}}" class="btn btn-xs btn-danger deletable">
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