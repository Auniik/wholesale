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
                                    <form method="POST" action="{{route('manufacturers.store')}}" class="form-horizontal">
                                        @csrf
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Set Manufacturer </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4">Name *:</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input type="text" class="form-control" name="name" autocomplete="off"
                                                           placeholder="Enter manufacturer Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                <div class="col-md-2 col-sm-2">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="status" value="1" id="radio-required"
                                                                   checked /> Active
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
                            <?php $sl = $manufacturers->firstItem(); ?>
                            @foreach($manufacturers as $manufacturer)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>{{$manufacturer->name}}</td>
                                    <td>
                                        {{status($manufacturer->status)}}
                                    </td>
                                    @can('inventory-settings-update')
                                    <td>
                                        <!-- edit section -->
                                        <a href="#modal-dialog{{$manufacturer->id}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <!-- #modal-dialog -->
                                        <div class="modal fade" id="modal-dialog{{$manufacturer->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="manufacturers/{{$manufacturer->id}}" method="post" class="form-horizontal">
                                                       @csrf
                                                        @method('patch')
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title">Edit Manufacturer</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4" for="name">Manufacturer Name * :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" id="name" name="name" value="{{$manufacturer->name}}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                                <div class="col-md-3 col-sm-3">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" {{$manufacturer->status ? 'checked' : ''}}> Active
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" id="radio-required2" value="0" {{!$manufacturer->status ? 'checked' : ''}}> Inactive
                                                                        </label>
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
                                        <!-- end edit section -->
                                    </td>
                                    @endcan
                                    @can('inventory-settings-delete')
                                        <td>
                                            <a href="{{route('manufacturers.destroy', $manufacturer->id)}}" class="btn
                                            btn-xs  btn-danger deletable">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$manufacturers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
