@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info page-panel">
                <div class="panel-heading">
                    Add New Terms &amp; Condition
                    <div class="panel-btn pull-right">
                        <a href="{{URL::to('terms-condition')}}" class="btn btn-success btn-sm"> <i class="fa fa-asterisk"></i>  View All</a>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('route' => 'terms-condition.store','class'=>'form-horizontal','files'=>true)) !!}
                    <div class="form-group  {{ $errors->has('link') ? 'has-error' : '' }}">

                        {{Form::label('link', 'Link :', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-addon">{{URL::to('terms-condition')}}/</div>
                                {{Form::text('link','',array('class'=>'form-control','placeholder'=>'link','required'))}}
                            </div>
                            @if ($errors->has('link'))
                                <span class="help-block">
                        <strong>{{ $errors->first('link') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('name', 'Title :', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-9">
                            {{Form::text('title','',array('class'=>'form-control','placeholder'=>'Title','required'))}}
                        </div>
                    </div>


                    <div class="form-group">
                        {{Form::label('description', 'Description :', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-9">
                            {{Form::textArea('description','',array('class'=>'form-control tinymce ','placeholder'=>'Write some thing about page','rows'=>'15'))}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('status', 'Status', array('class' => 'col-md-2 control-label'))}}
                        <div class="col-md-2">
                            {{Form::select('status', array('1' => 'Active', '2' => 'Inactive'),'1', ['class' => 'form-control'])}}
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection

