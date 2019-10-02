@extends('layout.app')
@section('content')
<style type="text/css">
    form{display: inline;}
    .form-group{width: 100%;height: auto; overflow: hidden;  margin: 5px;}
    .form-control{width: 100% !important;}
</style>
<!-- begin #content -->
<div id="content" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('account-settings-create')
                    <div class="panel-heading-btn pull-right">
                        <!-- add section -->
                        <a href="#addNewMethod" class="btn btn-sm btn-success" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true" ></i> Add New Payment Method</a>
                        <!-- #addNewMethod -->
                        <div class="modal fade" id="addNewMethod">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    {!! Form::open(array('route' => 'payment-methods.store','class'=>'form-horizontal','method'=>'POST')) !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title"> Add New Payment Method </h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4" for="account">Select account * :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <select class="form-control " name="fk_account_id">
                                                    @foreach($account_info as $accounts)
                                                        <option value="{{ $accounts->id }}">{{ $accounts->account_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4" for="payment_method_name">Payment method Name * :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="method_name" name="method_name" value="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4" for="description" >Description :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4">Status :</label>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="status" value="1" id="radio-required"  checked > Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="status" id="radio-required2" value="0" > Inactive
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                    {!! Form::close(); !!}
                                </div>
                            </div>
                        </div>
                        <!-- end add section -->
                    </div>
                    @endcan
                    <h4 class="panel-title">Payment Method</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">Sl</th>
                                <th>Account Name</th>
                                <th>Method Name</th>
                                <th>Description</th>
                                <th width="10%">Status</th>
                                <th width="8%" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; ?>
                        @foreach($allData as $method)
                        <?php $i++; ?>
                            <tr class="odd gradeX">
                                <td>{{$i}}</td>
                                <td>{{optional($method->getAccount)->account_name}}</td>
                                <td>{{$method->method_name}}</td>
                                <td>{{$method->description}}</td>
                                <td>{{status($method->status)}}</td>
                                <td>
                                    @can('account-settings-update')
                                <!-- edit section -->
                                    <a href="#modal-dialog<?php echo $method->id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i></a>
                                    <!-- #modal-dialog -->
                                    <div class="modal fade" id="modal-dialog<?php echo $method->id;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            {!! Form::open(array('route' => ['payment-methods.update',$method->id],'class'=>'form-horizontal author_form','method'=>'PUT','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Modal Dialog</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="account">Select account * :</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <select class="form-control " name="fk_account_id">
                                                                {{--<option value="{{ $method->fk_account_id }}"></option>--}}
                                                                @foreach($account_info as $accounts)
                                                                    <option value="{{ $accounts->id }}" {{$accounts->id == $method->fk_account_id ? 'selected' : ''}}>{{ $accounts->account_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="company_name"></label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input class="form-control" type="hidden" id="company_name" name="company_name" value="<?php echo $method->company_name; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="payment_method_name">Payment method Name * :</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input class="form-control" type="text" id="method_name" name="method_name" value="<?php echo $method->method_name; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4" for="description">Description :</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo $method->description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                        <div class="col-md-3 col-sm-3">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" value="1" id="radio-required" @if($method->status=="1"){{"checked"}}@endif> Active
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="status" id="radio-required2" value="0" @if($method->status=="0"){{"checked"}}@endif> Inactive
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                </div>
                                            {!! Form::close(); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end edit section -->
                                    @endcan
                                </td>


                                    <!-- delete section -->
                                <td>
                                    @can('account-settings-delete')
                                    {!! Form::open(array('route'=> ['payment-methods.destroy',$method->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$method->id")) !!}
                                        {{ Form::hidden('id',$method->id)}}
                                        <button type="button" onclick="return deleteConfirm('deleteForm{{$method->id}}');" class="btn btn-xs btn-danger">
                                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    {!! Form::close() !!}
                                    @endcan
                                    <!-- delete section end -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->

<script src="{{asset('plugins/jquery/jquery-1.9.1.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    App.init();
    TableManageResponsive.init();
});
</script>
@endsection
