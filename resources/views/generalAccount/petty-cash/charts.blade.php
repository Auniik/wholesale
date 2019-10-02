@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Petty Cash Charts</h4>
                </div>
                <div class="panel-body print_body">
                    <div class="box-body">
                        <form method="POST" action="{{route('petty-cash-charts.store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @can('indoor-settings-create')
                                <div class="form-group">
                                    <label for="ward" class="col-md-2 control-label">Chart of Accounts Name</label>
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="Charts Name" required name="name" type="text" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="status">
                                            <option value="1" selected="selected">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="btn btn-info" type="submit" value="Submit">
                                    </div>
                                </div>
                            @endcan
                        </form>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-hover table-bordered " id="my_table">
                            <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th>Name</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = $pettyCashChartOfAccounts->firstItem(); ?>
                            @foreach ($pettyCashChartOfAccounts as $pettyCashCharts)
                                <tr>
                                    <td class="text-center">{{$sl++}}</td>
                                    <td>{{$pettyCashCharts->name}}</td>
                                    <td class="text-center">
                                        {{status($pettyCashCharts->status)}}
                                    </td>
                                    <td class="text-center">
                                        {{--@can('indoor-settings-update')--}}
                                            <a href="ui_modal_notification.html#modal-dialog{{$pettyCashCharts->id}}" class="btn btn-info btn-xs" title="edit" data-toggle="modal"><i class="fa fa-pencil-square-o"></i></a>
                                        {{--@endcan--}}
                                        {{--@can('indoor-settings-delete')--}}
                                            <a href="{{route('hospital-wards.destroy', $pettyCashCharts->id)}}" class="btn btn-danger btn-xs deletable" title="delete" ><i class="fa fa-trash-o"></i></a>
                                        {{--@endcan--}}
                                        {{--</form>--}}
                                        {{--@can('indoor-settings-update')--}}
                                        <!-- #modal-dialog -->
                                            <div class="modal fade" id="modal-dialog{{$pettyCashCharts->id}}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{route('petty-cash-charts.update', $pettyCashCharts)}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title">Petty Cash Charts</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-4 col-sm-4">Name * :</label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input class="form-control" type="text" name="name" autocomplete="off" value="{{$pettyCashCharts->name}}" data-parsley-required="true" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <select class="form-control" name="status">
                                                                            <option value="1" {{$pettyCashCharts->status==1 ? 'selected' : ''}}>Active</option>
                                                                            <option value="0" {{$pettyCashCharts->status==0 ? 'selected' : ''}}>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="id" value="1">
                                                            <div class="modal-footer">
                                                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end edit section -->
                                        {{--@endcan--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{$pettyCashChartOfAccounts->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection