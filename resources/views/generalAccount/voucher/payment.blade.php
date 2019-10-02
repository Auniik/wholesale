@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 27px;
        }

        form .form-group .control-label {
            padding-top: 7px !important;
        }
    </style>
@endpush
@section('content')
    <div id="content" class="content min-form" style="min-height: 700px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="/vouchers/{!! $voucher->id !!}/payments/">Payment List</a>
                        </div>
                        <h4 class="panel-title"> {{ $voucher->isDebit()  ? "Debit Voucher Payment" : 'Credit Voucher Payment'}} </h4>
                    </div>

                    <div class="panel-body" id="tabArea">
                        <form method="post" action="{{ action('VoucherPaymentController@store', $voucher) }}">
                            @csrf

                            {{--GET ID FOR INSTALLMENT PAYS--}}
                            <input type="hidden" name="installmentId" value="{{request('id')}}">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Paid to : </label>
                                    <input type="text" class="form-control" value="{{$voucher->party->name}}" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ref_id"> Reference ID :</label>
                                    <input type="text" class="form-control" placeholder="Reference #ID" readonly value="{{$voucher->ref_id}}">
                                    <br>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Date">Payment Date  :</label>
                                    <input class="form-control" type="text" value="{{$voucher->date->format('d/m/Y')}}" readonly />
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table class="table table-bordered table-hover" id="table_auto">
                                        <thead>
                                            <tr>
                                                <th>Select Account </th>
                                                <th>Description</th>
                                                <th class="text-right">Payable Amount</th>
                                                <th class="text-right">Paid</th>
                                                <th class="text-right">Due</th>
                                            </tr>
                                        </thead>
                                        <tbody class="account-row">
                                            @foreach($voucher->sectors as $sector)
                                                <tr class="record-row">
                                                    <td>{{ $sector->chart_of_account->sector_name }}</td>
                                                    <td>{{ $sector->description }}</td>
                                                    <td class="text-right">{{ number_format($sector->amount, 2 )}}</td>
                                                    <td class="text-right">{{ number_format(abs($sector->paid) , 2)}}</td>
                                                    <td class="text-right">{{ number_format(abs($sector->due), 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @php($voucherDue = $voucher->sectors->sum('due'))
                                        <td colspan="4" align="right">Total Due</td>
                                        <td align="right">
                                            {{number_format($voucherDue, 2)}}
                                            <input type="hidden" class="amountDue" value="{{$voucherDue}}">
                                        </td>
                                    </table>
                                </div>
                            </div>



                            @if ($voucher->installments->isNotEmpty())
                                <div class="row">
                                    @include('generalAccount.installments.scheme', ['voucher' => $voucher])
                                </div>
                            @endif



                            <div class="row"><br><br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 text-right">Select Bank : </label>
                                        <div class="input-group col-md-8">
                                            <select class="form-control" name="account_id" id="account_id">
                                                <option value="">Please Select an Account</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 text-right">Select Method : </label>
                                        <div class="input-group col-md-8">
                                            <select class="form-control"  name="method_id"  id="method_id" disabled required>
                                                <option value="" disabled selected>Please select an account first</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="" >
                                        <label class="control-label col-md-4 text-right">Cheque No. : </label>
                                        <div class="input-group col-md-8">
                                            <input type="text" class="form-control" name="cheque_no" placeholder="Cheque No.">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group aside_system">
                                        <input type="hidden" name="total_amount" value="">
                                        <label class="control-label col-md-4 text-right">Due Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input class="form-control" style="text-align:right" value="{{ $voucher->due() }}" name="totalPayable" id="totalPayable" placeholder="Total Payable" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group aside_system">
                                        <label class="control-label col-md-4 text-right">Pay Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input @if (request('amount')) value="{{request('amount')}}" readonly @endif style="text-align:right" type="number" min="0" step="any" class="form-control" name="totalPaid" id="totalPaid" placeholder="Paid Amount" onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group aside_system">
                                        <div class="input-group col-md-12">
                                            <button type="submit"  class="btn btn-primary pull-right" style="font-weight: bold !important;">Submit Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("custom_js/voucher_installment.js")}}"></script>

    <script>

        $(document).ready(function () {
            $.each($('.installment-row'), function(){
                if ($(this).find('.installment-ids').val() == $('input[name="installmentId"]').val()) {
                    $(this).find('.installment-check').attr('checked', true);
                }

                let paidRow = $(this).find('.installment-statuses').val() == 'paid';

                if (paidRow){
                    addBtnDisable(this, 1)

                }

            }).trigger('change')
        })

        function addBtnDisable(element, index)
        {
            let paidRowIndex = $(element).find('.installment-statuses').closest('tr').index()
            $('.installment-body tr:eq('+(paidRowIndex-index)+')').find(".addInstallmentBtn").attr('disabled', true)
            $('.installment-body tr').find(".addInstallmentBtn").last().attr('disabled', false)

        }


    </script>

    <script>
        $('#account_id').change(function (e) {
            $.getJSON('{{url('getPaymentMethod')}}',{
                    id: $('#account_id').val()
                },
                function (methods) {
                    $("#method_id").removeAttr( "disabled" );
                    $('select#method_id').html(
                        $.map(methods, function (method) {
                            return `<option value="${method.id}">${method.method_name}</option>`;
                        }).join('')
                    ).trigger('change')
                }

            )
        })
    </script>
@endsection