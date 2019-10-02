@extends('layout.app')
@push('style')
    <style>
        .modal.in .modal-dialog {
            transform: translate(10%, 10%);
        }
    </style>
@endpush
@section('content')
    <!-- begin #content -->

    <div id="content" class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{--@can('sms-template-create')--}}
                        {{--<div class="panel-heading-btn pull-right">--}}
                            {{--<div class="create_button">--}}
                                {{--<a href="#modal-dialog" class="btn btn-sm btn-success" data-toggle="modal">Add New Template</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@endcan--}}
                        <h4 class="panel-title">SMS Template </h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{$template ? route('sms-template.update', $template->id) :
                        route('sms-template.store')}}" method="POST"
                              class="form
                        form-horizontal">
                            @csrf
                            {{$template ? method_field('PUT') : ''}}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Outdoor</label>
                                        <textarea name="outdoor" rows="6"
                                                  class="form-control">{{$template ? $template->outdoor : ''}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="control-label">Expense Report</label>
                                        <textarea name="daily_expense_report" rows="6"
                                                  class="form-control">{{$template ? $template->daily_expense_report :
                                                  ''}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">

                                            <button type="submit" class="btn btn-sm btn-success btn-block"
                                                   id="submit-form" >Update</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

@endsection


@section('script')
    {{--<script>--}}
        {{--$('form').submit(function (e) {--}}
            {{--e.preventDefault();--}}
            {{--$.ajax({--}}
                {{--method: 'POST',--}}
                {{--url: '{{route('sms-template.store')}}',--}}
                {{--data: $(this).serializeArray(),--}}
                {{--success: function(data){--}}
                    {{--if (data)  location.reload()--}}
                {{--}--}}
            {{--})--}}
        {{--});--}}
    {{--</script>--}}
@endsection