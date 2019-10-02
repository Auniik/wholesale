@extends('layout.app')
@section('section')
@push('style')
    <style>
        td.rotate {
            height: 100px;
            width: 10px;
            transform: rotate(-90deg);
            /*vertical-align: center;*/
            text-align-last: center;
            text-align: center;
        }
        .patient{
            width: 30px;
        }
        .rotate-data {
            margin: 10px;
        }
        .patient-name{
            width: 20%;
        }
        .report-data{
            padding: 2px;
        }

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
        @page {
            size: landscape;
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
                        <h5 class="panel-title text-left"> Daily Cash Receive Report </h5>
                    </div>
                    <div class="panel-body" id="print_body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="print-header hidden">
                                    <div class="company-info text-center" >
                                        <h4>{{ $company->company_name }}</h4>
                                        <p>{{ $company->address }}, {{ $company->mobile_no }}, {{ $company->email}}</p>
                                    </div>
                                    <h4 style="width: 100%;text-align: center;"><b>Cash Collection Report</b></h4>
                                    <br>
                                </div>

                                <table border="1" width="100%" class="">
                                    <thead>
                                    <tr>
                                        <td class="rotate"><span class="rotate-data">#</span></td>
                                        <td class="rotate"><span class="rotate-data" style="width:5px;">Patient ID</span></td>
                                        <td class="patient"><span class="rotate-data">Patient Name</span></td>
                                        <td class="rotate"><span class="rotate-data">Outdoor Fee</span></td>
                                        <td class="rotate"><span class="rotate-data">Indoor Fee</span></td>
                                        <td class="rotate"><span class="rotate-data">Service Fee</span></td>
                                        {{--<td class="rotate"><span class="rotate-data">Subtotal</span></td>--}}
                                        @foreach($serviceCategories as $categories)
                                            <td class="rotate"><span class="rotate-data">{{$categories->name}}</span></td>
                                        @endforeach
                                        <td class="rotate"><span class="rotate-data">Total Amount</span></td>
                                        <td class="rotate"><span class="rotate-data">Advance Amount</span></td>
                                        <td class="rotate"><span class="rotate-data">Due</span></td>
                                        <td class="rotate"><span class="rotate-data">Net Amount Received</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($patients as $key => $patient)
                                        @php
                                            $outdoorAmount = $patient->todayOutdoor->sum('totalAmount');
                                            $indoorAmount = $patient->todayIndoor->sum('totalPrice') ;
                                            $serviceSalesAmount = $patient->todayServiceSales->sum('totalPrice');
                                            $totalAmount = $outdoorAmount + $indoorAmount + $serviceSalesAmount;
                                            $outdoorPaidAmount = $patient->todayOutdoor->sum('amount');
                                            $indoorPaidAmount = $patient->todayIndoor->sum('amount');
                                            $serviceSalesPaidAmount = $patient->todayServiceSales->sum('amount');
                                        @endphp
                                        @if ($totalAmount > 0)
                                            <tr>
                                                <td class="report-data text-center">{{++$key}}</td>
                                                <td class="report-data text-center">{{$patient->patient_id}}</td>
                                                <td class="report-data patient-name">{{$patient->name}}</td>
                                                <td class="report-data" align="right">{{number_format($outdoorAmount, 2)}}</td>
                                                <td class="report-data" align="right">{{number_format($indoorAmount, 2)}}</td>
                                                <td class="report-data" align="right">{{number_format($serviceSalesAmount, 2)}}</td>
                                                {{--<td class="report-data" align="right">{{number_format(0,2)}}</td>--}}
                                                @foreach($serviceCategories as $category)
                                                    <?php
                                                        $amount = $patient->todayPatientServices->firstWhere('category_id', $category->id);
                                                    ?>
                                                    <td class="report-data" align="right">{{ $amount->amount ?? 0}} </td>
                                                @endforeach
                                                <td class="report-data" align="right">{{number_format($totalAmount, 2)}}</td>
                                                <td class="report-data" align="right">{{number_format($totalPaid = $outdoorPaidAmount+$indoorPaidAmount+$serviceSalesPaidAmount, 2)}}</td>
                                                <td class="report-data" align="right">{{number_format($due = $totalAmount-$totalPaid, 2)}}</td>
                                                <td class="report-data" align="right">{{$due <= 0 ? 'Paid' : ''}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
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