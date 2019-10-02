@extends('layout.app')
@push('style')
    <style>
        .permission-rows{
            display:inline-block;
            /*width: 200px;*/
            /*padding: 5px 5px/;*/
            /*border-right: 1px solid;*/
        }
        .permission-group{
            padding: 2px !important;
        }
    </style>
@endpush
@section('content')

<div id="content" class="content min-form" style="min-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Set Permission to "{{$role->name}}"</h4>
                </div>
                <!-- <input type="text" style="border:0;border-color: #fff;outline: 0;height: 1px;color: #fff"> -->
                <div class="panel-body" id="tabArea">
                    <form  class="form-horizontal" id="save-permissions" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="data-table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="70%">Group Name</th>
                                        <th width="5%">Show Menu</th>
                                        <th width="5%">Create</th>
                                        <th width="5%">Read</th>
                                        <th width="5%">Update</th>
                                        <th width="5%">Delete</th>
                                        <th width="5%">View</th>
                                        <th colspan="2" width="5%" align="center">Approve</th>
                                    </tr>
                                    <tr>
                                        <th colspan="7"></th>
                                        <th>Confirm</th>
                                        <th>Approve</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($permissions as $key => $permission)
                                    <tr  class="parent-data">
                                        <td width="70%">{{$key}}</td>
                                        @foreach($permission as $k => $cols)
                                        <td width="5%" class="permission-group" align="center" title="{{$cols->permission_name}}">

                                            <li class="permission-rows" >
                                                @if($cols->name=='0')
                                                    <label ><input style="display: none" type="checkbox" class="select-permission" value="{{$cols->id}}" name="permissions[]"></label>
                                                @else
                                                    <label><input {!! in_array($cols->id, $selected_permissions) ? ' checked' : '' !!} type="checkbox" class="select-permission" value="{{$cols->id}}" name="permissions[]"></label>
                                                @endif
                                            </li>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                {{--</div>--}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        var rows = $('.select-permission');
        var url = 'permission-change'
        $('.select-permission').on('change', function(){
            $.ajax(url, {
                type: 'post',
                data: $('#save-permissions').serializeArray(),
            })
        })

    </script>
@stop

