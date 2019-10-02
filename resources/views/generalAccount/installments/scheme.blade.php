@can('installments-create')
    <div class="col-md-8 col-lg-offset-2 installment-section ">
        <br>
        <h3 class="text-center">Monthly Installments</h3>
        <table class="table table-condensed">
            <thead>
            <tr>
                <th></th>
                <th>Purpose </th>
                <th class="text-center">Date</th>
                <th class="text-right">Amount</th>
                <th class="text-center" width="10%">Action</th>
            </tr>
            </thead>
            <tbody class="installment-body">
            @if ($voucher->installments->isEmpty())
                @include('generalAccount.installments.setScheme')
            @endif
            @foreach($voucher->installments as $installment)
                <tr class="installment-row">
                @if ($installment->paid())
                    <td><i class="fa fa-check-circle text-teal" aria-hidden="true"></i></td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="hidden" name="installment_id[]" class="installment-ids"
                                   value="{{$installment->id}}">
                            <input type="hidden" name="installment_status[]" class="installment-statuses"
                                   value="{{$installment->status}}">
                            <input type="text" name="purpose[]" class="form-control small-box "
                                   value="{{$installment->purpose}}"  readonly>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="text" name="installment_date[]" class="form-control  small-box text-center"
                                   value="{{$installment->date->format('d-m-Y')}}" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="text" name="installment_amount[]" class="form-control small-box" readonly
                                   style="text-align: right"
                                   value="{{$installment->amount}}" >
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success addInstallmentBtn btn-xs" tabindex="-1"> <i
                                    class="fa fa-plus"></i> </button>
                        <button type="button" class="btn btn-danger disabled btn-xs" tabindex="-1">
                            <i class="fa fa-trash"></i> </button>
                    </td>
                @else
                    <td>
                        @if ($voucher->approved())
                            <input type="checkbox" name="installment_check[]" class="checkbox-inline installment-check"
                                   value="{{$installment->id}}" >
                        @else
                            <i class="fa fa-clock-o text-warning" aria-hidden="true"></i>
                        @endif
                    </td>

                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="hidden" name="installment_id[]" class="installment-ids"
                                   value="{{$installment->id}}">
                            <input type="text" name="purpose[]" class="form-control small-box purposes"
                                   value="{{$installment->purpose}}"  readonly autocomplete="off" required>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="text" name="installment_date[]" class="form-control datepicker
                            small-box dates text-center" value="{{$installment->date->format('d-m-Y')}}"
                                   autocomplete="off">
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12 no-padding">
                            <input type="number" name="installment_amount[]" class="form-control small-box amounts"
                                   style="text-align: right" value="{{$installment->amount}}" autocomplete="off">
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-xs addInstallmentBtn" tabindex="-1">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-xs deleteInstallmentBtn" tabindex="-1"> <i
                                    class="fa fa-trash"></i>
                        </button>
                    </td>
                @endif
            </tr>
            @endforeach

            </tbody>
            <td colspan="3" class="text-right">Total</td>
            <td>
                <input type="text" class="form-control small-box text-right"
                       name="total_installment_amount"
                       value="{{$voucher->installments->where('status', 'pending')->sum('amount')}}"
                       id="total_installment_amount" readonly>
            </td>
        </table>
    </div>
@endcan
