@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-box {
            height: 25px;
        }

        input.form-control.small-label-box {
            height: 26px;
            padding: 1.5px;
            border: 1px solid rgba(180, 180, 180, 0.52) !important;
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
        <form action="{{route('quotations.update', $quotation)}}" method="POST"  class="form-horizontal
        quotation-form">
            @csrf
            @method('patch')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
{{--                        @can('pharmacy-sales-list')--}}
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="{{route('quotations.index')}}">
                                All Quotations
                            </a>
                        </div>
                        {{--@endcan--}}
                        <h4 class="panel-title">Quotation</h4>
                    </div>
                    <div class="panel-body no-padding">

                        <div class="col-md-12">
                            <div class='row'>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Party Name :</label>
                                                <input type="text" name="party_name"
                                                       value="{{$quotation->party->name}}"  id="party_name"
                                                       placeholder="Party's Name"  class="form-control" required>
                                                <input type="hidden" value="{{$quotation->party_id}}" name="party_id"
                                                       id="party_id">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Invoice ID #</label>
                                                <input type="text" tabindex="-1" class="form-control" id="invoice_id"
                                                       placeholder="Invoice ID" name="invoice_id"
                                                       value="{{$quotation->invoice_id}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Date :</label>
                                                <input type="text" name="validity" value="{!! date('d-m-Y');!!}"
                                                       class="form-control datepicker" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Product Name :</label>
                                                <input type="text" name="product_name" id="drug-name"
                                                       class="form-control" placeholder="Search by Product Name /
                                                       Barcode"  autocomplete="off">
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
                                            <th width="10%"> Available </th>
                                            <th width="15%"> Unit TP </th>
                                            <th width="15%"> Sales Price </th>
                                            <th width="10%"> Quantity </th>
                                            <th width="15%"> Total </th>
                                            <th width="1%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="product-details">
                                        @foreach($quotation->items as $item)
                                            <tr class="product-row">
                                                <td>
                                                    <input type="hidden" name="id[]" value="{{$item->id}}">
                                                    <span id="product_name">{{$item->product->name}}</span>
                                                    <input type="hidden" value="{{$item->product_id}}" name="product_id[]"
                                                           id="productId"  class="form-control small-label-box productId"
                                                           autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" tabindex="-1" value="{{$item->product->quantity}}"
                                                           id="available_qty" class="form-control small-label-box available_qty" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="unit_tp[]" class="form-control small-label-box"
                                                           value="{{$item->unit_tp}}">
                                                </td>
                                                <td>
                                                    <input tabindex="-1" type="text" value="{{$item->amount}}"
                                                           name="sales_price[]" class="form-control sales-price small-label-box"
                                                           autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="number" min="1" value="{{$item->quantity}}"  name="quantity[]"
                                                           id="sales_qty"  class="form-control sales-qty small-label-box"
                                                           autocomplete="off" placeholder="Quantity">
                                                </td>
                                                <td>
                                                    <input tabindex="-1" type="number" min="0"
                                                           value="{{$item->unit_price * $item->sales_price}}"
                                                           name="item_price[]" class="form-control total-line-price
                                                   small-label-box" autocomplete="off" readonly>
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-danger delete" tabindex="-1" type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
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
                            <label class="control-label">Shipping Address :</label>
                            <textarea name="shipping_address" class="form-control"
                                      placeholder="Shipping Address" required
                            >{{$quotation->shipping_address}}</textarea>
                        </div>
                        <div class="form-group ">
                            <label class="control-label">Billing Address :</label>
                            <textarea readonly class="form-control" placeholder="Billing Address"></textarea>
                        </div>
                        <hr>

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
                        <div class="form-group aside_system hidden">
                            <label class="control-label">Total Paid</label>
                            <div class="input-group col-md-12">
                                <div class="input-group-addon currency">৳</div>
                                <input value="0" type="number" min="0" step="any" class="form-control" name="paid"
                                       id="amountPaid" placeholder="Paid Amount">

                            </div>
                        </div>
                        <div class="form-group aside_system hidden">
                            <label class="control-label">Change</label>
                            <div class="input-group col-md-12">
                                <div class="input-group-addon currency">৳</div>
                                <input tabindex="-1" value="" type="number" min="0" step="any" class="form-control
                            change"  name="change"  id="change" placeholder="Change Amount" readonly >
                            </div>
                        </div>
                        <div class="form-group aside_system hidden">
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
            select: (event, ui) => {
                $('#party_id').val(ui.item.data.id);
            },
            search: () => {
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
            select:  (event, ui) => {
                appendProductRow(ui)
                calculateTotal();
            }
        });


        $(() => {
            calculateTotal()
            $("#drug-name").focus();
        });

        $(document).on('click', '.delete', (e) => {
            $(e.target).parents('tr').remove();
            calculateTotal();
        })


    </script>


    <script>
        function appendProductRow(ui){
            $('#product-details').append(
                productRow(ui)
            );

            setTimeout(() => $('#drug-name').val(''), 1)
        }


        function productRow(ui)
        {
            return `<tr class="product-row">
                <td>
                    <input type="hidden" name="id[]" value="">
                    <span id="product_name">${ui.item.data.name}</span>
                    <input type="hidden" value="${ui.item.data.id}" name="product_id[]" id="productId"
                    class="form-control small-label-box productId" autocomplete="off">
                </td>
                <td>
                    <input type="text" tabindex="-1" value="${ui.item.data.quantity}"
                    id="available_qty" class="form-control small-label-box available_qty" readonly>
                </td>
                <td>
                    <input type="number" name="unit_tp[]" class="form-control small-label-box"
                        value="${parseFloat(ui.item.data.unit_price).toFixed(2)}">
                </td>
                <td>
                    <input tabindex="-1" type="text" value="${parseFloat(ui.item.data.sales_price).toFixed(2)}"
                    name="sales_price[]" class="form-control sales-price small-label-box" autocomplete="off">
                </td>
                <td>
                    <input type="number" min="1" value="1"  name="quantity[]" id="sales_qty" class="form-control
                    sales-qty small-label-box" autocomplete="off" placeholder="Quantity">
                </td>
                <td>
                    <input tabindex="-1" type="number" min="0" value="${parseFloat(ui.item.data.sales_price).toFixed(2)}"
                        name="item_price[]" class="form-control total-line-price small-label-box" autocomplete="off"
                        readonly>
                </td>
                <td>
                    <button class="btn btn-xs btn-danger delete" tabindex="-1" type="button">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>`
        }
    </script>

    <script>


        $(document).on('keyup focus blur',
            '.sales-price, .sales-qty, .discount, #amountPaid',
            () => calculateTotal()
        );


        function calculateTotal() {
            let subTotal = linePrice(),
                total = discount(subTotal),
                payableAmount = grandTotal(parseFloat(total));
            dueAmount(payableAmount);
        }
        function linePrice(){
            let rows = $('.product-row'),
                totalDrugPrice = 0, amount = 0;
            $.each(rows, (i, row) => {
                let quantity = $(row).find('.sales-qty').val(),
                    salesPrice = $(row).find('.sales-price').val();

                if (!quantity)  quantity = 0;
                if(!salesPrice) salesPrice = 0;
                let  totalDrugPrice = (quantity * salesPrice);
                $(row).find('.total-line-price').val(parseFloat(totalDrugPrice).toFixed(2));
                amount += totalDrugPrice;
            });
            $('#subTotal').val(parseFloat(amount).toFixed(2));
            return parseFloat(amount).toFixed(2);
        }

        function discount(stotal){
            let discountAmount = parseFloat($('.discount').val()),
                subTotal = parseFloat(stotal);
            if(!discountAmount) discountAmount = 0;
            if (discountAmount > subTotal){
                $('.discount').val(0);
                alert('You can\'t pay more than grand total.');
            }
            let total = (subTotal -  discountAmount).toFixed(2)
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
