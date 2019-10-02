@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 25px;
        }
    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @can('pharmacy-sales-list')
                <div class="panel-heading-btn pull-right">
                    <a class="btn btn-success btn-sm" href="{{route('inventory-product-sales.index')}}">View All</a>
                </div>
                @endcan
                <h4 class="panel-title">Item Sales</h4>
            </div>
            <!-- <input type="text" style="border:0;border-color: #fff;outline: 0;height: 1px;color: #fff"> -->
            <div class="panel-body no-padding" id="tabArea">
                <form method="POST" action="{{route('inventory-product-sales.store')}}" accept-charset="UTF-8" class="form-horizontal sales-form" role="form" data-parsley-validate novalidate>
                    @csrf
                    <div class="col-md-12">
                        <div class='row'>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Customer Name :</label>
                                            <input type="text" name="customer_name" id="customer_name"
                                                   placeholder="Customer's Name"  class="form-control" required>
                                            <input type="hidden" name="customer_id" id="customer_id">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Invoice ID #</label>
                                            <input type="text" tabindex="-1" class="form-control" id="invoice_id" placeholder="Invoice ID" name="invoice_id" value="{{$invoice_id+1}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Date :</label>
                                            <input type="text" value="{!! date('d/m/Y');!!}"
                                                   class="form-control" readonly autocomplete="off">
                                            <input type="hidden" name="date" value="{!! date('Y-m-d');!!}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Product Name :</label>
                                            <input type="text" name="product_name" id="drug-name"
                                                   class="form-control" placeholder="Search by Product Name / Barcode" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- transition -->

                        <div class="view_center_folwchart">
                            <div class='row'>
                                <div class='col-md-8'>
                                    <table class="table table-bordered table-hover" id="table_auto">
                                        <thead>
                                            <tr>
                                                <th width="15%"> Available Qty </th>
                                                <th> Product Name </th>
                                                <th width="18%"> Quantity </th>
                                                <th width="15%"> Sales Price </th>
                                                <th width="15%"> Total </th>
                                                <th width="1%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product-details"></tbody>
                                    </table>
                                </div>
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Sub Total :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input tabindex="-1" value="0" type="number" min="0" name="subtotal" step="any" class="form-control" id="subTotal" placeholder="Sub Total"  ondrop="return false;" onpaste="return false;" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Discount :</label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input value="0" type="number" min="0" step="any" class="form-control
                                            changesNo discount" name="discount" id="discount" placeholder="Discount"
                                                   ondrop="return false;" tabindex="-1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><b>Total :</b></label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input tabindex="-1" value="0" type="number" min="0" step="any" class="form-control" name="total_amount" id="total" placeholder="Total Amount"  ondrop="return false;" onpaste="return false;" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><b> Grand Total: </b></label>
                                        <div class="input-group col-md-8">
                                            <div class="input-group-addon currency">৳</div>
                                            <input tabindex="-1" value="" type="number" min="0" step="any" class="form-control" name="grand_total" id="grandTotal" placeholder="Total Amount"  ondrop="return false;" onpaste="return false;" readonly>
                                        </div>
                                    </div>
                                    <div id="payment">
                                        <div class="form-group aside_system">
                                            <label class="col-md-4 control-label">Paid Amount :</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-addon currency">৳</div>
                                                <input value="0" type="number" min="0" step="any" class="form-control" name="paid_amount" id="amountPaid" placeholder="Paid Amount"  ondrop="return false;" onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="col-md-4 control-label">Change :</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-addon currency">৳</div>
                                                <input tabindex="-1" value="" type="number" min="0" step="any" class="form-control change" name="change_amount"  id="change" placeholder="Change Amount" ondrop="return false;" onpaste="return false;" readonly >
                                            </div>
                                        </div>
                                        <div class="form-group aside_system">
                                            <label class="col-md-4 control-label">Amount Due :</label>
                                            <div class="input-group col-md-8">
                                                <div class="input-group-addon currency">৳</div>
                                                <input tabindex="-1" value="" type="number" min="0" step="any" class="form-control amountDue" name="due_amount"  id="amountDue" placeholder="Amount Due" ondrop="return false;" onpaste="return false;" readonly >
                                            </div>
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
                                        <div class="col-md-6"></div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <br>
                            <div class='row'>
                                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5  pull-right">

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="{{asset('custom_js/loadDetails.js')}}"></script>
    <script>
        loadDetails({
            type: 'name',
            selector: '#patient_name',
            url: '{{'/loadPatient'}}',
            select: function(event, ui){
                $('#patient_id').val(ui.item.data.id);
            },
            search: function(){
                if($('#patient_id').val()){
                    $('#patient_name').val('');
                }
                $('#patient_id').val('');

            }
        })
    </script>
    <script>
        loadDetails({
            type: 'nameWithQuantity',
            selector: '#drug-name',
            url: '{{'/load-saleable-products'}}',
            select: function (event, ui) {
                appendProductRow(ui)
            }
        });

        $(function() {
            $("#drug-name").focus();
        });



        $(document).on('click', '.delete', function(e){
            $(this).parents('tr').remove();
            calculateTotal();
        })
    </script>


    <script>
        function appendProductRow(ui){
            if (!ui.item.data.retail_quantity == 0){

                $('#product-details').append(
                    productRow(ui)
                );
            }
            else {
                alert('Product is not available in stock');
            }

            setTimeout(function() {
                $('#drug-name').val('');
            }, 1)
        }


        function productRow(ui)
        {
            return `<tr class="product-row">
                <td>
                    <input type="text" tabindex="-1" value="${ui.item.data.retail_quantity}" name="available_qty[]" id="available_qty" class="form-control small-box avaliable_qty" ondrop="return false;" onpaste="return false;" readonly>
                </td>
                <td>
                    <span id="product_name">${ui.item.data.name}</span>
                    <input type="hidden" value="${ui.item.data.id}" name="product_id[]" id="productId"
                    class="form-control small-box productId" autocomplete="off">
                </td>
                <td>
                    <input type="number" min="1" value="1"  name="sales_qty[]" max="${ui.item.data.retail_quantity}" step="any" id="sales_qty" class="form-control sales-qty small-box" autocomplete="off" onkeyup="" onpaste="return false;" placeholder="Quantity">
                </td>
                 <!--td><span id="uom"></span> </td-->
                <td>
                    <input tabindex="-1" type="text" value="${parseFloat(ui.item.data.retail_sales_price).toFixed(2)}" name="sales_price[]" class="form-control sales-price small-box" autocomplete="off" ondrop="return false;" onpaste="return false;" readonly>
                </td>
                <td>
                    <input tabindex="-1" type="number" min="0" value="${parseFloat(ui.item.data.retail_sales_price).toFixed(2)}" step="any" name="item_price[]" class="form-control total-line-price small-box" autocomplete="off"  ondrop="return false;" onpaste="return false;" readonly="readonly">
                </td>
                <td>
                    <button class="btn btn-xs btn-danger delete" tabindex="-1" type="button"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>`
        }
    </script>

    <script>
        $(document).on('keyup focus', '.sales-qty, .discount, #amountPaid', function (e) {

            calculateTotal();
        });
        function calculateTotal() {
            var subTotal = linePrice(),
                total = discount(subTotal),
                payableAmount = grandTotal(parseFloat(total));
            dueAmount(payableAmount);
        }
        function linePrice(){
            var rows = $('.product-row'),
                totalDrugPrice = 0, amount = 0;
            $.each(rows, function (i, row) {
                var quantity = $(row).find('.sales-qty').val(),
                    salesPrice = $(row).find('.sales-price').val(),
                    totalDrugPrice = (quantity * salesPrice);
                if(!quantity || !salesPrice) quantity = 0, salesPrice = 0;
                $(row).find('.total-line-price').val(parseFloat(totalDrugPrice).toFixed(2));
                amount += totalDrugPrice;
            });
            $('#subTotal').val(parseFloat(amount).toFixed(2));
            return parseFloat(amount).toFixed(2);
        }

        function discount(stotal){
            var discount = parseFloat($('.discount').val()),
                subTotal = parseFloat(stotal);
            if (discount > subTotal){
                $('.discount').val(0);
                alert('You can\'t pay more than grand total.');
            }
            var total = (subTotal -  discount).toFixed(2)
            $('#total').val(total);
            return total;
        }

        function grandTotal(total){
            $('#grandTotal').val(parseFloat(total).toFixed(2));
            return total;
        }

        function dueAmount(payableAmount){
            let paidAmount = parseFloat($('#amountPaid').val());
            if (!paidAmount) paidAmount = 0;
            if (paidAmount >= payableAmount){
                $('#change').val(paidAmount - payableAmount);
                $('#amountDue').val(0);
            }
            else{
                $('#change').val(0);
                $('#amountDue').val(payableAmount - paidAmount);
            }
        }

    </script>


@endsection
