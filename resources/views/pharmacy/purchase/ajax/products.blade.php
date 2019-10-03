
@forelse($products as $product)
    {{--@dd($product)--}}
    <tr class="product-row">
        <td>
            <span>{{$product->name}}</span>
            {{--<input type="text" id="drug-name" value="" class="form-control small-label-box drug-name"
            placeholder="Product Name" autocomplete="off">--}}
            <input type="hidden" value="{{$product->id}}" name="product_id[]" tabindex="-1" class="product-ids"
                   id="product_id">
        </td>
        <td >
            <input type="text" value="" name="product_code_id[]" tabindex="-1" autocomplete="off" class="form-control
                   small-label-box
            product-code-ids" id="product_code_id">
        </td>
        <td>
            <input type="number" name="unit_tp[]" min="0" step="any" tabindex="-1" autocomplete="off" ondrop="return false;"
                   required
                   value="{{$product->retail_unit_tp * $product->pack_size}}" id="unit_tp" class="form-control
                   small-label-box unit-tps">
        </td>
        <td>
            <input type="number" name="sales_price[]" min="0" step="any" tabindex="-1" placeholder="Sales Price" required
                   value="{{$product->retail_sales_price * $product->pack_size}}" class="form-control small-label-box
                    sales-prices">
        </td>

        <td>
            <input type="number" name="quantity[]" min="0" value="0" autocomplete="off" class="form-control
            small-label-box quantities"  ondrop="return false;" placeholder="Qty" required>
            <input type="hidden" name="retail_quantity[]" min="0" class="retail-quantities" >
        </td>

        <td>
            <input type="text" name="expiry_date[]" class="form-control small-label-box expire-dates"
                   placeholder="Expiry Date" autocomplete="off">
        </td>
        <td>
            <input value="0" name="total_price[]" type="number" min="0" step="any" autocomplete="off" tabindex="-1"
                   placeholder="Sub Total" class="form-control small-label-box total-line-prices" readonly>
        </td>
        {{--<td>--}}
        {{--<button class="btn btn-xs btn-danger delete"  type="button"><i class="fa fa-trash-o"></i></button>--}}
        {{--</td>--}}
    </tr>
@empty
    <h5 class="text-danger text-center">No Product Found</h5>
@endforelse
