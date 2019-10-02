@extends('layout.app')
    @push('style')
        <style>
            input.form-control.small-box {
                height: 27px;
            }
        </style>
    @endpush
@section('content')
    <div class="col-md-8 col-md-offset-3">
        @if (!$available_amount)
            <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>Warning!</strong> You should deposit amount for creating petty cash invoice
                <a href="{{url('/petty-cash-deposits')}}">here</a>
            </div>
        @endif
    </div>
    <div id="content" class="content min-form" style="min-height: 700px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href='{{route('petty-cash-deposits.index')}}'>Deposit Petty Cash</a>
                            <a class="btn btn-success btn-sm" href='{{route('petty-cash-vouchers.index')}}'>Vouchers</a>
                        </div>
                        <h4 class="panel-title"> Petty Cash Voucher </h4>
                    </div>
                    <div class="panel-body" id="tabArea">



                        <form action="{{route('petty-cash-vouchers.store')}}" method="post" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="Date">Date  :</label>
                                    <input type="hidden" name="date" value="{{date('Y-m-d')}}" placeholder="Payment Date" required autocomplete="off"/>
                                    <input class="form-control" readonly type="text" value="{{date('d/m/Y')}}" placeholder="Pyment Date" required autocomplete="off"/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table class="table table-bordered table-hover" id="table_auto">
                                        <thead>
                                        <tr>
                                            <th width="15%">Chart of Accounts</th>
                                            <th width="35%">Purpose</th>
                                            <th width="10%" style="text-align: right">Amount</th>
                                            <th width="5%" class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="account-row">
                                        <tr class="record-row">
                                            <td>
                                                <input type="text"  name="petty_cash_charts[]" autocomplete="off" class="form-control small-box petty_cash_charts ">
                                                <input type="hidden"  name="petty_cash_charts_id[]" autocomplete="off" class="form-control small-box petty_cash_charts_ids ">
                                            </td>
                                            <td>
                                                <input type="text"  name="description[]" autocomplete="off" class="form-control small-box descriptions ">
                                            </td>
                                            <td>
                                                <input type="number" style="text-align: right" min="0" name="amount[]" autocomplete="off" class="form-control small-box amounts">
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

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group aside_system">
                                        <label class="col-md-4">Available Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input type="number" value="{{$available_amount}}" class="form-control" tabindex="-1" name="available_amount" id="available_amount" placeholder="Available Amount" readonly onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group aside_system">
                                        <label class="col-md-4">Total Amount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input type="number" value="0" class="form-control" tabindex="-1" name="totalAmount" id="totalAmount" placeholder="Paid Amount" readonly onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4">&nbsp;</label>
                                        <button type="submit" {{$available_amount ? '' : 'disabled'}} class="btn btn-success col-md-8">Submit Payment</button>
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
<script>
    //Add More Row
    $(document).on('click', '.addBtn', function () {
        $('.account-row').append(`
            <tr class="record-row">
                <td>
                    <input type="text"  name="petty_cash_charts[]" autocomplete="off" class="form-control small-box petty_cash_charts ">
                    <input type="hidden"  name="petty_cash_charts_id[]" autocomplete="off" class="form-control small-box petty_cash_charts_ids ">
                </td>
                <td>
                    <input type="text"  name="description[]" autocomplete="off" class="form-control small-box descriptions ">
                </td>
                <td>
                    <input type="number" style="text-align: right" min="0" name="amount[]" autocomplete="off" class="form-control small-box amounts">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-xs addBtn" tabindex="-1"> <i class="fa fa-plus"></i> </button>
                    <button type="button" class="btn btn-danger btn-xs deleteBtn" tabindex="-1"> <i class="fa fa-trash"></i> </button>
                </td>
            </tr>
        `)
    })



    //Voucher Calculations
    $(document).on('focus keyup','.amounts', function () {
        sectorCalculation();
    });
    function sectorCalculation(){
        let rows = $('.record-row'),
            totalAmount = 0,
            available_amount = '{{$available_amount}}';
        $.each(rows, function (i, row) {
            let amount = parseFloat($(row).find('.amounts').val());
            if (!amount) amount = 0;
            totalAmount += amount;
            if (totalAmount > available_amount){
                alert('You can\'t pay more than available amount!');
                $(row).find('.amounts').val(0)
            }
        });

        $('#totalAmount').val(totalAmount);
    }

    //User Friendly Configs
    $(document).on('keydown', '.amounts', function(e){
        if (e.keyCode === 13) {
            e.preventDefault();
            $($('.addBtn')[0]).trigger('click');
            $('.descriptions').last().focus();
        }
    });
    $(document).on('keydown', '.descriptions, .amounts', function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
        }
    });
    //Delete Action on row
    $(document).on('click', '.deleteBtn', function (e) {
        if ($('.record-row').length == 1) {
            alert(`You can't delete the existed last row!`)
            $(this).parents('tr').find('input').val('')
        }else{
            $(this).parents('tr').remove();
            sectorCalculation();
        }
    });

</script>


<script>
    $(document).on('keyup', '.petty_cash_charts', function(){
        $(this).autocomplete({
            source: function (request, response) {
                $.getJSON('{{url('/load-petty-charts')}}', {
                    name: request.term
                }, function (data) {
                    response($.map(data, function (item) {
                        return{
                            value: item.name,
                            label: item.name,
                            data: item,
                        }
                    }))
                })
            },
            autoFocus: true,
            minLength: 1,
            select: function(event, ui) {
                var items = ui.item.data;
                $(event.target).parents('tr').find('.petty_cash_charts_ids').val(ui.item.data.id);
            }
        })
    });
</script>
@endsection
