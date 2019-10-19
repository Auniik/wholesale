@extends('layout.app')
@push('style')
    <style>
        input.form-control.small-label-box {
            height: 27px;
            padding: 1.5px;
            /*border: 1px solid rgba(180, 180, 180, 0.52) !important;*/
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
        <form action="{{route('challans.store', $quotation->id)}}" method="POST" class="form-horizontal challan-form">
            @csrf
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
{{--                        @can('pharmacy-sales-list')--}}
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="{{route('challans.index', $quotation)}}">
                                All Added Challans
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
                                                <input type="text" name="party_name" id="party_name"
                                                       placeholder="Party Name"
                                                       value="{{$quotation->party->name}}" class="form-control"
                                                       required readonly>
                                                <input type="hidden" name="party_id"
                                                       value="{{$quotation->party_id}}" id="party_id">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Invoice ID #</label>
                                                <input type="text" tabindex="-1" class="form-control" id="invoice_id"
                                                       placeholder="Invoice ID" name="invoice_id"
                                                       value="{{$challan_id+1}}"  readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Date :</label>
                                                <input type="text" name="date" value="{!! date('d-m-Y');!!}"
                                                       class="form-control datepicker" autocomplete="off">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <br>
                                    <table class="table table-bordered table-hover" id="table_auto">
                                        <thead>
                                        <tr>
                                            <th> Product Name </th>
                                            <th width="20%"> Product Code </th>
                                            <th width="20%"> Available </th>
                                            <th width="20%"> Quantity </th>
                                        </tr>
                                        </thead>
                                        <tbody id="product-details">
                                        <input type="hidden" value="{{$quotation->id}}" name="quotation_id">
                                        @foreach($quotation->items as $item)

                                        <tr class="product-row">
                                            <td>
                                                <input type="hidden" class="quotation_item_id" value="{{$item->id}}"
                                                       name="quotation_item_id[]">
                                                <span id="product_name">{{$item->product->name}}</span>
                                                <input type="hidden" value="{{$item->product_id}}" name="product_id[]"
                                                       id="productId" class="productId">
                                            </td>
                                            <td>
                                                <input type="text" tabindex="-1" name="product_code_name[]"
                                                       id="product_code_name" class="form-control small-label-box
                                                       product-code-names" placeholder="Search Codes">
                                                <input type="hidden" id="product_code_id" name="product_code_id[]"
                                                       class="product_code_id">
                                            </td>
                                            <td>
                                                <input type="text" tabindex="-1" value="{{$item->product->quantity}}"
                                                       name="available_qty[]" class="form-control small-label-box
                                                       available_qty" readonly>
                                            </td>
                                            <td>
                                                <input type="number" min="0" value="{{$item->availableQty}}"
                                                       name="quantity[]" id="sales_qty" class="form-control
                                                    sales-qty small-label-box" autocomplete="off" placeholder="Quantity">
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Mode of Transport :</label>
                                        <input type="text" name="transport_mode" value="" class="form-control"
                                               autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Shipping Address :</label>
                                        <textarea name="shipping_address" required
                                                  class="form-control" placeholder="Shipping Address"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Billing Address :</label>
                                        <textarea readonly class="form-control" placeholder="Billing Address"></textarea>
                                    </div>
                                    <div class="form-group aside_btn">
                                        <button type="submit" name="draft" class="btn btn-success" style="width: 100%;
">Confirm</button>
                                    </div>
                                </div>
                            </div>
                            <br><br>
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

        $(document).on('focus', '.product-code-names', function (e) {

            let row  = $(e.target).parents('.product-row')

            $(this).autocomplete({
                source: function(request, response){
                    $.getJSON("{{url('get_codes')}}/"+ row.find('.productId').val(),
                        {name: request.term},
                        function (data) {
                            response($.map(data, function (item) {
                                return {
                                    data: item,
                                    value: item.name,
                                    label: item.name
                                };
                            }))
                        }
                    )
                },
                select: (event, ui) => {
                    row.find('.product_code_id').val(ui.item.data.id)
                    row.find('.product-code-names').removeClass('has-error')
                    row.find('.available_qty').val(ui.item.data.quantity)
                },
                search: (event) => {
                    row.find('.product_code_id').val('')
                    row.find('.product-code-names').addClass('has-error')
                    row.find('.available_qty').val(0)
                },
                minLength: 1,
                autoFocus: true
            })
        })

        $(function (e) {
            let rows = $('.product-row');

            $.each(rows, (i, row) => {
                let availableQuantity = parseFloat($(row).find('.available_qty').val());
                let challanQuantity = parseFloat($(row).find('.sales-qty').val());

                if (availableQuantity === 0 || challanQuantity === 0) {

                    $(row).find('.product-code-names').attr('readonly', true).removeAttr('name')
                    $(row).find('.sales-qty').attr('readonly', true).removeAttr('name')
                    $(row).find('.available_qty').removeAttr('name')
                    $(row).find('.product_code_id').removeAttr('name')
                    $(row).find('.productId').removeAttr('name')
                    $(row).find('.quotation_item_id').removeAttr('name')
                }
            })
        })
    </script>


@endsection
