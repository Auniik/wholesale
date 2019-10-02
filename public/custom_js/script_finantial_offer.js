

//adds extra table rows
var i=$('#table_auto tr').length;
$(".addmore").on('click',function(){
    html = '<tr>';
    html += '<td><input tabindex="-1" class="case" type="checkbox"/></td>';
    html += '<td><input type="text" name="product_name[]" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off"><input type="hidden" name="fk_product_id[]" id="itemId_'+i+'"><input type="hidden" name="model[]" id="model_'+i+'"></td>';
    html += '<td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#descriptionModel_'+i+'">Description</button><!-- Modal --><div class="modal fade" id="descriptionModel_'+i+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog" role="document"> <div class="modal-content">     <div class="modal-header">  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  <h4 class="modal-title" id="myModalLabel">'+i+'.  Product Others Description (If any) </h4> </div> <div class="modal-body"><input type="hidden" name="product_id_'+i+'" id="product_id_'+i+'" class="form-control" autocomplete="off"><textarea rows="10" class="form-control tinymceSimple" name="short_description[]" id="description_'+i+'"></textarea> </div> <div class="modal-footer">  <button type="button"  onclick="updateDescription(this)" class="btn btn-info" data-dismiss="modal">Save</button> </div> </div>    </div></div></td>';
    html += '<td><input type="number" min="0" name="qty[]" step="any" id="quantity2_'+i+'" class="form-control quantity changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" placeholder="Quantity"></td>';
    html += '<td><span id="smallUnit_'+i+'">Unit</span></td>';
    html+='<td> <button onclick="costPrice(this.id)" id="costPrice_'+i+'" data="0" type="button" class="btn btn-default form-control costPrice">Click</button> </td>';

    html += '<td><input type="text" min="0" name="unit_price[]" step="any" id="hidden_'+i+'" class="form-control sales_price changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" ></td>';
    html += '<td><input type="text" min="0" step="any" name="discount[]" id="discount_'+i+'" class="form-control sales_price changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
    html += '<td><input type="text" min="0" step="any" name="ait[]" id="ait_'+i+'" class="form-control sales_price changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
    html += '</tr>';
    $('#table_auto').append(html);
    $('#itemName_'+i).focus();
    i++;
});

//to check all checkboxes
$(document).on('change','#check_all',function(){
    $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
    $('.case:checkbox:checked').parents("tr").remove().html("Pending for next challan");
    $('#check_all').prop("checked", false);
    calculateTotal();
});

//autocomplete script
$(document).on('focus','.autocomplete_txt',function(){
    var path=$('#rootUrl').val();
    $(this).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: path+'/product-search',
                type: "GET",
                dataType: "json",
                data: {
                    name: request.term,
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.product_name,
                            value: item.product_name,
                            data : item
                        }
                    }));
                }
            });
        },

        autoFocus: true,
        minLength: 0,
        appendTo: "#modal-fullscreen",
        select: function( event, ui ) {
            var items = ui.item.data;
            id_arr = $(this).attr('id');
            id = id_arr.split("_")[1];
            // console.log($('#description_'+id)[0].html);
            $('#itemId_'+id).val(items.id);
            $('#model_'+id).val(items.products_model);
            $('#description_'+id).html(items.specification);
            $('#product_id_'+id).val(items.id);
            // console.log($('#description_'+id))
            $('#smallUnit_'+id).html(items.unit_name);
            $('#costPrice_'+id).attr('data',items.cost_per_unit);
            $('#quantity2_'+id).val(1);
            // $('#quantity2_'+id).attr('max',items.available_qty);
            $('#cost_'+id).val(items.sales_per_unit);
            $('#hidden_'+id).val(items.sales_per_unit);
            $('#total_'+id).val( 1*items.sales_per_unit );
            $('#discount_'+id).val(0);
            $('#ait_'+id).val(0);
            $('#quantity2_'+id).select();

            $('#quantity2_'+id).focusout(function(){
                var quantity1 = $('#quantity_'+id).val();
                var quantity2 = $('#quantity2_'+id).val();

                if(parseInt(quantity1) < parseInt(quantity2)){
                    /*alert("Your store doesn't have sufficient stock");*/
                }
            })

            calculateTotal();
        }
    });

});
$(document).on('change keyup keypress blur','.changesNo', function(){
    var  bdtPrice=0;
    var  usdPrice=0;
    var discountAmount = 0;
    var aitValue  = 0;
    $('.quantity').each(function(){
        var id = $(this).attr('id').split('_')[1];
        var qty = parseFloat($(this).val());
        var price = parseFloat($('#hidden_'+id).val());
        var discount = parseFloat($('#discount_'+id).val());
        var ait = parseFloat($('#ait_'+id).val());
        var aitAmount = parseFloat((price - discount)*ait)/100;
        bdtPrice+=(qty*price);
        discountAmount+=discount;
        aitValue+=aitAmount;
    });
    var perc = parseFloat($('#vatP').val());

    var subtotal = parseFloat($('#subT').val());
    $('#totalAmount').val(bdtPrice);
    $('#totalDiscount').val(discountAmount);
    $('#subT').val(bdtPrice - discountAmount);
    $('#aitPercentage').val(aitValue);
    $('#vatTaka').val(Math.round((subtotal * perc)/100));

    var vattotal = parseFloat($('#vatTaka').val());
    var aittotal = parseFloat($('#aitPercentage').val());
    $('#totalTaka').val(subtotal+vattotal+aittotal);
});

//price change
$(document).on('change keypress keyup blur','.changesNo',function(){
    id_arr = $(this).attr('id');
    var id = id_arr.split("_")[1];
    var quantity = $('#quantity2_'+id).val();
    var price = $('#hidden_'+id).val();
    var amount=price;
    if( quantity!='' && amount !='') $('#total_'+id).val( (parseFloat(amount)*parseFloat(quantity)));

    calculateTotal();
});

$(document).on('change keyup keypress blur','.changesNo',function(){
    calculateTotal();
});

//total price calculation
function calculateTotal(){
    subTotal = 0 ; total = 0; prev=0;
    $('.totalLinePrice').each(function(){
        if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
    });
    $('#subTotal').val( subTotal );
    var discount =0;
    if($('#discount').val()!=''){
        discount =parseFloat($('#discount').val());
    }
    if($('#prev_amount').val()){
        prev =  $('#prev_amount').val();
    }
    if(prev){
        $('#grandTotal').val(parseFloat(prev)+subTotal-discount);
    }
    $('#total').val( subTotal-discount );
    calculateAmountDue();
}
$(document).on('change keyup blur','#amountPaid',function(){
    calculateAmountDue();
});

//due amount calculation
function calculateAmountDue(){
    total = $('#grandTotal').val();
    amountPaid = $('#amountPaid').val();

    //amountPaid1 = $('#amountPaid1').val();
    if(amountPaid != '' && typeof(amountPaid) != "undefined" ){
        amountDue = parseFloat(total) - parseFloat( amountPaid );
        $('.amountDue').val( amountDue );
    }else{
        total = parseFloat(total);
        $('.amountDue').val( total);
    }

}

$(document).on('keyup blur change','.sales_price',function(){
    var id = $(this).attr('id').split('_')[1];
    var  cost = parseFloat($('#costPrice_'+id).attr('data'));
    var sales = parseFloat($(this).val());
    if(cost>sales){
        $(this).addClass('danger');

    }else{

        $(this).removeClass('danger');
    }
});


//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    //console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}
$('input').keydown(function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 13) {
        /*var inputs = $(this).parents("form").eq(0).find(":input").not(':input.btn-not');
        console.log(inputs);
        if (inputs[inputs.index(this) + 1] != null) {
            inputs[inputs.index(this) + 1].focus();
        }*/
        e.preventDefault();
        return false;
    }
});
$('body').keypress(function (e) {
    var keyCode = e.keyCode || e.which;
    if(keyCode==83){
        $('form.sales-form').submit();

    }
});
$(window).on("beforeunload", function() {
    return "Are you sure? You didn't finish the form!";
});
$("form.sales-form").on("submit", function(e) {
    $(window).off("beforeunload");
    return confirm("Are you confirm?");
});
