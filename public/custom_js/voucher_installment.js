


$('#pay-via-installments').on('click', function () {
    let checked = $('#pay-via-installments:checked').val()
    switch(checked){
        case '1':
            $('.installment-section').removeClass('hidden');
            break;
        default:
            $('.installment-section').addClass('hidden');
            break;
    }
})


$(document).on('focus keyup blur','.amounts', function (e) {
    purposeValues(e)

});
// $(window).load(function (e) {
//     purposeValues(e)
// })



function purposeValues(e)
{
    let rows = $('.installment-row');
    let amount = 0, amounts = 0;
    let payableDue = parseFloat($('.amountDue').val());
    $.each(rows, function (i, row) {
        let s = ["th","st","nd","rd"],
            v = ++i%100;
        $(row).find('.purposes').val(`${i+(s[(v-20)%10]||s[v]||s[0])} Installment`);


        amount = parseFloat($(row).find('.amounts').val());
        if (!amount || amount < 0) {
            amount = 0;
            $(row).find('.amounts').val(0)
        }
        amounts += amount;

        if(amounts > payableDue){
            $(row).find('.amounts').val(payableDue-(amounts-amount))
            $('#total_installment_amount').val(payableDue);
        }else{

            $('#total_installment_amount').val(amounts);
        }


    });
    return amounts;
}


$(document).on('click', '.addInstallmentBtn', function (e) {
    if (purposeValues(e) >= $('.amountDue').val()) {
        alert('You Should not pay more than total due!');
    }
    else{
        $(e.target).closest('tr').after(`
                <tr class="installment-row">
                    <td><i class="fa fa-clock-o text-warning" aria-hidden="true"></i></td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="hidden" name="installment_id[]">
                            <input type="text" name="purpose[]" class="form-control small-box purposes" readonly autocomplete="off" required>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="text" name="installment_date[]" class="form-control datepicker small-box dates text-center"  autocomplete="off" required>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="number" name="installment_amount[]" class="form-control small-box amounts" style="text-align: right" value="0" autocomplete="off" required>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-xs addInstallmentBtn" tabindex="-1"> <i class="fa fa-plus"></i> </button>
                        <button type="button" class="btn btn-danger btn-xs deleteInstallmentBtn" tabindex="-1"> <i class="fa fa-trash"></i> </button>
                    </td>
                </tr>
            `)
        purposeValues(e)

    }


});

$(document).on('click', '.deleteInstallmentBtn', function (e) {
    if ($('.installment-row').length == 1) {
        alert(`You can't delete the existed last row!`)
    }else{

        addBtnDisable(e.target, 0)

        $(this).parents('tr').remove();
        purposeValues(e)

    }
});



function installmentPay()
{
    let amount = 0;
    $('.amounts').each(function () {

        if ($(this).parents('.installment-row').find('.installment-check').is(':checked')) {
            amount += parseFloat($(this).val())
        }
    });
    if (amount < 0){
        amount = 0
    }
    $('#totalPaid').val(amount)
}
$(document).on("change", ".installment-body", function (e) {
    installmentPay()
})

function addBtnDisable(e, i){}