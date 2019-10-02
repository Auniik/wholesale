@extends('layout.app')
@section('section')
    @push('style')
        <style>
            .head-row{
                padding:5px;
                background: #f6f6f7;
            }
            .table{
                border: none;
                box-shadow: none;
            }
            td{
                padding: 2px 10px;
                border: 1px solid #d6d6d6;
            }
            th{
                padding: 2px 10px;
                border: 1px solid #b5b5b5;
                box-shadow: none;
                background: #eaeaea;
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
                        <h5 class="panel-title text-left"> Income Expanse Report </h5>
                    </div>
                    <div class="panel-body" id="print_body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="print-header hidden">
                                    <div class="company-info text-center" >
                                        <h4>{{ $company->company_name }}</h4>
                                        <p>{{ $company->address }}, {{ $company->mobile_no }}, {{ $company->email}}</p>
                                    </div>
                                    <h4 style="width: 100%;text-align: center;"><b>Income Expanse Report</b></h4>
                                    <br>
                                </div>

                                <div class="row search-report">
                                    <div class="col-md-12">
                                        <form method="get">
                                            <div class="form-group col-md-3">
                                                <label class="control-label col-md-12" for="service">Select Type:</label>
                                                <div class="col-md-12">
                                                    <select name="type" id="" class="form-control select">
                                                        <option value="">Select All</option>
                                                        <option value="income" {{request('type') == 'income' ? 'selected' : '' }}>Income</option>
                                                        <option value="expense" {{request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label" for="Date">Start Date :</label>
                                                <input class="form-control datepicker" autocomplete="off"
                                                       placeholder="Date"  value="{{ $request->get('from', date
                                                       ('d-m-Y')) }}"  required name="from" type="text">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="control-label"> &nbsp;</label>
                                                <input class="form-control text-center" type="text" value="TO" readonly="" >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label" for="Date">End Date :</label>
                                                <input class="form-control datepicker" autocomplete="off"
                                                       placeholder="Date"  value="{{$request->get('to', date
                                                       ('d-m-Y'))}}"  required name="to" type="text">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="control-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-warning col-md-12">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <table width="100%" {{request('type') == 'expense' ? 'hidden' : ''}}>
                                    <thead>
                                    <tr>
                                        <td colspan="3" class="text-center head-row"><h4><b>Income Report</b></h4></td>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Chart of Account</th>
                                        <th class="text-right">Amount Received</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalCreditAmount = 0; ?>
                                    @foreach($charts_of_accounts_income as $key => $account)
                                        @php
                                            $accounts = $account->transactions->keyBy('type');
                                            $totalCreditAmount +=  $accounts->get('credit')['amount'];
                                        @endphp
                                        @if ($accounts->get('credit')['amount'])
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$account->sector_name}}</td>
                                                <td class="text-right">{{number_format(array_get($accounts->get('credit'), 'amount', 0),2)}}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                        <tr>
                                            <td class="text-right" colspan="2">Total =</td>
                                            <td class=" text-right">{{number_format($totalCreditAmount, 2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                {!! !request('type') ? '<br> <br>' : ''!!}

                                <table width="100%"  border="1" {{request('type') == 'income' ? 'hidden' : ''}}>
                                    <thead>
                                    <tr>
                                        <td colspan="3" class="text-center head-row"><h4><b>Expanse Report</b></h4></td>
                                    </tr>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="">Chart of Account</th>
                                        <th class=" text-right">Amount Received</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalDebitAmount = 0; ?>
                                    @foreach($charts_of_accounts_expense as $key => $account)
                                        <?php
                                            $accounts = $account->transactions->keyBy('type');
//                                            dump(array_get($accounts->get('debit'), 'date', 0));
                                            $totalDebitAmount +=  $accounts->get('debit')['amount'];
                                        ?>
                                    @if ($accounts->get('debit')['amount'])
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$account->sector_name}}</td>
                                        <td class=" text-right">{{number_format(abs(array_get($accounts->get('debit'), 'amount', 0)), 2)}}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    <tr>
                                        <td class=" text-right" colspan="2">Total =</td>
                                        <td class=" text-right">{{number_format(abs($totalDebitAmount), 2)}}</td>
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