@extends('layout.app')
@push('style')
    <style>
        table.table.asset-table {
            box-shadow: none;
            border: 0;
        }

        .amount-label{
            color: rgb(12, 5, 240);
        }

        .panel-title{
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <div id="content" class="content" style="font-size: 11px !important;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading no-print">
                        <h4> Income Expense Charts</h4>
                    </div>
                    <div class="panel-body mar" id="print_body">
{{--                        @include('generalAccount.dashboard.echarts', ['data' => $grossIncomeByDay])--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="content" class="content min-form" style="min-height: 700px;">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php
                                    $asset = $amounts->sum('amount') + ($appointmentDue + $serviceDue + $indoorDue) + $availablePettyCash;
                                ?>
                                <h5 class="panel-title text-left"> Available Amount : {{number_format($asset, 2)}} TK</h5>
                            </div>
                            <div class="panel-body" id="tabArea">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-no-border table-condensed asset-table ">
                                            <thead>
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0; width: 50%;">Particulars</td>
                                                <td align="right">Amount</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($amounts as $amount)
                                                <tr>
                                                    <td style="border-right: 1px solid #d0d0d0;">{{$amount->account->account_name}}</td>
                                                    <td align="right">
                                                        <span style="color: green;">
                                                            <?php
                                                                $currBalance = $amount->amount
                                                            ?>
                                                            {{$currBalance < 0 ? '(-) '.number_format(abs($currBalance), 2) : number_format($currBalance, 2)}}
                                                        </span> <span class="amount-label">TK</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0;">Petty Cash</td>
                                                <td align="right">
                                                    <span style="color: green;">{{number_format($availablePettyCash, 2)}}</span> <span class="amount-label">TK</span>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td style="border-right: 1px solid #d0d0d0;">Advance Payment</td>
                                                <td align="right">
                                                    <span style="color: green;">{{number_format(abs($advancePayment->amount), 2)}}</span> <span class="amount-label">TK</span>
                                                </td>
                                            </tr>

                                            </tbody>

                                        </table>
                                        <br>
                                        <table class="table table-no-border table-condensed asset-table ">
                                            <thead>
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0; width: 50%;">Dues</td>
                                                <td align="right">&nbsp;</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="border-right: 1px solid #d0d0d0; width: 50%; ">Receivable Amount</td>
                                                    <td align="right">
                                                        <span style="color: red;">{{number_format(array_get($totalAmount->get('credit'), 'amount', 0) - array_get($totalPaid->get('credit'), 'amount', 0), 2)}}</span> <span class="amount-label">TK</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-right: 1px solid #d0d0d0; width: 50%; ">Outdoor Services</td>
                                                    <td align="right"> <span style="color: red;">{{number_format($appointmentDue, 2)}}</span> <span class="amount-label">TK</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-right: 1px solid #d0d0d0; width: 50%; ">
                                                        Patient Admission
                                                    </td>
                                                    <td align="right"> <span style="color: red;">{{number_format($indoorDue, 2)}}</span> <span class="amount-label">TK</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-right: 1px solid #d0d0d0; width: 50%; ">Medical Services</td>
                                                    <td align="right"> <span style="color: red;">{{number_format($serviceDue, 2)}}</span> <span class="amount-label">TK</span></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php
                                    $liabilities = abs(array_get($totalAmount->get('debit'), 'amount', 0)) - abs(array_get($totalPaid->get('debit'), 'amount', 0))
                                ?>
                                <h5 class="panel-title text-left"> Liabilities : {{number_format($liabilities, 2)}} TK </h5>
                            </div>
                            <div class="panel-body" id="tabArea">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-no-border table-condensed asset-table ">
                                            <tbody>
                                                <tr>
                                                    <td>Payable Dues</td>
                                                    <td align="right"> <span style="color: red;">{{number_format($liabilities, 2)}}</span> <span class="amount-label">TK</span> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 hidden">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title text-center"> Equity </h5>
                            </div>
                            <div class="panel-body" id="tabArea">
                                <h3 class="text-center"> {{number_format(($asset - $liabilities), 2)}} <span class="amount-label">TK</span></h3>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title text-center">Accounts Summary : {{date('d/m/Y')}}</h5>
                            </div>
                            <div class="panel-body" id="tabArea">
                                <div class="row">
                                    <div class="col-xs-6" style="border-right: 1px solid #d0d0d0;">
                                        <h5 class="text-center">Income</h5>
                                        {{--@dd($todayIncome)--}}
                                        <h4 class="text-center">
                                            <span style="color: green;">{{number_format(array_get($today_transaction->get('credit'), 'amount', 0)+$todayIncome,2)}}</span> <span class="amount-label">TK</span>
                                        </h4>
{{--                                        <h4 class="text-center">{{number_format(array_get($today_transaction->get('credit'), 'amount', 0),2)}} TK</h4>--}}
                                    </div>
                                    <div class="col-xs-6">
                                        <h5 class="text-center" >Expense</h5>
                                        <h4 class="text-center">
                                            <span style="color: red;">{{number_format(abs(array_get($today_transaction->get('debit'), 'amount', 0)+$todayExpense), 2)}}</span> <span class="amount-label">TK</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title text-center"> Month  of {{date("F' Y")}}</h5>
                            </div>
                            <div class="panel-body" id="tabArea">
                                <div class="row">
                                    <div class="col-xs-6" style="border-right: 1px solid #d0d0d0;">
                                        <h5 class="text-center"  >Income</h5>
{{--                                        @dump(array_get($monthly_transaction->get('credit'), 'amount', 0))--}}
                                        <h4 class="text-center">
                                            <span style="color: green;">{{number_format(array_get($monthly_transaction->get('credit'), 'amount', 0)+$monthlyIncome, 2)}}</span> <span class="amount-label">TK</span>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6">
                                        <h5 class="text-center">Expense</h5>
                                        <h4 class="text-center">
                                            <span style="color: red;">{{number_format(abs(array_get($monthly_transaction->get('debit'), 'amount', 0)+$monthlyExpense), 2)}}</span> <span class="amount-label">TK</span>
                                        </h4>
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