@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 27px;
        }
        form .form-group .control-label {
            padding-top: 7px;
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
                            <a class="btn btn-success btn-sm" href='{{route('advance-payment-vouchers.index')}}'>Advance Payment Voucher List</a>
                        </div>
                        <h4 class="panel-title"> Advance Payment Voucher </h4>
                    </div>
                    <div class="panel-body" id="tabArea">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('advance-payment-vouchers.store')}}"  method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Paid to : </label>
                                    {{--<input type="text" name="party_name" class="form-control" id="party_name" placeholder="Party Name" required autofocus onkeypress="autoCompleteClient(this.id)" autocomplete="off">--}}
                                    <input type="text" name="party_name" class="form-control" id="party_name" placeholder="Client / Vendor Name" required autocomplete="off">
                                    <input type="hidden" name="party_id"   id="party_id">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ref_id"> Reference ID :</label>
                                    <input type="text" name="ref_id"  class="form-control" autocomplete="off">
                                    <br>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Date">Payment Date  :</label>
                                    <input class="form-control" type="hidden" name="date" value="{{date('Y-m-d')}}" readonly required autocomplete="off"/>
                                    <input class="form-control"  type="text" value="{{date('d/m/Y')}}" readonly required autocomplete="off"/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table class="table table-bordered table-hover" id="table_auto">
                                        <thead>
                                        <tr>
                                            <th width="15%">Chart of Accounts </th>
                                            <th width="35%">Description</th>
                                            <th width="10%" style="text-align: center">Payable Amount</th>
                                            <th width="10%" style="text-align: right">Paid</th>
                                            <th width="5%" style="text-align: center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="account-row">
                                            <tr class="record-row">
                                                <td>
                                                    <div class="col-md-12 no-padding">
                                                        <input type="text" name="chart_of_account[]" class="form-control small-box chart_of_accounts" autocomplete="off" required>
                                                        <input type="hidden" name="chart_of_account_id[]" class="form-control small-box chart_of_account_ids" autocomplete="off" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" data-type="description[]" name="description[]" autocomplete="off" required class="form-control small-box descriptions">
                                                </td>
                                                <td>
                                                    <input type="number" style="text-align: right;" min="0" name="payable_amount[]" class="form-control small-box payable_amounts" required>
                                                </td>
                                                <td>
                                                    <input type="number" style="text-align: right;" value="0" min="0" name="paid_amount[]" class="form-control small-box paid_amounts" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs addBtn" tabindex="-1"> <i class="fa fa-plus"></i> </button>
                                                    <button type="button" class="btn btn-danger btn-xs deleteBtn" tabindex="-1"> <i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
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
                                                <label class="control-label">Select Bank : </label>
                                                <select class="form-control" name="account_id" id="account_id" required>
                                                    <option value="">Please Select an Account</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Select Method : </label>
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
                                                <input type="text" class="form-control" name="cheque_no" placeholder="Cheque No.">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            @can('installments-create')
                                                <div class="form-group" style="margin-top: 15px;">
                                                    <input class="checkbox-inline no-margin" type="checkbox"
                                                           id="pay-via-installments" name="payViaInstallment" value="1">
                                                    <label class="control-label" for="pay-via-installments"> Reminder for
                                                        Installments</label>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group aside_system">
                                        <label class="control-label col-md-4 text-right">Payable Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input value="" class="form-control" style="text-align: right" name="totalPayable" id="totalPayable" tabindex="-1" placeholder="Total Payable" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group aside_system">
                                        <label class="control-label col-md-4 text-right">Paid Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input value="0" type="number" style="text-align: right" min="0" step="any" class="form-control" tabindex="-1" name="totalPaid" id="totalPaid" placeholder="Paid Amount" readonly onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group aside_system">
                                        <label class="control-label col-md-4 text-right">Amount Due :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input value="" type="number" style="text-align: right" min="0" step="any" class="form-control amountDue" tabindex="-1"  id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" readonly >
                                        </div>
                                    </div>
                                </div>

                                @can('installments-create')
                                    <div class="col-md-8 col-lg-offset-2 installment-section hidden">
                                        <br>
                                        <h3 class="text-center">Monthly Installments</h3>
                                        <table class="table table-condensed">
                                            <thead>
                                            <tr>
                                                <th width="1%"></th>
                                                <th>Purpose </th>
                                                <th class="text-center">Date</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-center"  width="10%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="installment-body">
                                            @include('generalAccount.installments.setScheme')
                                            </tbody>
                                        </table>
                                    </div>
                                @endcan

                                <div class="col-md-6 col-lg-offset-3">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-success col-sm-12">Submit Advance Payment</button>
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
    <script type="text/javascript" src="{{asset('custom_js/loadDetails.js')}}"></script>
    <script type="text/javascript" src="{{asset('custom_js/voucher_config.js')}}"></script>
    <script type="text/javascript" src="{{asset('custom_js/voucher_installment.js')}}"></script>
    <script>
        loadDetails({
            selector: '#party_name',
            url: '{!! url('/load-parties') !!}',
            select: function (event, ui) {
                $(this.selector).val(ui.item.data.name);
                $('#party_id').val(ui.item.data.id);
            },
        });
    </script>

    <script>
        $(document).on('keyup', '.chart_of_accounts', function(){
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
                    var items = ui.item.data;
                    $(event.target).parents('tr').find('.chart_of_account_ids').val(ui.item.data.id);
                }
            })
        });
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
