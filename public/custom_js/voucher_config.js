
//Add More Row
$(document).on('click', '.addBtn', function () {
    $('.account-row').append(`
        <tr class="record-row">
            <input type="hidden" name="id[]">
            <td>
                <div class="col-md-12 no-padding">
                    <input type="text" name="chart_of_account[]" class="form-control small-box chart_of_accounts" autocomplete="off" required>
                    <input type="hidden" name="chart_of_account_id[]" class="form-control small-box chart_of_account_ids" autocomplete="off" required>
                </div>
            </td>
            <td>
                <input type="text" data-type="description[]" name="description[]" autocomplete="off" class="form-control small-box descriptions autocomplete_txt">
            </td>
            <td>
                <input type="number" style="text-align: right;"  min="0" name="payable_amount[]" class="form-control small-box payable_amounts" required>
            </td>
            <td>
                <input type="number" style="text-align: right;"  value="0" min="0" name="paid_amount[]" class="form-control small-box paid_amounts" required>
            </td>
            <td>
                <button type="button" class="btn btn-success btn-xs addBtn" tabindex="-1"> <i class="fa fa-plus"></i> </button>
                <button type="button" class="btn btn-danger btn-xs deleteBtn" tabindex="-1"> <i class="fa fa-trash"></i> </button>
            </td>
        </tr>
    `)
})



//Voucher Calculations
$(document).on('focus keyup','.payable_amounts, .paid_amounts', function () {
    sectorCalculation();
});
function sectorCalculation(){
    let rows = $('.record-row'),
        totalPayable = 0,
        totalPaid = 0;
    $.each(rows, function (i, row) {
        let payable = parseFloat($(row).find('.payable_amounts').val());
        let paid = parseFloat($(row).find('.paid_amounts').val());
        if (!payable) payable = 0;
        if (!paid) paid = 0;
        if (paid > payable){
            alert('Paid Amount is greater than Payable Amount!')
            $(row).find('.paid_amounts').val(payable);
        }
        totalPayable += payable;
        totalPaid += paid;
    });
    $('#totalPayable').val(totalPayable);
    $('#totalPaid').val(totalPaid);
    $('#amountDue').val(totalPayable - totalPaid);
}

//User Friendly Configs
$(document).on('keydown', '.paid_amounts', function(e){
    if (e.keyCode === 13) {
        e.preventDefault();
        $($('.addBtn')[0]).trigger('click');
        $('.chart_of_accounts').last().focus();
    }
});
$('.amountDue').val();
//Delete Action on row
$(document).on('click', '.deleteBtn', function (e) {
    if ($('.record-row').length == 1) {
        alert(`You can't delete the existed last row!`)
        $(this).parents('tr').find('input').val('')
    }else{
        $(this).parents('tr').remove();
        sectorCalculation();
    }
});
