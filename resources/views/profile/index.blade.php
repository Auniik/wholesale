@extends('layout.app')
@section('content')
    @if($user->type == 0)
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <div class="pull-right" style="margin-top: 10px;">
                                <a class="btn btn-primary btn-xs" href="#modal-dialog" data-toggle="modal">Change Password</a>
                                <a class="btn btn-info btn-xs" href="{{URL::to('/employeeinfo/edit')}}">Edit</a>
                            </div>
                        </div>
                        <h4 class="panel-title">Employee Profile</h4>
                    </div>
                    <!-- <input type="text" style="border:0;border-color: #fff;outline: 0;height: 1px;color: #fff"> -->

                    <div class="panel-body">
                        <div id="printableArea">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-6 col-sm-8 col-xs-8 pull-left">
                                    <h3><span>{{ $user->name }}</span></h3>
                                    <span>Address : {!! $user->address !!}</span><br>
                                    <span>Mobile : {!! $user->phone !!}</span><br>
                                    <span>Email : {!! $user->email !!}</span><br>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <img src="{{asset($user->employees->emp_img)}}" alt="" style="border:1px solid #ddd; margin-top:10px; width:150px; height:150px; float:right">
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <h4 class="titlebg">Professional Information</h4><table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th class="thWidth"> Branch</th>
                                            <td>{!! optional($user->employees->brunchData)->brunch_name !!}</td>
                                            <th class="thWidth">Employee Type</th>
                                            <td> {!! optional($user->employees->employee_type)->name !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth"> Designation</th>
                                            <td> {!! optional($user->employees->designation)->name !!}</td>
                                            <th class="thWidth"> Working Shift</th>
                                            <td> N/A </td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth"> Grade</th>
                                            <td> {!! $user->employees->grade->name !!}</td>
                                            <th class="thWidth"> Joining Date</th>
                                            <td> {!! $user->employees->join_date !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth"> Bank Nmae</th>
                                            <td> {!! optional($user->employees->bankdata)->bank_name !!}</td>
                                            <th class="thWidth">Bank Account</th>
                                            <td> {!! optional($user->employees)->bank_account !!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h4 class="titlebg">Contact Information</h4><table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th class="thWidth">Mobile</th>
                                            <td> {!! $user->employees->phone !!}</td>
                                            <th class="thWidth">Email</th>
                                            <td> {!! $user->employees->email !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Mobile</th>
                                            <td> {!! $user->employees->previous_office_phone !!}</td>
                                            <th class="thWidth">Email</th>
                                            <td> {!! $user->employees->previous_office_email !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Present Address</th>
                                            <td> {!! $user->employees->present_address !!}</td>
                                            <th class="thWidth">Permanant Address</th>
                                            <td> {!! $user->employees->permene_address !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">FB URL</th>
                                            <td>N/A</td>
                                            <th class="thWidth"></th>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h4 class="titlebg">Personal Information</h4><table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th class="thWidth"> Name</th>
                                            <td>{!! $user->name !!}</td>
                                            <th class="thWidth">ID</th>
                                            <td> {!! $user->employees->id_card !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth"> Finger Id</th>
                                            <td>{!! $user->employees->finger_id !!}</td>
                                            <th class="thWidth">Device ID</th>
                                            <td> {!! $user->employees->device_id !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Father's Name</th>
                                            <td> {!! $user->employees->father_name !!}</td>
                                            <th class="thWidth"> Mother's Name</th>
                                            <td> {!! $user->employees->mother_name !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Date of Birth</th>
                                            <td> {!! $user->employees->date_of_birth !!}</td>
                                            <th class="thWidth"> Blood Group</th>
                                            <td> {!! $user->employees->blood->name !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth"> Maritial Status</th>
                                            <td>
                                                @if($user->employees->marital_status == 1)
                                                    Married
                                                @else
                                                    Unmarried
                                                @endif
                                            </td>
                                            <th class="thWidth"> Religion</th>
                                            <td> {!! $user->employees->religion->name !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Spouse Name</th>
                                            <td> {!! $user->employees->spouse_name !!}</td>
                                            <th class="thWidth">No of Child</th>
                                            <td> {!! $user->employees->child !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Nationality</th>
                                            <td> {!! $user->employees->nationality !!}</td>
                                            <th class="thWidth">National ID</th>
                                            <td>{!! $user->employees->nid !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Birth Certificate</th>
                                            <td> {!! $user->employees->birth_certificate !!}</td>
                                            <th class="thWidth">Passport NO.</th>
                                            <td> {!! $user->employees->passport !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="thWidth">Driving License</th>
                                            <td> {!! $user->employees->driving_license !!}</td>
                                            <th class="thWidth"></th>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- qualification section-->
                                    <h4 class="titlebg">Educational Qualification</h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th class="text-center">Institute Name</th>
                                            <th class="text-center">Name of The Degree</th>
                                            <th class="text-center">Result</th>
                                            <th class="text-center">Major Subject</th>
                                            <th class="text-center">Year</th>
                                        </tr>
                                        @foreach($education as $edu)
                                            <tr>
                                                <td class="text-center">{!! $edu->institute_name !!}</td>
                                                <td class="text-center">{!! $edu->degree_name !!}</td>
                                                <td class="text-center">{!! $edu->result !!}</td>
                                                <td class="text-center">{!! $edu->major !!}</td>
                                                <td class="text-center">{!! $edu->year !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!-- qualification section-->
                                    <h4 class="titlebg">Training</h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th class="text-center">Institute Name</th>
                                            <th class="text-center">Name of The Training</th>
                                            <th class="text-center">Subject</th>
                                            <th class="text-center">Duration</th>
                                            <th class="text-center">Year</th>
                                        </tr>
                                        @foreach($tranings as $traning)
                                            <tr>
                                                <td class="text-center">{!! $traning->train_instit_name !!}</td>
                                                <td class="text-center">{!! $traning->traning_name !!}</td>
                                                <td class="text-center">{!! $traning->subject !!}</td>
                                                <td class="text-center">{!! $traning->duretion !!}</td>
                                                <td class="text-center">{!! $traning->year !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default page-panel">
                <div class="panel-heading">
                    <div class="panel-btn">
                    <a class="btn btn-primary btn-xs" href="#modal-dialog" data-toggle="modal">Change Password</a>
                        <a href="" class="btn btn-success btn-xs"> <i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </div>
                    <h4>Profile Update</h4>
                </div>
                {!! Form::open(['url'=>'profile','method'=>'POST','role'=>'form','data-toggle'=>'validator','class'=>'form-horizontal','files'=>'true'])  !!}
                <div class="panel-body">
                    <div class="col-md-9">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">Name:</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Your Name" required name="name" type="text" value="{{auth()->user()->name}}" id="name">
                                @if($errors->has('name'))<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>@endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">Email:</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Email" required name="email" type="email" value="{{auth()->user()->email}}" id="email">
                                @if($errors->has('name'))<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>@endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }} ">
                            <label for="address" class="col-md-3 control-label">Address:</label>
                            <div class="col-md-9">
                                <textarea class="form-control" placeholder="Address" rows="2" name="address" cols="50" id="address">{{auth()->user()->address}}</textarea>
                            </div>
                        </div>

                        {{--<div class="form-group {{ $errors->has('about') ? 'has-error' : '' }}">--}}
                            {{--<label for="about" class="col-md-2 control-label">About yourself:</label>--}}
                            {{--<div class="col-md-10">--}}
                                {{--<textarea class="form-control" placeholder="Write about yourself here.." rows="4" name="about" cols="50" id="about"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> &nbsp;Save</button>
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-md-3">--}}
                        {{--<div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<label class="post_upload" for="file">--}}
                                    {{--<img id="image_load" alt="No Image Selected" src="{{asset('images/default/photo.png')}}">--}}
                                {{--</label>--}}
                                {{--<input id="file" style="display:none" name="photo" type="file" accept="image/*" required>--}}
                                {{--@if ($errors->has('photo'))--}}
                                    {{--<span class="help-block" style="display:block">--}}
                                        {{--<strong>{{ $errors->first('photo') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                            {{--{{Form::label('photo', 'Profile Picture', array('class' => 'col-md-12'))}}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                {{Form::close()}}
            </div>
            <!-- /.panel -->
        </div>
    </div>
    @endif


    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('url' => 'profile-pass','class'=>'form-horizontal author_form','method'=>'POST','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4">Old Password *:</label>
                        <div class="col-md-8 col-sm-8">
                            <input type="password" class="form-control" name="old_password"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4">New Password *:</label>
                        <div class="col-md-8 col-sm-8">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4">Re Enter Password *:</label>
                        <div class="col-md-8 col-sm-8">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>
@endsection