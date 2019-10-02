	@extends('layout.app')
		@section('content')
        <style type="text/css">
            form{display: inline;}
            .form-group{width: 100%;height: auto; overflow: hidden; margin: 5px;}
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
                                <!-- Add new account -->
                                <a href="#addNewAccount" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add New account</a>
                                <!-- #addNewAccount -->
                                <div class="modal fade" id="addNewAccount">
                                    <div class="modal-dialog modal-top">
                                        <div class="modal-content modal-top">
                                            {!! Form::open(array('route' =>'accounts.store','class'=>'form-horizontal','method'=>'POST')) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title"> Add New account</h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4" for="account_no">Account No * :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="text" id="account_no" name="account_no" value="{{old('account_no')}}"  autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4" for="account_name">Account Name * :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="text" id="account_name" name="account_name" value=""  autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4" for="current_balance">Opening Balance * :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="number" id="opening_balance" name="opening_balance" value=""  autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4" for="branch-name">Branch Name :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="text" id="branch-name" name="branch_name" value=""  autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="form-group invisible" display="none">
                                                    <label class="control-label col-md-4 col-sm-4" for="current_balance">Current Balance * :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="hidden" id="current_balance" name="current_balance" value=""  />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4">Status :</label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" value="1" id="radio-required" checked> Active
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
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-4"> </label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="confirm-default"  name="default_status" value="1"> Make This Account Default.
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
                                <!-- end edit section -->
                            </div>
                            @endcan
                            <h4 class="panel-title">All Accounts</h4>
                        </div>
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">Sl</th>
                                        <th>Account Name / Bank Name</th>
                                        <th>Start Balance</th>
                                        <th width="10%">Status</th>
                                        <th colspan="2" width="8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
//                                    $sl = $accounts->firstItem();
                                ?>

                                @foreach($accounts as $key => $account)
                                    @php($key++)

                                    <tr class="odd gradeX">
                                        <td class="text-center">
                                        {!!$account->default_status ? "<span class='badge badge-teals' title='This account is default account.'> $key </span>" : $key !!}</td>
                                        <td>{{$account->account_name}}</td>
                                        <td>{{number_format($account->current_balance, 2)}}</td>
                                        <td>{{status($account->status)}}</td>
                                        <td>
                                            @can('account-settings-update')
                                        <!-- edit section -->
                                            <a href="#modal-dialog<?php echo $account->id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <!-- #modal-dialog -->
                                            <div class="modal fade" id="modal-dialog{{$account->id}}">
                                                <div class="modal-dialog modal-top">
                                                    <div class="modal-content">
                                                    {!! Form::open(array('route' => ['accounts.update',$account->id],'class'=>'form-horizontal author_form','method'=>'PUT','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title">Edit Account</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4" for="account_no">Account No * :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" id="account_no" name="account_no" value="{{$account->account_no}}"  autocomplete="off"/>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4" for="account_name">Account Name * :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" id="account_name" name="account_name" value="{{$account->account_name}}" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4">Starting Balance * :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" readonly value="{{number_format($account->current_balance, 2)}}" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4" for="branch-name">Branch Name :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input class="form-control" type="text" id="branch-name" name="branch_name" value="{{ $account->branch_name }}" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4">Account Status :</label>
                                                                <div class="col-md-3 col-sm-3">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" value="1" id="radio-required"  @if($account->status){{"checked"}}@endif> Active
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" id="radio-required2" value="0" @if(!$account->status){{"checked"}}@endif> Inactive
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4 col-sm-4"> </label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" class="confirm-default" name="default_status" value="1" {{$account->default_status ? 'checked' : ''}}> Make This Account Default.
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
                                        <td>
                                            @can('account-settings-delete')
                                            <!-- delete section -->
                                            {!! Form::open(array('route'=> ['accounts.destroy', $account->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$account->id")) !!}
                                            {{ Form::hidden('id',$account->id)}}
                                            <button type="button" onclick="return deleteConfirm('deleteForm{{$account->id}}');" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                            {!! Form::close() !!}
                                            <!-- delete section end -->
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$accounts->links()}}
                        </div>
                    </div>
			    </div>
			</div>
		</div>
		<!-- end #content -->
    @endsection
@section('script')
    <script>
        $('.confirm-default').click(function () {
            if (confirm('Are You sure want to change this as default?')){
                return true;
            }
            return false;
        })
    </script>

@endsection
