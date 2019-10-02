@extends('layout.app')
@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn"></div>
                        <h4 class="panel-title">Send SMS </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tabbable-panel">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs ">
                                            <li class="active">
                                                <a href="#employeeSMS" data-toggle="tab">Employee SMS</a>
                                            </li>
                                            <li>
                                                <a href="#partySMS" data-toggle="tab">Client/Vendor SMS</a>
                                            </li>
                                            <li>
                                                <a href="#patientSMS" data-toggle="tab">Patient SMS</a>
                                            </li>
                                            <li>
                                                <a href="#groupSMS" data-toggle="tab">Group SMS</a>
                                            </li>
                                            <li>
                                                <a href="#manualSMS" data-toggle="tab">Manual SMS</a>
                                            </li>
                                            <li>
                                                <a href="#report" data-toggle="tab">Report</a>
                                            </li>
                                            <li>
                                                {{--<a href="#SMS" data-toggle="tab">Total SMS <span id="totalSMS">{{$sms_config ? decrypt($sms_config->sms_quantity) : 0}}</span></a>--}}
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="employeeSMS">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label style="line-height: 40px">Select Department</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="form-control" name="sms-group" id="department">
                                                                    <option value="">All Department</option>
                                                                    @foreach($departments as $department)
                                                                        <option value="{{  $department->id }}">{{ $department->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-success" type="submit" name="save" id="find">Find</button>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="employeeHere">

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="{{ url('send-sms') }}" method="post" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="col-md-6">
                                                                    <label>Numbers</label>
                                                                    <textarea class="form-control" name="numbers" id="empNumbers" rows="10"></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Message</label>
                                                                    <textarea onkeyup="countChar(this)" id="message" class="form-control" name="message" rows="10"></textarea>
                                                                    <p style="color: darkslateblue;">Total Character :  <span><b id="show">0</b>| Remaining : <b id="rem">640</b> | Total SMS : <b id="smsC">1</b> </span></p>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <button type="submit" name="save" value="Send Now" class="btn btn-sm btn-success float-right">Send Now</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane " id="partySMS">
                                                <div class="row" >
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label>Party Type</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" name="status" id="partyStatus">
                                                                    <option>Please select an option</option>
                                                                    <option value="1">All Customer</option>
                                                                    <option value="0">Inactive</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="row" id="partiesHere">

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="{{ url('send-sms') }}" method="post" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="col-md-6">
                                                                    <label>Numbers</label>
                                                                    <textarea class="form-control" name="numbers" id="partyNumbers" rows="10"></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Message</label>
                                                                    <textarea onkeyup="countSupplierMsg(this)"  class="form-control" name="message" rows="10" maxlength="640"></textarea>
                                                                    <p style="color: darkslateblue;">Total Character :  <span><b id="suppliershow">0</b>| Remaining : <b id="suplierrem">640</b> | Total SMS : <b id="suppliersmsC">1</b> </span></p>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <button type="submit" name="save" value="Send Now" class="btn btn-sm btn-success float-right">Send Now</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="patientSMS">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label style="line-height: 40px">Type</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="form-control" name="sms-group" id="patient-type">
                                                                    <option value="">Select Patient Type</option>
                                                                    <option value="self">Self</option>
                                                                    <option value="cardHolder">Card Holder Patients</option>
                                                                    <option value="corporate">Corporate Clients</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-1">
                                                                <label>Total SMS</label>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-warning btn-xs"><span id="totalSMS">{{$sms_config ? decrypt($sms_config->sms_quantity): 0}}</span></button>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="patientsHere">

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="{{ url('send-sms') }}" method="post" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="col-md-6">
                                                                    <label>Numbers</label>
                                                                    <textarea class="form-control" name="numbers" id="patientNumbers" rows="10"></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Message</label>
                                                                    <textarea onkeyup="countChar(this)" id="message" class="form-control" name="message" rows="10"></textarea>
                                                                    <p style="color: darkslateblue;">Total Character :  <span><b id="show">0</b>| Remaining : <b id="rem">640</b> | Total SMS : <b id="smsC">1</b> </span></p>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <button type="submit" name="save" value="Send Now" class="btn btn-sm btn-success float-right">Send Now</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <hr>
                                                        <div class="row">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane" id="groupSMS">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label style="line-height: 40px">Select Group</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" name="sms-group" id="groups">
                                                                    <option value="0">Select Group Name</option>
                                                                    @foreach($sms_groups as $sms_group)
                                                                        <option value="{{ $sms_group->id }}">{{ $sms_group->group_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-1">
                                                                <label>Total SMS</label>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-warning btn-xs"><span id="totalSMS">{{$sms_config ? decrypt($sms_config->sms_quantity): 0}}</span></button>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="{{ url('send-sms') }}" method="post" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="col-md-6">
                                                                    <label>Numbers</label>
                                                                    <textarea class="form-control" name="numbers" id="groupNumbers" rows="10"></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Message</label>
                                                                    <textarea onkeyup="countChar(this)" id="message" class="form-control" name="message" rows="10"></textarea>
                                                                    <p style="color: darkslateblue;">Total Character :  <span><b id="show">0</b>| Remaining : <b id="rem">640</b> | Total SMS : <b id="smsC">1</b> </span></p>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <button type="submit" name="save" value="Send Now" class="btn btn-sm btn-success float-right">Send Now</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <hr>
                                                        <div class="row">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="tab-pane" id="manualSMS">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-8"></div>
                                                            <div class="col-md-1">
                                                                <label>Total SMS</label>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-warning btn-xs"><span id="totalSMS">{{$sms_config ? decrypt($sms_config->sms_quantity): 0}}</span></button>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="{{ url('send-sms') }}" method="post" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="col-md-6">
                                                                    <label>Numbers</label>
                                                                    <textarea class="form-control" name="numbers" id="numbers" rows="10" ></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Message</label>
                                                                    <textarea onkeyup="countmsg(this)" id="message" class="form-control" name="message" rows="10" maxlength="160"></textarea>
                                                                    <p style="color: darkslateblue;">Total Character :  <span><b id="show2">0</b>| Remaining : <b id="rem2">640</b> | Total SMS : <b id="smsC2">1</b> </span></p>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <button type="submit" name="save" value="Send Now" class="btn btn-sm btn-success float-right">Send Now</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <hr>
                                                        <div class="row">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="report">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-8"></div>
                                                            <div class="col-md-1">
                                                                <label>Total SMS</label>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-warning btn-xs"><span id="totalSMS">{{$sms_config ? decrypt($sms_config->sms_quantity): 0}}</span></button>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <form action="{{ action('ReportSmsableNumberController@report')}}"
                                                                  method="post">
                                                                @csrf

                                                                <div class="col-md-6">
                                                                    <label>Numbers</label>
                                                                    <textarea class="form-control" name="numbers"
                                                                              id="numbers" rows="10"
                                                                    >{{optional($reportableNumbers)->numbers}}</textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Expense Report</label>
                                                                    <textarea onkeyup="countmsg(this)" id="message"
                                                                              class="form-control" name="message"
                                                                              rows="10" readonly
                                                                              maxlength="160">{{optional($template)->expenseSmsTemplate(company_id())}}</textarea>
                                                                    <p style="color: darkslateblue;">Total Character :  <span><b id="show2">0</b>| Remaining : <b id="rem2">640</b> | Total SMS : <b id="smsC2">1</b> </span></p>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <button type="submit" name="save" class="btn
                                                                    btn-sm btn-success float-right">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <hr>
                                                        <div class="row">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ url('custom_js/sms.js') }}"></script>
    <script>
//        getting group Numbers
        $(document).on('change', "#groups", function () {
            let url = "{{ url('get-group-numbers') }}/" + $(this).val();
            $.get(url, function(data){
                $('#groupNumbers').val(data);
            });
        });

        //        getting Patient Numbers
        $(document).on('change', "#patient-type", function () {
            $.ajax({
                url: "{{ url('get-smsable-patient-type') }}?type=" + $(this).val(),
                dataType: 'HTML',
            }).done(function(data) {
                $("#patientsHere").html(data);
            });

        });
        //Joining Parties
        $(document).on('change', '.patient-phones', function () {
            let numbers = [];
            $('.patient-phones:checked').each(function(){
                numbers.push($(this).val());
            });
            $('#patientNumbers').val(numbers.join(','));
        });



//        getting employee
        $(document).on("click", "#find", function(){
            let department_id = $("#department").val();
            $.ajax({
                url : '{{ url('get-employee') }}',
                data: { department_id },
                dataType : 'HTML',
            }).done(function (data) {
                $("#employeeHere").html(data);
            });
        });
        //getting employee numbers
        $(document).on('change', '.employee-phones', function () {
            let numbers = [];
            $('.employee-phones:checked').each(function(){
                numbers.push($(this).val());
            });
            $('#empNumbers').val(numbers.join(','));
        });


//      getting Parties
        $(document).on('change','#partyStatus',function(){
            let status = $(this).val();
            $.ajax({
                url: "{{ url('get-smsable-parties') }}",
                dataType:'HTML',
                data: { status }
            }).done(function(data){
                $("#partiesHere").html(data);
            });
        });
        //Joining Parties
        $(document).on('change', '.party-phones', function () {
            let numbers = [];
            $('.party-phones:checked').each(function(){
                numbers.push($(this).val());
            });
            $('#partyNumbers').val(numbers.join(','));
        });



//      checking all element
        $(document).on('click','.checkAll',function(){
            if(this.checked != false){
                $('.allcheck').prop('checked',true).change();
            }else{
                $('.allcheck').prop('checked',false).change();
            }
        });
    </script>
@endsection
