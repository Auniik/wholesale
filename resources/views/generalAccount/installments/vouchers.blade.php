@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Installments</h4>
                </div>
                <div class="panel-body print_body">
                    <div class="col-md-12">
                        <div class="row search-voucher">
                            <form method="get">
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="party_id">Client / Vendor Name :</label>
                                    <div class="col-md-12 ">
                                        <select name="party_id" id="party_id" class="form-control select">
                                            <option value="">Select All</option>
                                            @foreach($parties as $id => $name)
                                                <option value="{{$id}}" {{request('party_id') == $id ? 'selected' : ''}}>{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="service">Invoice ID :</label>
                                    <div class="col-md-12">
                                        <input type="number" name="voucher_id" value="{{request('voucher_id')}}" class="form-control" placeholder="Invoice ID">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="service">Chart of Accounts :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="sector_name" autocomplete="off"
                                               class="form-control" placeholder="Chart of Accounts">
                                        <input type="hidden" name="sector_id" id="sector_id">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label col-md-12" for="payment_type">Type :</label>
                                    <div class="col-md-12 ">
                                        <select name="payment_type" id="payment_type" class="form-control select">
                                            <option value="">Select All</option>
                                            <option value="partial" {{request('payment_type') == 'partial' ? 'selected' : ''}}>Partial</option>
                                            <option value="advance" {{request('payment_type') == 'advance' ? 'selected' : ''}}>Advance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-md-12 no-padding" >&nbsp;</label>
                                    <div class="col-sm-12 no-padding">
                                        <button type="submit" style="margin-top: 2px;" class="btn btn-success col-md-12">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-hover table-bordered " id="my_table">
                            <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th width="10%">Voucher ID</th>
                                <th>Party Name</th>
                                <th>Voucher Type</th>
                                <th class="text-right">Total Amount</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1 ?>
                            @foreach ($installments as $key => $installment)

                                <tr>
                                    <td class="text-center">{{$sl++}}</td>
                                    <td><a href="{{url('/debit-vouchers/'.$installment->voucherId)}}" >{{$installment->voucherId}}</a></td>
                                    <td>{{$installment->name}}</td>
                                    <td>{{ucfirst($installment->payment_type)}}</td>
                                    {{--<td>{{$installment->}}</td>--}}
                                    <td class="text-right">{{number_format($installment->voucherTotal, 2)}}</td>

                                    <td class="text-center">
                                        @can('installments-show')
                                        <a href="{{route('installments.show', $installment->voucherId)}}" class="btn btn-default btn-xs" title="Installments" ><i class="fa fa-eye"></i> Installments</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{$installments->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('focus', '#sector_name', function(){
            $(this).autocomplete({
                source: function (request, response) {
                    $.getJSON('{{url('/load-chart-of-accounts?type=debit')}}', {
                        name: request.term
                    }, function (data) {
                        response($.map(data, function (item) {
                            return{
                                value: item.sector_name,
                                label: item.sector_name,
                                data: item,
                            }
                        }))
                    })
                },
                autoFocus: true,
                select: function(event, ui) {
                    // var items = ui.item.data;
                    $('#sector_id').val(ui.item.data.id);
                },
                search: function () {
                    $('#sector_id').val('');
                }
            })
        });
    </script>
@endsection