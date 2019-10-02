@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href="{{route('parties.index')}}">All Vendor / Supplier</a>
                    </div>
                    <h4 class="panel-title">Edit Vendor / Supplier</h4>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{route('parties.update', $party)}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-sm-3" for="party_name">Vendor / Supplier Name * :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" value="{{$party->name}}" name="name" placeholder="Party Name" data-parsley-required="true" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-sm-3" for="telephone">Telephone No. :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="telephone" value="{{optional($party)->telephone}}" name="telephone" placeholder="Telephone No." autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-sm-3" for="mobile_number">Mobile No. :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="mobile_number" value="{{optional($party)->mobile_number}}" name="mobile_number" placeholder="Mobile No."  autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-sm-3" for="email">Email :</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="email" name="email" value="{{optional($party)->email}}" placeholder="Email" autocomplete="off"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-3 col-sm-3" for="address">Address :</label>
                            <div class="col-md-6 col-sm-6">
                            <textarea class="form-control" rows="5" id="address" name="address"
                                      placeholder="Address">{{$party->address}}</textarea><hr>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="col-md-offset-2">Contact Person Information</h4>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-sm-3" for="address">Person Name :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <input class="form-control" type="text" name="contact_person_name"
                                               placeholder="Contact Person Name" value="{{optional($party)->contact_person_name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-sm-3"
                                           for="contact_person_designation">Designation</label>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input class="form-control" type="text" value="{{$party->contact_person_designation}}"
                                               name="contact_person_designation"
                                               placeholder="Designation">
                                    </div>
                                    <label class="control-label col-sm-1 col-sm-1" for="contact_person_department">Department </label>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input class="form-control" type="text" value="{{$party->contact_person_department}}"
                                               name="contact_person_department" placeholder="Department">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-sm-3"
                                           for="contact_person_telephone">Telephone</label>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input class="form-control" type="text" value="{{$party->contact_person_telephone}}"
                                               name="contact_person_telephone"
                                               placeholder="Telephone No.">
                                    </div>
                                    <label class="control-label col-sm-1 col-sm-1" for="contact_person_mobile">Mobile
                                    </label>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input class="form-control" type="text" value="{{$party->contact_person_mobile}}"
                                               name="contact_person_mobile"
                                               placeholder="Mobile No.">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3"> Status *:</label>
                            <div class="col-md-1 col-sm-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" value="1" {{$party->status ? 'checked' : ''}} id="radio-required" /> Active
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status"  value="0" {{!$party->status ? 'checked' : ''}}  id="radio-required2"/> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3"></label>
                            <div class="col-md-6 col-sm-6">
                                <button type="submit" class="btn btn-primary col-md-12">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection