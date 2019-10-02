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

    <div id="content" class="content min-form" style="">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title text-left"> Available Amount : 00.00 TK</h5>
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
                                            {{--@foreach ($amounts as $amount)--}}
                                                <tr>
                                                    <td style="border-right: 1px solid #d0d0d0;">Chart of Accounts
                                                        Name</td>
                                                    <td align="right">
                                                        <span style="color: green;">
                                                            00.00
                                                        </span> <span class="amount-label">TK</span>
                                                    </td>
                                                </tr>
                                            {{--@endforeach--}}
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0;">Petty Cash</td>
                                                <td align="right">
                                                    <span style="color: green;" class="petty-cash">00.00</span> <span
                                                            class="amount-label">TK</span>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td style="border-right: 1px solid #d0d0d0;">Advance Payment</td>
                                                <td align="right">
                                                    <span style="color: green;" class="advance-payment">00.00</span>
                                                    <span class="amount-label">TK</span>
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
                                                    <span style="color: red;" class="receivable-amount">00.00</span>
                                                    <span
                                                            class="amount-label">TK</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0; width: 50%; ">Outdoor Services</td>
                                                <td align="right">
                                                    <span style="color: red;" class="outdoor-due">00.00</span> <span
                                                            class="amount-label">TK</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0; width: 50%; ">
                                                    Patient Admission
                                                </td>
                                                <td align="right">
                                                    <span style="color: red;" class="indoor-due">00.00</span>
                                                    <span class="amount-label">TK</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-right: 1px solid #d0d0d0; width: 50%; ">Medical Services</td>
                                                <td align="right"> <span style="color: red;" class="service-due">00.00</span>
                                                    <span class="amount-label">TK</span></td>
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
                                <h5 class="panel-title text-left"> Liabilities : 00.0 TK </h5>
                            </div>
                            <div class="panel-body" id="tabArea">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-no-border table-condensed asset-table ">
                                            <tbody>
                                            <tr>
                                                <td>Payable Dues</td>
                                                <td align="right">
                                                    <span style="color: red;">00.00</span>
                                                    <span class="amount-label">TK</span> </td>
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
                                <h3 class="text-center"> 5000000 <span class="amount-label">TK</span></h3>
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
                                        <h4 class="text-center">
                                            <span style="color: green;" class="daily-income"> 00.00</span>
                                            <span class="amount-label">TK</span>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6">
                                        <h5 class="text-center" >Expense</h5>
                                        <h4 class="text-center">
                                            <span style="color: red;" class="daily-expense">00.00</span> <span
                                                    class="amount-label">TK</span>
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
                                        <h4 class="text-center">
                                            <span style="color: green;" class="monthly-income">00.00</span> <span
                                                    class="amount-label">TK</span>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6">
                                        <h5 class="text-center">Expense</h5>
                                        <h4 class="text-center">
                                            <span style="color: red;" class="monthly-expanse">00.00</span> <span
                                                    class="amount-label">TK</span>
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
