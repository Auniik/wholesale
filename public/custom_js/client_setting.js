var i=$('#table_auto tr').length;
$(".addmore").on('click',function(){


    html ='<tr>';
    html += '<td><div class="col-md-12 no-padding"><input type="text" name="buyer_name[]" class="form-control" required></div></td>';

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