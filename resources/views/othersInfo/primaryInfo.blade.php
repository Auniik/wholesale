@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info page-panel">
                <div class="panel-heading">
                    Primary Information
                    <div class="panel-btn pull-right">

                    </div>
                </div>

                {!! Form::open(array('route' =>['others-info.update', $data->id],'method'=>'PUT','class'=>'form-horizontal','files'=>true)) !!}
                <div class="panel-body">
                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                        {{Form::label('logo', 'Organization Logo', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            <label class="upload_photo upload client_logo_upload" for="file">
                                <!--  -->
                                <img src="{{asset($data->logo)}}" id="image_load">
                                <i class="upload_hover ion ion-ios-camera-outline"></i>
                            </label>
                            {{Form::file('logo',array('id'=>'file','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load")'))}}
                            @if ($errors->has('logo'))
                                <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('logo') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('favicon') ? 'has-error' : '' }}">
                        {{Form::label('favicon', 'Organization Icon', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            <label class="upload_photo upload client_favicon_upload" for="file2">
                                <!--  -->
                                <img src="{{asset($data->favicon)}}" id="image_load2">
                                <i class="upload_hover ion ion-ios-camera-outline"></i>
                            </label>
                            {{Form::file('favicon',array('id'=>'file2','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load2")'))}}
                            @if ($errors->has('favicon'))
                                <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('favicon') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{ $errors->has('company_name') ? 'has-error' : '' }}">
                        {{Form::label('company_name', 'Name of Organization', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::text('company_name',$data->company_name,array('class'=>'form-control','placeholder'=>'Name of Organization'))}}
                            @if ($errors->has('company_name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{ $errors->has('address') ? 'has-error' : '' }}">
                        {{Form::label('address', 'Organization Address', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::text('address',$data->address,array('class'=>'form-control','placeholder'=>'Organization Address'))}}
                            @if ($errors->has('address'))
                                <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                        {{Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::text('mobile_no',$data->mobile_no,array('class'=>'form-control','placeholder'=>'Contact Number'))}}
                            @if ($errors->has('mobile_no'))
                                <span class="help-block">
                            <strong>{{ $errors->first('mobile_no') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
                        {{Form::label('email', 'Email', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::email('email',$data->email,array('class'=>'form-control','placeholder'=>'Email'))}}
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{ $errors->has('fb_link') ? 'has-error' : '' }}">
                        {{Form::label('fb_link', 'Facebook Page', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::text('fb_link',$data->fb_link,array('class'=>'form-control','placeholder'=>'Facebook Page'))}}
                            @if ($errors->has('fb_link'))
                                <span class="help-block">
                            <strong>{{ $errors->first('fb_link') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{ $errors->has('web') ? 'has-error' : '' }}">
                        {{Form::label('web', 'Website', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::text('web',$data->web,array('class'=>'form-control','placeholder'=>'Website link'))}}
                            @if ($errors->has('web'))
                                <span class="help-block">
                            <strong>{{ $errors->first('web') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>



                    {{Form::hidden('id',$data->id)}}
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

