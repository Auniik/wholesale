@extends('layout.app')
@section('content')
<!-- begin #content -->

<div id="content" class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('task-list')
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href="{{url('/tasks')}}">Tasks</a>
                    </div>
                    @endcan
                    <h4 class="panel-title"><!-- <i class="fa fa-angellist"></i>  -->&nbsp;Task </h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{route('tasks.store')}}" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-3" for="description">Task Name :</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" name="name" placeholder="Task Name" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="date">Date :</label>
                            <div class="col-md-5">
                                <input class="form-control datepicker" type="text" name="date" value="<?php echo date('d-m-Y'); ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="description">Description :</label>
                            <div class="col-md-5">
                                <textarea class="form-control" rows="10" name="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3"></label>
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary col-md-12 pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                     <!-- #modal-dialog -->
                </div>
                <!--  -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->
@endsection
@section('script')
{{--<script>--}}
    {{--$('.datepicker').datepicker({--}}
        {{--dateFormat: "yy-mm-dd",--}}
        {{--autoClose: true,--}}
        {{--changeMonth: true,--}}
        {{--changeYear: true,--}}
    {{--});--}}
{{--</script>--}}
@endsection
