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
                            <a class="btn btn-success btn-sm" href='{{route('credit-vouchers.index')}}'>Credit Voucher List</a>
                        </div>
                        <h4 class="panel-title"> Credit Voucher </h4>
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
                        <form action="{{route('credit-vouchers.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Received From : </label>
                                    <input type="text" name="party_name" class="form-control" id="party_name" placeholder="Client / Vendor Name" required autocomplete="off">
                                    <input type="hidden" name="party_id"   id="party_id">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ref_id"> Reference ID :</label>
                                    <input type="text" name="ref_id"  class="form-control" autocomplete="off">
                                    <br>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Date">Payment Date :</label>
                                    <input class="form-control" type="hidden" name="date" value="{{date('Y-m-d')}}" readonly required autocomplete="off"/>
                                    <input class="form-control"  type="text" value="{{date('d/m/Y')}}" readonly  autocomplete="off"/>                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table class="table table-bordered table-hover" id="table_auto">
                                        <thead>
                                        <tr>
                                            <th width="15%">Select Account </th>
                                            <th width="35%">Description</th>
                                            <th width="10%" class="text-right">Receivable Amount</th>
                                            <th width="10%" class="text-right">Received</th>
                                            <th width="5%"Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="account-row">
                                        @if(old())
                                            @foreach (old('chart_of_account_id') as $i => $value)

                                                <tr class="record-row">
                                                    <td>
                                                        <div class="col-md-12 no-padding">
                                                            <input value="{{old('chart_of_account')[$i]}}" type="text"
                                                                   name="chart_of_account[]" class="form-control
                                                               small-box chart_of_accounts"
                                                                   autocomplete="off" required>
                                                            <input value="{{old('chart_of_account_id')[$i]}}" type="hidden"
                                                                   name="chart_of_account_id[]" class="form-control
                                                               small-box chart_of_account_ids" autocomplete="off"
                                                                   required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input value="{{old('description')[$i]}}" type="text"
                                                               data-type="description[]" name="description[]"
                                                               autocomplete="off" required class="form-control small-box
                                                            descriptions">
                                                    </td>
                                                    <td>
                                                        <input value="{{old('payable_amount')[$i]}}" type="number"
                                                               style="text-align: right;" min="0" name="payable_amount[]"
                                                               class="form-control small-box
                                                           payable_amounts" required>
                                                    </td>
                                                    <td>
                                                        <input value="{{old('paid_amount')[$i]}}" type="number"
                                                               style="text-align: right;"  min="0" name="paid_amount[]"
                                                               class="form-control small-box paid_amounts" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-xs addBtn"
                                                                tabindex="-1"> <i class="fa fa-plus"></i> </button>
                                                        <button type="button" class="btn btn-danger btn-xs deleteBtn"
                                                                tabindex="-1"> <i class="fa fa-trash"></i> </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="record-row">
                                                <td>
                                                    <div class="col-md-12 no-padding">
                                                        <input type="text" name="chart_of_account[]"
                                                               class="form-control small-box chart_of_accounts"
                                                               autocomplete="off" required>
                                                        <input type="hidden" name="chart_of_account_id[]"
                                                               class="form-control small-box chart_of_account_ids"
                                                               autocomplete="off" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" data-type="description[]" name="description[]"
                                                           autocomplete="off" required class="form-control small-box
                                                            descriptions">
                                                </td>
                                                <td>
                                                    <input type="number" style="text-align: right;" min="0"
                                                           name="payable_amount[]"  class="form-control small-box
                                                           payable_amounts" required>
                                                </td>
                                                <td>
                                                    <input type="number"
                                                           style="text-align: right;"
                                                           min="0" name="paid_amount[]"  class="form-control small-box
                                                           paid_amounts" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs addBtn"
                                                            tabindex="-1"> <i class="fa fa-plus"></i> </button>
                                                    <button type="button" class="btn btn-danger btn-xs deleteBtn"
                                                            tabindex="-1"> <i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right">Select Bank : </label>
                                        <div class="input-group col-md-8">
                                            <select class="form-control" name="account_id" id="account_id" required >
                                                <option value="">Please Select an Account</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right">Select Method : </label>
                                        <div class="input-group col-md-8">
                                            <select class="form-control"  name="method_id"  id="method_id" disabled required>
                                                <option value="" disabled selected>Please select an account first</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="" >
                                        <label class="control-label col-md-3 text-right">Cheque No. : </label>
                                        <div class="input-group col-md-8">
                                            <input type="text" class="form-control" name="cheque_no" placeholder="Cheque No.">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group aside_system">
                                        <label class="control-label col-md-4 text-right">Receivable Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input value="" class="form-control" style="text-align: right" name="totalPayable" id="totalPayable" tabindex="-1" placeholder="Total Payable" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group aside_system">
                                        <label class="control-label col-md-4 text-right">Received Amount :</label>
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
                                <div class="col-md-6 col-lg-offset-3">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-success col-sm-12">Submit Income</button>
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
                    $.getJSON('{{url('/load-chart-of-accounts?type=credit')}}', {
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
                minLength: 1,
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