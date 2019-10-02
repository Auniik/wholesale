@extends('layout.app')
@section('content')
<div id="content" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('inventory-settings-create')
                    <div class="panel-heading-btn pull-right">
                        <div class="create_button">
                            <a href="#modal-dialog" class="btn btn-sm btn-success " data-toggle="modal">Add New Manufacturer</a>
                        </div>
                    </div>
                    @endcan
                    <h4 class="panel-title">Manufacturers </h4>
                </div>
                <div class="panel-body">
                    @can('inventory-settings-create')
                    <!-- #modal-dialog -->
                    <div class="modal fade" id="modal-dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {!! Form::open(array('route' => 'inventory-brands.store','class'=>'form-horizontal author_form','method'=>'POST','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Add Manufacturer</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Status :</label>
                                        <div class="col-md-2 col-sm-2">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" checked /> Active
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
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4">Name *:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="name" value="" placeholder="Enter Manufacturer Name">
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
                                <th width="5%">Sl</th>
                                <th>Manufacturer Name</th>
                                <th width="10%"> Status</th>
                                <th width="5%" colspan="2" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = $brands->firstItem(); ?>
                            @foreach($brands as $brand)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>{{$brand->name}}</td>
                                    <td>
                                        {{status($brand->status)}}
                                    </td>
                                    @can('inventory-settings-update')
                                    <td>
                                        <!-- edit section -->
                                        <a href="#modal-dialog{{$brand->id}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <!-- #modal-dialog -->
                                        <div class="modal fade" id="modal-dialog{{$brand->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    {!! Form::open(array('route' => ['inventory-brands.update', $brand->id],'class'=>'form-horizontal author_form','method'=>'PUT','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Edit Manufacturer</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4" for="name">Manufacturer Name * :</label>
                                                            <div class="col-md-8 col-sm-8">
                                                                <input class="form-control" type="text" id="name" name="name" value="{{$brand->name}}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                            <div class="col-md-3 col-sm-3">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" {{$brand->status ? 'checked' : ''}}> Active
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="status" id="radio-required2" value="0" {{!$brand->status ? 'checked' : ''}}> Inactive
                                                                    </label>
                                                                </div>
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
                                    </td>
                                    @endcan
                                    @can('inventory-settings-delete')
                                    <td>
                                        <!-- delete section -->
                                        {!! Form::open(array('route'=> ['inventory-brands.destroy',$brand->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$brand->id")) !!}
                                        {{ Form::hidden('id',$brand->id)}}
                                        <button type="button" onclick="return deleteConfirm('deleteForm{{$brand->id}}');" class="btn-xs btn btn-danger">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    {!! Form::close() !!}
                                    <!-- delete section end -->
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$brands->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
