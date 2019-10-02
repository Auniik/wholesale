var i=$('#table_auto tr').length;
$(".addmore").on('click',function(){


    html ='<tr>';
    html += '<td><input type="text" name="sales_person_name[]" id="itemName_1" required class="form-control autocomplete_txt" autocomplete="off"><input type="hidden" name="fk_product_id[]" id="itemId_1" class="form-control" autocomplete="off"><input type="hidden" name="model[]" id="model_1" class="form-control"></td>';
    html += '<td><input type="text" data-type="designation[]" name="designation[]" id="description_1" class="form-control autocomplete_txt"></td>';
    html += '<td><input type="text" name="mobile[]"  class="form-control"></td>';
    html += '<td><input type="text"  name="email[]"  class="form-control"></td>';
    html += '<td><input type="text"  name="division[]"  class="form-control"></td>';
    html += '<td><input class="form-control datepicker" type="text" name="date_of_birth[]" /></td>';
    html += '<td><input type="text"  name="remarks[]"  class="form-control " ></td>';

    html +='<td><button type="button" class="btn btn-danger btn-xs deleteBtn"> <i class="fa fa-trash"></i> </button></td>';
    html += '</tr>';
    $('#table_auto').append(html);
    i++;
    $('.select').chosen("liszt:updated");

});

$(document).on('click','.deleteBtn',function(){
    $(this).parents("tr").remove();
    calculateTotal();
});

var i=$('#table_product tr').length;
$(".addmoreproduct").on('click',function(){


    html ='<tr>';
    html += '<td><input type="text" name="product_name[]" id="itemName_'+i+'" required class="form-control autocomplete_txt" autocomplete="off"></td>';

    html +='<td><button type="button" class="btn btn-danger btn-xs deleteBtn"> <i class="fa fa-trash"></i> </button></td>';
    html += '</tr>';
    $('#table_product').append(html);
    i++;
    $('.select').chosen("liszt:updated");

});

$(document).on('click','.deleteBtn',function(){

    $(this).parents("tr").remove();
    calculateTotal();
});


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
            $('#uom_'+id[1]).html(items.unit_name);
            $('#quantity2_'+id[1]).val(1);

            calculateTotal();
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
