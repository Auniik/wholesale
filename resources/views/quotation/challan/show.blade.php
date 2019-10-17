@extends('layout.app')
@section('title', 'Challan')
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
                        <a href="/quotations/{{$quotation->id}}/challans/create" class="btn
                        btn-sm
                        btn-success">Create New</a>
                    @endcan
                    @can('pharmacy-purchase-list')
                        <a href="/quotations" class="btn btn-sm btn-success">All Quotations</a>
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
                    border-radius: 10px;color: #000;border:1px solid #ddd;">CHALLAN</b>
                        <br>

                    </h6><hr>
                    <div class="customerInfo" style="width: 50%;float: left;">
                        <h5><b><u>Party's Information : </u></b></h5>
                        <p class="patient"><b>ID : </b> {{ $quotation->party->id }}</p>
                        <p class="patient"><b>Name : </b> {{$quotation->party->name  }}</p>
                        <p class="patient"><b>Contact Person Name : </b> {{ $quotation->party->contact_person_name }}
                        <p class="patient"><b>Mobile Number : </b> {{ $quotation->party->mobile_number }}</p>
                    </div>
                    <div class="invoiceInfo" style="width: 50%; float: left;margin-top: 5px;">
                        <table class="table table-bordered">
                            <tr>
                                <td> Invoice ID : </td>
                                <td>{!! $challan->invoice_id !!}</td>
                            </tr>
                            <tr>
                                <td> Quotation Date : </td>
                                <td>{{ $challan->date->format('d-m-Y') }}</td>
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
                            <th width="25%">DESCRIPTION OF GOODS</th>
                            <th>Quantity</th>
                            <th>UOM</th>
                            <th>Condition</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($challan->items as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td >
                                    <strong>{{$item->quotationItem->product->name}}</strong>
                                    <p><small>Product Code: {{$item->productCode->name}}</small></p>
                                </td>
                                <td>{{$item->quantity}}</td>
                                <td>Nos</td>
                                <td>GOOD</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="print-footer" style="margin-top: 40px;overflow: hidden;width: 100%;padding: 0 10px;">
                <div class="sign" style="width: 100%; overflow: hidden;">
                    <div class="company_sign" style="width: 33%; float: left;">
                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">&nbsp;</h5>
                        <h5 style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 10px 0;text-align: center;">Received By</h5>
                    </div>
                    <div class="company_sign" style="width: 33%; float: left;">
                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">{{$quotation->createdBy->name}}</h5>
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

    <script src="{{url('custom_js/printThis.js')}}"></script>
    <script type="text/javascript">

        function printPage(id) {
            $('#' + id).printThis({
                importStyle: true
            });
        };
        // window.onload = $('#print_body').printThis({
        //     importStyle: true
        // });


    </script>

@endsection
