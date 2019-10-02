
//adds extra table rows
var i=$("#table_auto tr").length;
$(".addmore").on("click",function(){
	html = '<tr>';
	html += '<td><input placeholder="Product Name"  type="text" data-type="product_name" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off"><input type="hidden" name="fk_product_id[]" id="itemId_'+i+'" class="form-control" autocomplete="off" ></td>';
	html += '<td><input type="text" name="product_model[]" id="productModel_'+i+'" class="form-control model_search" placeholder="Model"></td>';
	html += '<td><input type="number" min="0" step="any" name="cost_per_unit[]" id="cost_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" placeholder="Unit Price" ><input type="hidden" value="0" min="0" step="any" name="sales_per_unit[]" class="form-control"changesNo placeholder=" Sales Price" ></td>';
	html += '<td><input type="number" min="0" step="any" name="qty[]" id="quantity2_'+i+'" class="form-control changesNo quantity" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" placeholder="Qty"></td>';
	html += '<td><span id="uom_'+i+'">Unit</span></td>';
	html += '<td><input type="number" min="0" step="any" name="vat[]" id="vat_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" placeholder="VAT" ></td>';
	html += '<td><input type="number" min="0" step="any" name="ait[]" id="ait_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" placeholder="AIT" ></td>';
	html += '<td><input type="number" min="0" step="any" name="amount[]" id="total_'+i+'" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" placeholder="Sub Total" readonly></td>';
	html +=' <td><button class="btn btn-xs btn-danger deleteRow"> <i class="fa fa-trash"></i> </button></td>';
	html += '</tr>';
	$('#table_auto').append(html);
	i++;
});

//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});


$(document).on('click','.deleteRow',function(){
    if($('#table_auto tr').length>2){
        $(this).parents('tr').remove();

    }
})
//autocomplete script
var path = $('#rootUrl').val();
$(document).on('focus','.autocomplete_txt',function(){

	$(this).autocomplete({
		source: function( request, response ) {
            $.ajax({
                url: path+'/product-search',
                type: "GET",
                dataType: "json",
                data: {
                    name_startsWith: request.term,
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
	  		id = id_arr.split("_");
			$('#itemName_'+id[1]).val(items.product_name);
			$('#itemId_'+id[1]).val(items.id);
			$('#productModel_'+id[1]).val(items.model);
			$('#uom_'+id[1]).html(items.unit_name);
			$('#quantity2_'+id[1]).val(1);
			$('#ait_'+id[1]).val(0);
			$('#vat_'+id[1]).val(0);


		}		      	
	});
});
/* Model Search */
$(document).on('focus keyup','.model_search',function(){

	$(this).autocomplete({
		source: function( request, response ) {
            $.ajax({
                url: path+'/model-search',
                type: "GET",
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    },
                success: function( data ) {

					 response( $.map( data, function( item ) {

						return {
							label: item.model_name,
							value: item.model_name,
						}
					}));
				}
            });
		},
		autoFocus: true,
        minLength: 0,
	});
});


$(document).on('change keyup keypress blur','.changesNo',function(){
    var  subTotal=0;
    var  vatTotal=0;
    var  aitTotal=0;

    $('.quantity').each(function(){
        var id = $(this).attr('id').split('_')[1];
        var qty = parseFloat($('#quantity2_'+id).val());
        var cost = parseFloat($('#cost_'+id).val());
		var vat = parseFloat($('#vat_'+id).val());
		var ait = parseFloat($('#ait_'+id).val());
		var total = parseFloat($('#total_'+id).val());
        subTotal+=(qty*cost);
        vatTotal+=(vat);
        aitTotal+=(ait);
		$('#total_'+id).val((qty*cost)+vat+ait);

    });

    $('#subTotal').val(subTotal);
    $('#vatTotal').val(vatTotal);
    $('#aitTotal').val(aitTotal);
    $('#amountTotal').val(subTotal+vatTotal+aitTotal);
});

//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}




