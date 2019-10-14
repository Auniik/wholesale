@extends('layout.app')
@section('title', 'Indoor Patient Booking Details')
@push('style')
    {{--<link href="{{url('/')}}/css/tailwindcss.css" rel="stylesheet">--}}
    <style>
        #print_body {
            background-color: #fff;
            padding: 10px 20px;
            overflow: hidden;
        }
        .company-info {
            color: #000;
        }
        .company-info h3 {
            font-weight: bold;
            margin-bottom: 0;
        }
        .table{
            box-shadow: none !important;
        }
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: .4px solid #bfbcbc;
            padding: 4.5px;
        }
        .admitted {
            color: #0cb634;
        }
        .company-info p {
            margin-bottom: 2px;
        }
        .patient{
            margin: 3px;
        }
        th{
            background: #efefef;
            box-shadow: none;
        }
        @media print {
            .company-info h4 {
                font-weight: bold;
                margin-bottom: 0;
            }
            .company-info p {
                margin-bottom: 2px;
            }
        }
    </style>
@endpush
@section('content')
    <div class="invoice">
        <div class="panel panel-default" style="margin-bottom: 0px;">
            <div class="panel-heading no-print" style="height: 48px;">
                <div class="panel-heading-btn pull-right">
                    @can('pharmacy-purchase-create')
                    <a href="/products/purchases/create" class="btn btn-sm btn-success">Create New</a>
                    @endcan
                    @can('pharmacy-purchase-list')
                    <a href="/products/purchases" class="btn btn-sm btn-success">All Purchases</a>
                    @endcan
                    <button onclick="printPage('print_body')" class="btn btn-sm btn-success"><i class="fa
                    fa-print"></i> Print</button>
                </div>
            </div>

        </div>
        <div id="print_body" class="col-xs-12">
            <div id="customer_info" style="padding: 0 10px;">
                <div class="row">
                    <div class="company-info text-center">
                        <h4>{{ $company->company_name }}</h4>
                        <p>{{ $company->address }}</p>
                        <p>{{ $company->mobile_no }}, {{ $company->email}}</p>
                    </div>
                    <h6 style="width: 100%;text-align: center;margin-top: 15px;"><b style="padding: 10px 20px;
                    border-radius: 10px;color: #000;border:1px solid #ddd;">Purchase Invoice</b></h6><hr>
                    <div class="customerInfo" style="width: 50%;float: left;">
                        <h5><b><u>Manufacturer's Information : </u></b></h5>
{{--                        <p class="patient"><b>ID : </b> {{ $inventoryProductPurchase->manufacturer->name }}</p>--}}
                        <p class="patient"><b>Name : </b> {{$productPurchase->manufacturer->name  }}</p>
                        {{--<p class="patient"><b>Age : </b> {{ $inventoryProductPurchase->patient->age }} &nbsp; &nbsp; <b>Sex :</b> {{ sex($inventoryProductPurchase->patient->sex) }}</p>--}}
{{--                        <p class="patient"><b>Mobile : </b> {{ $inventoryProductPurchase->patient->mobile_number }}</p>--}}
                    </div>
                    <div class="invoiceInfo" style="width: 50%; float: left;margin-top: 5px;">
                        <table class="table table-bordered">
                            <tr>
                                <td> Invoice ID : </td>
                                <td>{{ str_pad($productPurchase->id, '3', 000, STR_PAD_LEFT)}}</td>
                            </tr>
                            <tr>
                                <td> Challan ID : </td>
                                <td>{!! $productPurchase->challan_id !!}</td>
                            </tr>
                            <tr>
                                <td> Purchase Date : </td>
                                <td>{{ $productPurchase->date->toDayDateTimeString() }}</td>
                            </tr>

                        </table>
                    </div>



                </div>
            </div>
            <br>
            <div class="invoice-content">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="1%">SL</th>
                            <th width="25%">Product Name</th>
                            <th>Product Code</th>
                            <th>Quantity</th>
                            <th>Unit TP</th>
                            <th>Sales Price</th>
                            <th width="15%" style="text-align:right">Total TP (&#x09F3;)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productPurchase->items as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td >{{$item->product->name}}</td>
                            <td >{{$item->productCode->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->unit_price}}</td>
                            <td>{{$item->sales_price}}</td>
                            <td align="right">{{ number_format($item->price , 2)}} &#x09F3;</td>
                        </tr>
                        @endforeach

                        <tr hidden>
                            <td colspan="6" style="text-align: right" >Discount =</td>
                            <th style="text-align: right">{{$productPurchase->discount}} &#x09F3;</th>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right">Total = </td>
                            <th style="text-align: right">{{number_format($productPurchase->totalAmount, 2)
                            }} &#x09F3;
                            </th>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right">Paid =</td>
                            <th style="text-align: right">{{number_format($productPurchase->paid ?
                            $productPurchase->paid :
                            $productPurchase->paid_amount, 2)}}
                                &#x09F3;</th>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right">Due =</td>
                            {{--                            <th style="text-align: right">{{number_format($patientBooking->due, 2)}} &#x09F3;</th>--}}
                            <th style="text-align: right">{{ number_format(($productPurchase->due), 2) }}
                                &#x09F3;</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Amount Paid : <span> {{MyHelper::taka($productPurchase->paid) . ''}}</span></h5>
                    </div>
                </div>
            </div>
            <div class="print-footer" style="margin-top: 40px;overflow: hidden;width: 100%;padding: 0 10px;">
                <div class="sign" style="width: 100%; overflow: hidden;">
                    <div class="company_sign" style="width: 33%; float: left;">
                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">&nbsp;</h5>
                        <h5 style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 10px 0;text-align: center;">Received By</h5>
                    </div>
                    <div class="company_sign" style="width: 33%; float: left;">
                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">{{$productPurchase->createdBy->name}}</h5>
                        <h5 style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 10px 0;text-align: center;">Prepared By</h5>
                    </div>

                    <div class="company_sign" style="width: 33%; float: left;">
                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">&nbsp;</h5>
                        <h5 style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 10px 0;text-align: center;">Authorized By</h5>
                    </div>
                </div>
                <div class="copyright" style="padding: 0px !important;">
                    <br>
                    <div class="copyright-section">
                        <p class="pull-left">NB: This is system  generated report.</p>
                        <p class="design_band pull-right">Powered By: <a href="#" > Smart Software Inc.</a></p>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <div id="second_copy"  style="width: 100%;overflow: hidden;">
            <!-- Load First Copy -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            changeMonth: true,
            changeYear: true
        });
        $('.datepicker').datepicker('setDate', new Date());
    </script>
    {{--//Select Ward--}}
    <script>
        $(function() {
            $('select#ward_id').change(function (e) {
                $.getJSON('{{url('/load-seats')}}',
                    {id: $(this).val()},
                    function (seats) {
                        $('select#seat_id').html(
                            $.map(seats, function (seat) {
                                return '<option value="'+seat.id+'">'+seat.space_location+'</option>';
                            }).join('')
                        ).trigger('change')
                    }
                )
            })
        })

        $(function() {
            $('select#seat_id').change(function (e) {
                $.getJSON('{{url('/load-price')}}',
                    {id: $(this).val()},
                    function (prices) {
                        prices.forEach(function (price) {
                            $('input#price').val(price.price)
                        })
                    }
                )
            })
        })
    </script>

    <script>
        $( "#patient_name" ).autocomplete({
            source: function(request, response){
                $.getJSON('{{url('/loadPatient')}}', {
                    name:$('#patient_name').val()
                }, function (data) {
                    response($.map(data, function (item) {
                        return{
                            value: item.name,
                            label: item.name,
                            data: item,
                        }
                    }))
                })
            },
            select: function(event, ui){
                $('#patient_id_no').val(ui.item.data.patient_id);
                $('#patient_age').val(ui.item.data.age);
                $('#mobile_no').val(ui.item.data.mobile_number);
                $('#disease').val(ui.item.data.disease);
                $('#patient_id').val(ui.item.data.id);
                $('#guardian').val(ui.item.data.guardian);
                $('#blood').val(ui.item.data.blood);
                // console.log(ui.item.data);
                $('[name=sex][value='+ui.item.data.sex+']').attr('checked', true);
                $('[name=blood][value='+ui.item.data.blood+']').attr('selected', true);
            },
        });
    </script>

    <script>
        $(document).ready(function () {
            {{--$.getJSON('{{url('loadBlood')}}', {--}}
            {{--        id: $('#blood').val()--}}
            {{--    }, function(data){--}}
            {{--        var HTML = '<option value="">Select One</option>';--}}
            {{--        data.forEach(function (blood) {--}}
            {{--            HTML += '<option value="'+blood.blood_id+'">'+blood.blood_group_name+'</option>';--}}

            {{--        });--}}
            {{--    $('#blood').html(HTML);--}}
            {{--    }--}}

            {{--)--}}
        })
    </script>
    <script src="{{url('custom_js/printThis.js')}}"></script>
    <script type="text/javascript">

        function printPage(id) {
            $('#' + id).printThis({
                importStyle: true
            });
        };
        window.onload = $('#print_body').printThis({
            importStyle: true
        });


    </script>

@endsection
