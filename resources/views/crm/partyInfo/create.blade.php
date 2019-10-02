@extends('layout.app')
@section('content')
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-btn pull-right">
                    <a class="btn btn-info btn-sm" href="{{route('parties.index')}}">All Vendor / Suppliers</a>
                </div>
                <h4 class="panel-title">Add New Vendor / Supplier</h4>
            </div>

            <div class="panel-body">
                <form method="POST" action="{{route('parties.store')}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-3" for="party_name">Vendor / Supplier Name * :</label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" autofocus type="text" id="party_name" name="name" placeholder="Vendor / Supplier Name" data-parsley-required="true" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-3" for="telephone">Telephone No. :</label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" id="telephone" name="telephone" placeholder="Telephone No." autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-3" for="mobile_number">Mobile No. :</label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" id="mobile_number" name="mobile_number" placeholder="Mobile No."  autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-3" for="email">Email :</label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" id="email" name="email" placeholder="Email" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-3" for="address">Address :</label>
                        <div class="col-md-6 col-sm-6">
                            <textarea class="form-control" rows="5" id="address" name="address"
                                      placeholder="Address"></textarea><hr>
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
                                           placeholder="Contact Person Name" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3"
                                       for="contact_person_designation">Designation</label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input class="form-control" type="text" name="contact_person_designation"
                                           placeholder="Designation" autocomplete="off">
                                </div>
                                <label class="control-label col-sm-1 col-sm-1" for="contact_person_department">Department </label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input class="form-control" type="text" name="contact_person_department"
                                           placeholder="Department" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3"
                                       for="contact_person_telephone">Telephone</label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input class="form-control" type="text" name="contact_person_telephone"
                                           placeholder="Telephone No." autocomplete="off">
                                </div>
                                <label class="control-label col-sm-1 col-sm-1" for="contact_person_mobile">Mobile
                                </label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input class="form-control" type="text" name="contact_person_mobile"
                                           placeholder="Mobile No." autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3"> Status *:</label>
                        <div class="col-md-1 col-sm-1">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" value="1" tabindex="-1" id="radio-required" checked /> Active
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status"  value="0" tabindex="-1" id="radio-required2"/> Inactive
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