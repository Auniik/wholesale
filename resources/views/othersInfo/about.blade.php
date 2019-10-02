@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info page-panel">
                <div class="panel-heading">
                    Login Description
                    <div class="panel-btn pull-right">

                    </div>
                </div>

                {!! Form::open(array('route' =>['others-info.update', $data->id],'method'=>'PUT','class'=>'form-horizontal','files'=>true)) !!}
                <div class="panel-body">


                    <div class="form-group  {{ $errors->has('description') ? 'has-error' : '' }}">
                        {{Form::label('description', 'Login Description', array('class' => 'col-md-12'))}}
                        <div class="col-md-12">
                            {{Form::textArea('description',$data->description,array('class'=>'form-control tinymce','placeholder'=>'Login Description','rows'=>'10'))}}
                            @if ($errors->has('description'))
                                <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>



                    {{Form::hidden('id',$data->id)}}
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection

