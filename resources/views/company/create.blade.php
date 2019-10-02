@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default page-panel">
            <div class="panel-heading">
                Hospital Information
                @can('company-list')
                <div class="panel-btn pull-right">
                    <a href="{{route('companies.index')}}" class="btn btn-success btn-sm" > <i class="fa fa-list"></i> View All</a>
                </div>
                @endcan
            </div>

            {!! Form::open(array('route' =>'companies.store','method'=>'POST','class'=>'form-horizontal','files'=>true)) !!}
            <div class="panel-body">
                <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                    {{Form::label('logo', 'Hospital Logo', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        <label class="upload_photo upload client_logo_upload" for="file">
                            <!--  -->
                            <img src="{{asset('images/default/photo.png')}}" id="image_load">
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
                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                    {{Form::label('company_name', 'Name of Hospital', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        {{Form::text('company_name','',array('class'=>'form-control','placeholder'=>'Name of Hospital'))}}
                        @if ($errors->has('company_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('company_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {{Form::label('address', 'Address', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        {{Form::text('address','',array('class'=>'form-control','placeholder'=>'Hospital Address'))}}
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                    {{Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        {{Form::text('mobile_no','',array('class'=>'form-control','placeholder'=>'Contact Number'))}}
                        @if ($errors->has('mobile_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('mobile_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{Form::label('email', 'Email', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        {{Form::email('email','',array('class'=>'form-control','placeholder'=>'Email'))}}
                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('fax') ? 'has-error' : '' }}">
                    {{Form::label('fax', 'Fax No.', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        {{Form::text('fax','',array('class'=>'form-control','placeholder'=>'fax'))}}
                        @if ($errors->has('fax'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fax') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('web') ? 'has-error' : '' }}">
                    {{Form::label('web', 'Website', array('class' => 'col-md-2 control-label'))}}
                    <div class="col-md-8">
                        {{Form::text('web','',array('class'=>'form-control','placeholder'=>'Website link'))}}
                        @if ($errors->has('web'))
                            <span class="help-block">
                        <strong>{{ $errors->first('web') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2">Status :</label>
                    <div class="col-md-1 col-sm-1">
                        <div class="radio">
                            <label>
                                <input type="radio" name="status"  value="1" id="radio-required" checked> Active
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1">
                        <div class="radio">
                            <label>
                                <input type="radio" name="status"  id="radio-required2" value="0" > Inactive
                            </label>
                        </div>
                    </div>
                </div>

                <br>
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary btn-block">Add Hospital</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>


@endsection