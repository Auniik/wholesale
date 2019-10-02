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
    @inject(request, Illuminate\Http\Request)
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
                        <h5 class="panel-title text-left"> Petty Cash Report </h5>
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
                                    <h6 style="width: 100%;text-align: center;margin-top: 15px;"><b style="padding: 10px 20px;border-radius: 10px;color: #000;border:1px solid #ddd;">Petty Cash Report</b></h6>
                                    <br>
                                </div>
                                <div class="row search-report">
                                    <form method="get">
                                        <div class="form-group col-md-3">
                                            <label class="control-label col-md-12" for="Date">Start Date :</label>
                                            <div class="col-md-12">
                                                <input class="form-control datepicker" autocomplete="off"
                                                       placeholder="Start Date" value="{{$request->get('from', date
                                                       ('d-m-Y'))}}" required name="from" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label class="control-label col-md-12" for="Date">&nbsp;</label>
                                            <div class="col-md-12">
                                                <input class="form-control" value="TO" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-md-offset-2">
                                            <label class="control-label col-md-12" for="Date">End Date :</label>
                                            <div class="col-md-12">
                                                <input class="form-control datepicker" autocomplete="off"
                                                       placeholder="End Date" value="{{$request->get('to', date
                                                       ('d-m-Y'))}}" required name="to" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="col-md-12 no-padding" for="">&nbsp;</label>
                                            <div class="col-sm-12 no-padding">
                                                <button type="submit" class="btn btn-warning col-md-12">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Voucher ID</td>
                                        <td align="right">Amount</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pettyCashVouchers as $pettyCashVoucher)
                                        <tr>
                                            <td>#</td>
                                            <td><a href="/petty-cash-vouchers/{{$pettyCashVoucher->id}}">{{$pettyCashVoucher->id}}</a></td>
                                            <td align="right">{{number_format($pettyCashVoucher->amount, 2)}} TK</td>
                                        </tr>
                                    @endforeach



                                    <tr style="border-top: 2px solid #cecece">
                                        <td align="right" colspan="2">Total = </td>
                                        <td align="right">{{number_format($pettyCashVouchers->sum('amount'), 2)}} TK</td>
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
