@extends('layout.app')
@push('style')
    <style>
        @media print {
            .company-info h4 {
                font-weight: bold;
                margin-bottom: 0;
            }
            .company-info p {
                margin-bottom: 2px;
            }
            .hidden{
                display: block !important;
            }
            .search-report{
                display:none !important;
            }
        }
    </style>
@endpush
@section('content')
    <div id="content" class="content min-form">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <div class="pull-right">
                                <button onclick="printPage('print_body')" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</button>
                            </div>
                        </div>
                        <h5 class="panel-title text-left"> Cash Collection Report </h5>
                    </div>
                    <div class="panel-body" id="print_body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="print-header hidden">
                                    <div class="company-info text-center" >
                                        <h4>{{ $company->company_name }}</h4>
                                        <p>{{ $company->address }}</p>
                                        <p>{{ $company->mobile_no }}, {{ $company->email}}</p>
                                    </div>
                                    <h6 style="width: 100%;text-align: center;margin-top: 15px;"><b style="padding: 10px 20px;border-radius: 10px;color: #000;border:1px solid #ddd;">Cash Collection Report</b></h6>
                                    <br>
                                </div>

                                <div class="row search-report">
                                    <div class="col-md-12">
                                        <form method="get">
                                            <div class="form-group col-md-3">
                                                <label class="control-label" for="Date">Start Date :</label>
                                                <input class="form-control searchDate" autocomplete="off" placeholder="Date" value="{{ request('fromDate', date('Y-m-d')) }}" required name="fromDate" type="text">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="control-label"> &nbsp;</label>
                                                <input class="form-control text-center" type="text" value="TO" readonly="" >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label" for="Date">End Date :</label>
                                                <input class="form-control searchDate" autocomplete="off" placeholder="Date" value="{{request('toDate', date('Y-m-d'))}}" required name="toDate" type="text">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="control-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-warning col-md-12">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Collected By</td>
                                        <td>Service</td>
                                        {{--<td align="right">Receivable Amount</td>--}}
                                        <td align="right">Received</td>
                                        {{--<td align="right">Due</td>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($indoorCollections ?? [] as $collection)
                                            <tr>
                                                <td>#</td>
                                                <td>{{$collection->createdBy->name}}</td>
                                                <td>Indoor</td>
{{--                                                <td align="right">{{number_format($collection->amount, 2)}} TK</td>--}}
                                                <td align="right">{{number_format($collection->income, 2)}} TK</td>
{{--                                                <td align="right">{{number_format($collection->amount-$collection->income, 2)}} TK</td>--}}
                                            </tr>
                                        @endforeach

                                        @foreach($serviceSaleCollections ?? [] as $collection)
                                        <tr>
                                            <td>#</td>
                                            <td>{{$collection->createdBy->name}}</td>
                                            <td>Medical Service</td>
{{--                                            <td align="right">{{number_format($collection->amount, 2)}} TK</td>--}}
                                            <td align="right">{{number_format($collection->income, 2)}} TK</td>
{{--                                            <td align="right">{{number_format($collection->amount-$collection->income, 2)}} TK</td>--}}
                                        </tr>
                                        @endforeach

                                        @foreach($appointmentCollections ?? [] as $collection)
                                            <tr>
                                                <td>#</td>
                                                <td>{{$collection->createdBy->name}}</td>
                                                <td>Outdoor Appointment</td>
{{--                                                <td align="right">{{number_format($collection->amount, 2)}} TK</td>--}}
                                                <td align="right">{{number_format($collection->income, 2)}} TK</td>
{{--                                                <td align="right">{{number_format($collection->amount-$collection->income, 2)}} TK</td>--}}
                                            </tr>
                                        @endforeach

                                        @foreach($voucherCollections as $collection)
                                            <tr>
                                                <td>#</td>
                                                <td>{{$collection->createdBy->name}}</td>
                                                <td>Voucher</td>
{{--                                                <td align="right">{{number_format($collection->amount, 2)}} TK</td>--}}
                                                <td align="right">{{number_format($collection->income, 2)}} TK</td>
{{--                                                <td align="right">{{number_format($collection->amount-$collection->income, 2)}} TK</td>--}}
                                            </tr>
                                        @endforeach

                                    <tr style="border-top: 2px solid #cecece">
                                        <td align="right" colspan="3">Total = </td>
                                        {{--$totalAmount = $indoorCollections->sum('amount')+$appointmentCollections->sum('amount')+$serviceSaleCollections->sum('amount')+$voucherCollections->sum('amount');--}}
                                        @php
                                            $totalIncome = $indoorCollections->sum('income')+$appointmentCollections->sum('income')+$serviceSaleCollections->sum('income')+$voucherCollections->sum('income');
                                        @endphp
                                        {{--<td align="right">{{number_format($totalAmount, 2)}} TK</td>--}}
                                        <td align="right">{{number_format($totalIncome, 2)}} TK</td>
                                        {{--<td align="right">{{number_format($totalAmount-$totalIncome, 2)}} TK</td>--}}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script>
        $('.searchDate').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            changeMonth: true,
            changeYear: true,
        });
        // $(".searchDate").datepicker("setDate", new Date());
    </script>
@endsection
