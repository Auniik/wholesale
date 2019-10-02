@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info page-panel">
                <div class="panel-heading">
                    Edit Terms &amp; Condition
                    <div class="panel-btn pull-right">
                        <a href="{{URL::to('terms-condition')}}" class="btn btn-success btn-sm"> <i class="fa fa-asterisk"></i>  View All</a>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('route' => ['terms-condition.update', $data->id],'method'=>'PUT','class'=>'form-horizontal','files'=>true)) !!}
                    <div class="form-group ">

                        {{Form::label('link', ' Link :', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-addon">{{URL::to('page')}}/</div>
                                {{Form::text('link',$data->link,array('class'=>'form-control','placeholder'=>' Link','required'))}}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('title', 'Title :', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-9">
                            {{Form::text('title',$data->title,array('class'=>'form-control','placeholder'=>'Title','required'))}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('description', 'Description :', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-9">
                            {{Form::textArea('description',$data->description,array('class'=>'form-control tinymce','placeholder'=>'Write some thing about terms and condition','rows'=>'15'))}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('status', 'Status', array('class' => 'col-md-2 control-label'))}}

                        <div class="col-md-2">
                            {{Form::select('status', array('1' => 'Active', '2' => 'Inactive'),$data->status, ['class' => 'form-control'])}}
                        </div>
                    </div>

                    {{Form::hidden('id',$data->id)}}
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection

