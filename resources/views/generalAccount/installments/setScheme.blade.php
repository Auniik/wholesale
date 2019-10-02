<tr class="installment-row">
    <td><i class="fa fa-clock-o text-warning" aria-hidden="true"></i></td>
    <td>
        <div class="col-md-12 no-padding">
            <input type="text" name="purpose[]" class="form-control small-box purposes" value="1st Installment"
                   readonly autocomplete="off" required>
        </div>
    </td>
    <td>
        <div class="col-md-12 no-padding">
            <input type="text" name="installment_date[]" class="form-control datepicker small-box dates text-center"
                   autocomplete="off">
        </div>
    </td>
    <td>
        <div class="col-md-12 no-padding">
            <input type="number" name="installment_amount[]" class="form-control  small-box amounts"
                   style="text-align: right" value="0" autocomplete="off">
        </div>
    </td>
    <td>
        <button type="button" class="btn btn-success btn-xs addInstallmentBtn"  tabindex="-1"> <i class="fa
        fa-plus"></i>
        </button>
        <button type="button" class="btn btn-danger btn-xs deleteInstallmentBtn"  tabindex="-1"> <i class="fa
        fa-trash"></i>
        </button>
    </td>
</tr>