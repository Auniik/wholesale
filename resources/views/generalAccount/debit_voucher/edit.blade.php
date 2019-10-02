@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 27px;
        }
    </style>
@endpush
@section('content')
    <div id="content" class="content min-form" style="min-height: 700px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('debit-voucher-list')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href='{{route('debit-vouchers.index')}}'>Debit Voucher List</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">Approve Debit Voucher </h4>
                    </div>
                    <div class="panel-body" id="tabArea">
                        @if(!$debit_voucher->approved_at)
                            <form action="{{route('debit-vouchers.update', $debit_voucher)}}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="set" value="{{request('set')}}">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Paid to : </label>
                                        {{--<input type="text" name="party_name" class="form-control" id="party_name" placeholder="Party Name" required autofocus onkeypress="autoCompleteClient(this.id)" autocomplete="off">--}}
                                        <input type="text" class="form-control"
                                               value="{{$debit_voucher->party->name}}"  id="party_name"
                                               placeholder="Client / Vendor Name" required autocomplete="off">
                                        <input type="hidden" name="party_id" id="party_id"
                                               value="{{$debit_voucher->party_id}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ref_id"> Reference #ID :</label>
                                        <input type="text" name="ref_id" placeholder="Reference ID"  value="{{$debit_voucher->ref_id}}" class="form-control" autocomplete="off">
                                        <br>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Date">Payment Date :</label>
                                        <input class="form-control datepicker" name="date" type="text"
                                               value="{{$debit_voucher->date->format('d-m-Y')}}"
                                               required autocomplete="off"/>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                        <table class="table table-bordered table-hover" id="table_auto">
                                            <thead>
                                            <tr>
                                                <th width="15%">Select Account: </th>
                                                <th width="35%">Description</th>
                                                <th width="10%">Payable Amount</th>
                                                <th width="10%">Paid</th>
                                                <th width="5%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="account-row">

                                            <?php
                                            $paid = 0;
                                            ?>

                                            @foreach($debit_voucher->sectors ?? [] as $sector)
                                                <tr class="record-row">
                                                    <td>
                                                        <input type="hidden" name="id[]" value="{{$sector->id}}">
                                                        <div class="col-md-12 no-padding">
                                                            <input type="text" name="chart_of_account[]"
                                                                   value="{{$sector->chart_of_account->sector_name}}"
                                                                   class="form-control small-box chart_of_accounts"
                                                                   autocomplete="off"  required>
                                                            <input type="hidden" name="chart_of_account_id[]"
                                                                   value="{{$sector->chart_of_account->id}}"
                                                                   class="form-control small-box chart_of_account_ids"
                                                                   autocomplete="off" required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" data-type="description[]"
                                                               name="description[]"  value="{{$sector->description}}"
                                                               autocomplete="off" class="form-control small-box descriptions">
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" name="payable_amount[]" style="text-align: right;"
                                                               value="{{$sector->amount}}"  class="form-control
                                                               small-box payable_amounts" required>
                                                    </td>
                                                    <td>
                                                        <input type="number"  min="0" name="paid_amount[]" style="text-align: right;"
                                                               value="{{abs(!$sector->paid ? optional($sector->sectorPayment)->paid_amount : $sector->paid)}}"
                                                               class="form-control small-box paid_amounts" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-xs addBtn" tabindex="-1"> <i class="fa fa-plus"></i> </button>
                                                        <button type="button" class="btn btn-danger btn-xs deleteBtn" tabindex="-1"> <i class="fa fa-trash"></i> </button>
                                                    </td>

                                                    <?php
                                                    $paid += abs(!$sector->paid
                                                        ? optional($sector->sectorPayment)->paid_amount
                                                        : $sector->paid)
                                                    ?>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                        $paymentThrough = $debit_voucher->payments->first();
                                                    ?>
                                                    <label class="control-label">Selected Bank : </label>
                                                    <select name="account_id" class="form-control account_id">
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Selected Method : </label>
                                                    {{--<input type="text" class="form-control"  value="{{$debit_voucher->payments->first()->method->method_name}}" readonly>--}}
                                                    <select  class="form-control"  name="method_id"  id="method_id" disabled required>
                                                        <option value="" disabled selected>Select an Account first</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Cheque No. : </label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="cheque_no" value="{{$debit_voucher->cheque_no}}" placeholder="Cheque No." autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group aside_system">
                                            <label class="control-label col-md-4 text-right">Payable Amount :</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-addon currency">৳</div>
                                                <input value="{{$debit_voucher->sectors->sum('amount')}}" class="form-control" name="totalPayable" id="totalPayable" tabindex="-1" placeholder="Total Payable" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="control-label col-md-4 text-right">Pay Amount :</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-addon currency">৳</div>
                                                <input value="{{$paid}}" type="number" min="0" step="any" class="form-control" tabindex="-1" name="totalPaid" id="totalPaid" placeholder="Paid Amount" readonly onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="control-label col-md-4 text-right">Amount Due :</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-addon currency">৳</div>
                                                <input value="{{$debit_voucher->sectors->sum('amount')-$paid}}" type="number" min="0" step="any" class="form-control amountDue" tabindex="-1"  id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" readonly >
                                            </div>
                                        </div>
                                    </div>

                                    @include('generalAccount.installments.scheme', ['voucher' => $debit_voucher])

                                    <div class="col-md-6 col-lg-offset-3">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-success col-sm-12">Approve Payment</button>
                                    </div>
                                </div>
                            </form>

                        @else
                            <h3>Voucher Already APPROVED!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('custom_js/voucher_config.js')}}"></script>
    <script type="text/javascript" src="{{asset('custom_js/loadDetails.js')}}"></script>
    <script type="text/javascript" src="{{asset('custom_js/voucher_installment.js')}}"></script>
    <script>
        $(function (e) {
            @if(!$debit_voucher->approved_at)
                $('.account_id').val({{$paymentThrough->account_id}}).trigger('change')
                $('#method_id').val({{$paymentThrough->method_id}}).trigger('change')
            @endif
            $('[data-toggle="tooltip"]').tooltip({

            })
        })
        $('.account_id').change(function (e) {
            $.getJSON('{{url('getPaymentMethod')}}',{
                    id: $('.account_id').val()
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

        loadDetails({
            selector: '#party_name',
            url: '{!! url('/load-parties') !!}',
            select: function (event, ui) {
                $(this.selector).val(ui.item.data.name);
                $('#party_id').val(ui.item.data.id);
                if ($('#party_id').val()){
                    $(this.selector).removeClass('has-error').attr('title', '');
                }
            },
            search: function (event) {
                $(this.selector).addClass('has-error').attr('title', 'Party Not Recognized');
                $('#party_id').val('');
            }
        });
    </script>

    <script>
        $(document).on('focus', '.chart_of_accounts', function(){
            $(this).autocomplete({
                source: function (request, response) {
                    $.getJSON('{{url('/load-chart-of-accounts?type=debit')}}', {
                        name: request.term
                    }, function (data) {
                        response($.map(data, function (item) {
                            return{
                                value: item.sector_name,
                                label: item.sector_name,
                                data: item,
                            }
                        }))
                    })
                },
                autoFocus: true,
                select: function(event, ui) {
                    let chartOfAccountIds = $(event.target).parents('tr').find('.chart_of_account_ids');
                    let chartOfAccountNames = $(event.target).parents('tr').find('.chart_of_accounts');
                    chartOfAccountIds.val(ui.item.data.id)

                    if (chartOfAccountIds.val()) {
                        chartOfAccountNames.removeClass('has-error').attr('title', '');
                    }
                },
                search: function (event) {
                    $(event.target).parents('tr').find('.chart_of_account_ids').val('')
                    $(event.target).parents('tr').find('.chart_of_accounts').addClass('has-error').prop('title',
                        'Chart of Accounts doesn\'t Recognized');
                }
            })
        });
    </script>
@endsection
