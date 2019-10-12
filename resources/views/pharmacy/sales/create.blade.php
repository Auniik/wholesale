@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 25px;
        }
        .aside_system{
            margin-bottom: 0px;
        }
        .aside_btn{
            margin-top: 20px;
        }
    </style>
@endpush
@section('content')
<div class="row">
    <form action="{{route('product.sales.store')}}" method="POST"  class="form-horizontal sales-form">
        @csrf
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('pharmacy-sales-list')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="{{route('product.sales.index')}}">
                                All Added Product
                            </a>
                        </div>
                    @endcan
                    <h4 class="panel-title">Product Sales</h4>
                </div>
                <div class="panel-body no-padding">

                    <div class="col-md-12">
                        <div class='row'>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Customer Name :</label>
                                            <input type="text" name="party_name" id="party_name"
                                                   placeholder="Customer's Name"  class="form-control" required>
                                            <input type="hidden" name="party_id" id="party_id">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Product Name :</label>
                                            <input type="text" name="product_name" id="drug-name"
                                                   class="form-control" placeholder="Search by Product Name / Barcode" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"> <br>
                            <div class="col-md-12">

                                <table class="table table-bordered table-hover" id="table_auto">
                                    <thead>
                                    <tr>
                                        <th> Product Name </th>
                                        <th width="18%"> Code </th>
                                        <th width="10%"> Available </th>
                                        <th width="10%"> Quantity </th>
                                        <th width="15%"> Sales Price </th>
                                        <th width="15%"> Total </th>
                                        <th width="1%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="product-details">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Payment</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group aside_system">
                        <label class="control-label">Sub Total</label>
                        <div class="input-group col-md-12">
                            <div class="input-group-addon currency">৳</div>
                            <input tabindex="-1" value="0" type="number" min="0" step="any"
                                   class="form-control" name="amount" id="subTotal" placeholder="Sub Total"readonly>
                        </div>
                    </div>


                    <div class="form-group aside_system">
                        <label class="control-label">Discount</label>
                        <div class="input-group col-md-12">
                            <div class="input-group-addon currency">৳</div>
                            <input value="0" type="number" min="0" step="any" class="form-control changesNo discount"
                                   name="discount" id="discount" placeholder="Discount" tabindex="-1">
                        </div>
                    </div>
                    <div class="form-group aside_system">
                        <label class="control-label">Grand Total</label>
                        <div class="input-group col-md-12">
                            <div class="input-group-addon currency">৳</div>
                            <input tabindex="-1" value="" type="number" min="0" step="any"
                                   class="form-control"  name="grand_total" id="grandTotal"
                                   placeholder="Grand Total" readonly>
                        </div>
                    </div>
                    <div class="form-group aside_system">
                        <label class="control-label">Total Paid</label>
                        <div class="input-group col-md-12">
                            <div class="input-group-addon currency">৳</div>
                            <input value="0" type="number" min="0" step="any" class="form-control" name="paid"
                                   id="amountPaid" placeholder="Paid Amount" >

                        </div>
                    </div>
                    <div class="form-group aside_system">
                        <label class="control-label">Change</label>
                        <div class="input-group col-md-12">
                            <div class="input-group-addon currency">৳</div>
                            <input tabindex="-1" value="" type="number" min="0" step="any" class="form-control
                            change"  name="change"  id="change" placeholder="Change Amount" readonly >
                        </div>
                    </div>
                    <div class="form-group aside_system">
                        <label class="control-label">Total Due</label>
                        <div class="input-group col-md-12">
                            <div class="input-group-addon currency">৳</div>
                            <input tabindex="-1" value="" type="number" min="0" step="any" class="form-control
                            amountDue"  name="due_amount"  id="amountDue" placeholder="Amount Due" readonly >

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-8 pull-right">
                            <div class="form-group aside_btn">
                                <button type="submit" name="draft" class="btn btn-primary" style="width: 100%;">Confirm</button>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="from-group aside_btn">
                                <button type="submit" name="confirm" class="btn btn-success" style="width: 100%">Draft</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('script')
    <script src="{{asset('custom_js/loadDetails.js')}}"></script>
    <script>
        loadDetails({
            type: 'name',
            selector: '#party_name',
            url: '{{'/load-parties'}}',
            select: function(event, ui){
                $('#party_id').val(ui.item.data.id);
            },
            search: function(){
                if($('#party_id').val()){
                    $('#party_name').val('');
                }
                $('#party_id').val('');

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
            if (ui.item.data.quantity !== 0){

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
                    <span id="product_name">${ui.item.data.name}</span>
                    <input type="hidden" value="${ui.item.data.id}" name="product_id[]" id="productId"
                    class="form-control small-box productId" autocomplete="off">
                </td>
                <td>
                   <input type="text" class="form-control small-box code_names" autocomplete="off" required>
                    <input type="hidden" name="product_code_id[]" class="product_code_ids">
                </td>
                <td>
                    <input type="text" tabindex="-1" value="${ui.item.data.quantity}" name="available_qty[]"
                    id="available_qty" class="form-control small-box available_qty" readonly>
                </td>
                <td>
                    <input type="number" min="1" value="1"  name="sales_qty[]" max="${ui.item.data.quantity}"
                    id="sales_qty" class="form-control sales-qty small-box" autocomplete="off" placeholder="Quantity">
                </td>
                 <!--td><span id="uom"></span> </td-->
                <td>
                    <input tabindex="-1" type="text" value="${parseFloat(ui.item.data.sales_price).toFixed(2)}"
                    name="sales_price[]" class="form-control sales-price small-box" readonly>
                </td>
                <td>
                    <input tabindex="-1" type="number" min="0" value="${parseFloat(ui.item.data.sales_price).toFixed(2)}"
                        name="item_price[]" class="form-control total-line-price small-box" autocomplete="off" readonly>
                </td>
                <td>
                    <button class="btn btn-xs btn-danger delete" tabindex="-1" type="button"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>`
        }
    </script>

    <script>
        $(document).on('keyup focus blur', '.sales-qty, .discount, #amountPaid, .code_names', function (e) {
            calculateTotal();

            availableCheck(e);
        });

        function availableCheck(e) {
            let row = $(e.target).parents('.product-row')
            let qty = parseFloat(row.find('.sales-qty').val())
            let available = parseFloat(row.find('.available_qty').val())

            if(qty > available){
                row.find('.sales-qty').val(available);
            }
        }


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

    <script>
        $(document).on('focus', '.code_names', function (e) {
            $(this).autocomplete({
                source: function(request, response){
                    $.getJSON("{{url('get_codes')}}/"+$(this.element).parents('.product-row').find('.productId').val(),
                        {name: request.term},
                        function (data) {
                            response($.map(data, function (item) {
                                return {
                                    data: item,
                                    value: item.name,
                                    label: item.name +" ("+item.quantity+")"
                                };
                            }))
                        }
                    )
                },
                select: function(event, ui){
                    let row = $(event.target).parents('.product-row');
                    if (ui.item.data.quantity !== 0){
                        row.find('.available_qty').val(ui.item.data.quantity)
                        row.find('.product_code_ids').val(ui.item.data.id)
                        row.find('.code_names').removeClass('has-error');
                    }
                    else {
                        alert('Product is not available in stock under that code.');
                        row.find('.code_names').addClass('has-error');
                        row.find('.product_code_ids').val(null);
                        calculateTotal();
                    }

                },
                search: function(event, ui){
                    $(event.target).parents('.product-row').find('.available_qty').val(0)
                },
                minLength: 1,
                autoFocus: true,

            })

        })



    </script>


@endsection
