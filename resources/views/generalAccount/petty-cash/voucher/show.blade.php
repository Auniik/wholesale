@extends('layout.app')
@push('style')
    <style>
        table td, table th { border: 1px solid #bfc5dc; padding: 5px; box-shadow:none;}
        #address { width: 250px; height: 150px; float: left; }
        #customer { overflow: hidden; }
        #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; overflow: hidden; }
        #meta { margin-top: 1px; width: 100%; float: right; }
        #meta td { text-align: right;  }
        #meta td.meta-head { text-align: left; background: #eee; }
        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th { background: #eee; }
        #items textarea { width: 80px; height: 50px; }
        #items tr.item-row td {  vertical-align: top; }
        #items td.description { width: 300px; }
        #items td.item-name { width: 175px; }
        #items td.description textarea, #items td.item-name textarea { width: 100%; }
        #items td.total-line {  text-align: right; outline: 1px solid LAVENDER; }
        #items td.total-value {  padding: 10px; text-align: right; outline: 1px solid LAVENDER;}
        #items td.total-value textarea { height: 20px; background: none; }
        #items td.balance { background: #eee; }
        #items td.blank { border: 1px solid #fff; }
        #terms { text-align: center; margin: 20px 0 0 0; }
        #terms h5 { text-transform: uppercase; font: 15px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
        #terms textarea { width: 100%; text-align: center;}
        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
@endpush
@section('content')
    <div id="content" class="content"  style="font-size: 11px !important;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading no-print">
                        <div class="panel-heading-btn pull-right">
                            <div class="dropdown">
                                <button onclick="printPage('print_body')" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</button>
                                <a class="btn btn-info btn-sm" href="{{ url('/petty-cash-vouchers/create') }}">Add New</a>
                            </div>
                        </div>
                        <h4 class="panel-title">Petty Cash Voucher </h4>
                    </div>

                    <div class="panel-body mar" id="print_body">
                        <table width="100%">
                            <tr>
                                <td style="border: 0;  text-align: left" width="40%">
                                    <img id="image" src="{{ url(auth()->user()->companyInfo->logo ?? '') }}" alt="logo" />
                                    <br><br>
                                    <span style="font-size: 18px; color: #2f4f4f"><strong>INVOICE # {{$pettyCashVoucher->id}}</strong></span>
                                </td>

                                <td style="border: 0;" ><img src='http://chart.apis.google.com/chart?chs=150x150&cht=qr&chld=L|0&chl=http%3A%2F%2Fdemo.tolooks.com%2Febiz%2F%3Fng%3Dclient%2Fiview%2F11010%2Ftoken_2132255975' border='0' width='100'/></td>
                                <td style="border: 0;  text-align: right" width="40%">
                                    <div id="logo">
                                        {{auth()->user()->companyInfo->address}}  <br>
                                        Mobile No.: {{auth()->user()->companyInfo->mobile_no}} <br>
                                        Fax: {{auth()->user()->companyInfo->fax}} <br>
                                        Email: {{auth()->user()->companyInfo->email}} <br>
                                        {{auth()->user()->companyInfo->web}} <br>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <br>

                        <div style="clear:both"></div>
                        <div id="customer">
                            <div id="customer">
                                <table id="meta">
                                    <tr>
                                        <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left">
                                            <strong>Invoice By</strong> <br>
                                            {{ $pettyCashVoucher->user->name}} <br>
                                        <td class="meta-head">INVOICE #</td>
                                        <td>PC-{{ str_pad($pettyCashVoucher->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="meta-head">Invoice Date</td>
                                        <td>{{$pettyCashVoucher->date->format('d/m/Y')  }}</td>
                                    </tr>
                                </table>

                            </div>
                            <table id="items">

                                <tr>
                                    <th width="15%">Chart of Accounts</th>
                                    <th width="35%">Description</th>
                                    <th class="text-right" width="13%">Paid</th>
                                </tr>
                                @foreach($pettyCashVoucher->charts as $key => $chart)
                                    <tr class="item-row">
                                        <? $amount = 0 ?>
                                        <td >{{$chart->pettyCashCharts->name}}</td>
                                        <td >{{$chart->description}}</td>
                                        <td align="right">{{number_format($chart->amount, 2)}} TK</td>
                                    </tr>
                                @endforeach
                                {{--<tr>--}}
                                    {{--<td class="blank"></td>--}}
                                    {{--<td class="blank"> </td>--}}
                                    {{--<td colspan="2" class="total-line">Sub Total</td>--}}
                                    {{--<td class="total-value"><div id="subtotal">Tk. {{ number_format($debit_voucher->sectors->sum('amount'), 2 )}}</div></td>--}}
                                {{--</tr>--}}
                                <tr>
                                    {{--<td class="blank"> </td>--}}
                                    {{--<td class="blank"> </td>--}}
                                    <td colspan="2" class="total-line">Total Paid =</td>
                                    <td class="total-value"><div class="due"> {{ number_format(abs($pettyCashVoucher->charts->sum('amount')), 2 )}} TK</div></td>
                                </tr>
                            </table>
                            <div class="print-footer" style="margin-top: 40px;overflow: hidden;width: 100%;padding: 0 10px;">
                                <div class="sign" style="width: 100%; overflow: hidden;">
                                    <div class="company_sign" style="width: 33%; float: left;">
                                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">&nbsp;</h5>
                                        <h5 style="width:50%;margin: 0 auto;border-top: 1px solid #000;padding: 10px 0;text-align: center;">Received By</h5>
                                    </div>
                                    <div class="company_sign" style="width: 33%; float: left;">
                                        <h5 style="width:50%; margin: 0 auto; padding: 10px 0;text-align: center;">{{$pettyCashVoucher->user->name}}</h5>
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
                                        <p class="pull-left">NB: This is an automated system generated voucher.</p>
                                        {{--                                        <p class="design_band pull-right">Powered By: <a href="#" > Smart Software Inc.</a></p>--}}
                                    </div>
                                </div>
                                <br>
                            </div>
                            <!--    related transactions -->
                            <!--    end related transactions -->
                            <div id="terms">
                                    {{--A/C No: 1501203853155001<br>              Gulshan Branch<br>              BRAC BANK LTD.<span></span><br></p>        </div>--}}
                                <button class='btn btn-bitbucket center no-print btn-xs'  onClick="printPage('print_body');">Click Here to Print</button>
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
    window.onload = $('#print_body').printThis({
        importStyle: true
    });

</script>
@endsection