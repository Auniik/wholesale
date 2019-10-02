@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 28px;
        }
        input.form-control.small-label-box {
            height: 20px;
            padding: 1.5px;
            border: 1px solid rgba(180, 180, 180, 0.52) !important;
        }
        .table tbody tr td {
            padding: 5px;
        }
    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel">
            <div class="panel-heading">
                @can('pharmacy-purchase-list')
                <div class="panel-heading-btn pull-right">
                    <a class="btn btn-success btn-sm" href="{{route('inventory-product-purchases.index')}}">
                        All Added Product
                    </a>
                </div>
                @endcan
                <h4 class="panel-title">Purchase Product</h4>
            </div>
            <div class="panel-body no-padding">
                <form method="POST" action="{{route('inventory-product-purchases.store')}}" >
                    @csrf
                    <div class="col-md-12">
                        <div class='row'>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Manufacturer Name :</label>
                                            <select class="form-control select2" name="manufacturer_id" id="manufacturer_id">
                                                <option value="">Select One</option>
                                                @foreach($manufacturers as $manufacturer)
                                                    <option value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Challan Id :</label>
                                            <input type="text" tabindex="-1" class="form-control" name="challan_id"
                                                   value="{{$challan_id}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Date :</label>
                                            <input type="text" name="date" readonly value="{!! date('Y-m-d');!!}"
                                                   class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                                <div class="row"> <br>
                                    <div class="col-md-8">

                                        <table class="table table-bordered table-hover" id="table_auto">
                                            <thead>
                                            <th>Product Name</th>
                                            <th width="12%">Unit TP</th>
                                            <th width="12%">Sales Price</th>
                                            <th width="11%">Pack Size</th>
                                            <th colspan="2" width="10%">Qty</th>
                                            {{--<th width="10%">Unit Vat</th>--}}
                                            <th width="16%">Expiry Date</th>
                                            <th width="10%">Total TP</th>
                                            </thead>

                                            <tbody class="products">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group aside_system">
                                            <label class="col-md-3 control-label">Sub Total</label>
                                            <div class="input-group col-md-9">
                                                <div class="input-group-addon currency">৳</div>
                                                <input tabindex="-1" value="0" type="number" min="0" step="any"
                                                       class="form-control" name="subtotal" id="subTotal" placeholder="Sub
                                               Total"readonly>
                                            </div>
                                        </div>
                                        {{--<div class="form-group aside_system">--}}
                                        {{--<label class="col-md-3">Total Vat:</label>--}}
                                        {{--<div class="input-group col-md-9">--}}
                                        {{--<div class="input-group-addon currency">৳</div>--}}
                                        {{--<input tabindex="-1" type="number" min="0" step="any" class="form-control" value="" name="total_vat" id="vatAmount" placeholder="Total Vat" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" readonly>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="form-group aside_system">
                                            <label class="col-md-3">Discount</label>
                                            <div class="input-group col-md-9">
                                                <div class="input-group-addon currency">৳</div>
                                                <input tabindex="-1" value="0" type="number" min="0" step="any"
                                                       class="form-control" name="discount" id="discount" placeholder="Discount">
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="col-md-3">Grand Total</label>
                                            <div class="input-group col-md-9">
                                                <div class="input-group-addon currency">৳</div>
                                                <input tabindex="-1" value="" type="number" min="0" step="any"
                                                       class="form-control"  name="grand_total" id="grandTotal"
                                                       placeholder="Grand Total" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="col-md-3 control-label">Total Paid</label>
                                            <div class="input-group col-md-9">
                                                <div class="input-group-addon currency">৳</div>
                                                <input value="0" type="number" min="0" step="any" class="form-control"
                                                       name="paid_amount" id="totalPaid" placeholder="Total Paid">
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="col-md-3">Total Due</label>
                                            <div class="input-group col-md-9">
                                                <div class="input-group-addon currency">৳</div>
                                                <input tabindex="-1" value="" type="number" min="0" step="any"
                                                       class="form-control" name="due_amount" id="totalDue"
                                                       placeholder="Total Due" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 pull-right">
                                                <div class="form-group">
                                                    <button type="submit" name="draft" class="btn btn-primary" style="width: 100%;">Confirm</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 pull-right">
                                                <div class="from-group">
                                                    <button type="submit" name="confirm" class="btn btn-success" style="width: 100%">Draft</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class='row'>
                            <div class='col-xs-12 col-sm-7 col-md-7 col-lg-7'>


                            </div>

                            <div class='col-xs-12 col-sm-5 col-md-5 col-lg-5'>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

    <script>
        $(document).on('focus', '.purchaseDate, .expireDate, .add-expire-date', function () {
            $(this).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
        })
    </script>

    <script src="{{asset('custom_js/loadDetails.js')}}"></script>

    <script>
        loadDetails({
            selector: '#drug-name',
            url: '{{'/load-drug'}}',
            select: function (event, ui) {
                $('.add-product-id').val(ui.item.data.id);
                $('.drug-name').val(ui.item.data.name);
            }

        });

    </script>


    <script>
        $('#manufacturer_id').change(function () {
            let id = $(this).val();
            if (id){
                $.ajax({
                    url: '{{'/get-purchasable-products'}}/'+id,
                    datatype: 'HTML',

                }).done(function(data){
                    $('.products').html(data)
                })
            }

        })
    </script>


    <script>
        $(document).on('focus keyup', '.quantities, .pack-sizes, .unit-tps, .sales-prices, #discount, #totalPaid',
            function (e) {

            row(e).find('.retail-unit-tps').val(retailConversion(e).retailUnitCost)
            row(e).find('.retail-sales-prices').val(retailConversion(e).retailSalesPrice)
            row(e).find('.retail-quantities').val(retailConversion(e).quantities)
            row(e).find('.total-line-prices ').val(retailConversion(e).linePrice)

            $('#subTotal').val(subTotal(e));

        })

        function retailConversion(e)
        {
            let unitCost = parseFloat(row(e).find('.unit-tps').val())
            let salesPrice = parseFloat(row(e).find('.sales-prices').val())
            let packSize = parseFloat(row(e).find('.pack-sizes').val())
            let quantity = parseFloat(row(e).find('.quantities').val())

            if (!unitCost) unitCost = 0
            if (!salesPrice) salesPrice = 0
            if (!packSize) packSize = 0
            if (!quantity) quantity = 0

            return {
                retailUnitCost: unitCost / packSize,
                retailSalesPrice: salesPrice / packSize,
                quantities: packSize * quantity,
                linePrice: unitCost * quantity
            }

        }

        function subTotal(e)
        {
            let rows = $('.product-row'),
                amount = 0;
            $.each(rows, function (i, row) {
                let linePrice = $(row).find('.total-line-prices').val();
                if(!linePrice) linePrice = 0
                amount += parseFloat(linePrice)
            });

            // discount(amount)
            let discount = amountManipulation({
                getTargetSelector: '#discount',
                putTargetSelector: '#grandTotal',
                subTotal: amount
            })
            // Paid Amount
            amountManipulation({
                getTargetSelector: '#totalPaid',
                putTargetSelector: '#totalDue',
                subTotal: discount
            })
            return amount.toFixed(2);
        }

        function amountManipulation(settings)
        {
            let amount = $(settings.getTargetSelector).val()

            if (amount > settings.subTotal){
                alert('You can\'t more than that amount')
                $(settings.getTargetSelector).val(0)
                return 0
            }else{
                $(settings.putTargetSelector).val(settings.subTotal - amount);
                return settings.subTotal - amount;
            }
        }




        function row(e)
        {
            return $(e.target).parents('.product-row')
        }

        $(document).on('focus keyup', '.expire-dates', function (e) {
            $(this).datepicker({
                dateFormat: 'yy-mm-dd'
            });

            if (e.keyCode === 13) {
                $('.expire-dates').next().focus();


            }
        })

    </script>




@endsection
