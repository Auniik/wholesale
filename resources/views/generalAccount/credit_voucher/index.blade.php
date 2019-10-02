@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('credit-voucher-create')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="{{route('credit-vouchers.create')}}">Create Credit Voucher</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">Credit Vouchers</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row search-voucher">
                            <form method="get">
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="party_id">Client / Vendor Name :</label>
                                    <div class="col-md-12">
                                        <select name="party_id" id="party_id" class="form-control select">
                                            <option value="">Select All</option>
                                            @foreach($parties as $party)
                                                <option value="{{$party->id}}" {{request('party_id') == $party->id ? 'selected' : ''}}>{{$party->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="service">Chart of Accounts :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="sector_name" class="form-control" placeholder="Chart of Account Name" autocomplete="off">
                                        <input type="hidden" name="sector_id" id="sector_id">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="service">Voucher ID :</label>
                                    <div class="col-md-12">
                                        <input type="number" name="voucher_id" value="{{request('voucher_id')}}" class="form-control" placeholder="Voucher ID">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-md-12 no-padding" for="">&nbsp;</label>
                                    <div class="col-sm-12 no-padding">
                                        <button type="submit" class="btn btn-warning col-md-12">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                                <th width="1%">Sl</th>
                                <th class="text-center">Voucher ID</th>
                                <th>Client / Vendor Name</th>
                                <th class="text-center">Date</th>
                                <th>Chart of Accounts</th>
                                <th>Ref ID</th>
                                <th>Cheque No</th>
                                <th class="text-right">Amount</th>
                                <th class="text-right">Receive</th>
                                <th width="8%" colspan="3" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $vouchers->firstItem() )
                            @foreach($vouchers as $voucher)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>C-{{ str_pad($voucher->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{$voucher->party->name}}</td>
                                    <td class="text-center">{{$voucher->date->format('m/d/Y')}}</td>
                                    <td>{{$voucher->chartsNames()}}</td>
                                    <td>{{$voucher->ref_id}}</td>
                                    <td>{{$voucher->cheque_no}}</td>
                                    <td class="text-right">{{number_format($voucher->amount, 2)}}</td>
                                    <td class="text-right">{{number_format($voucher->paidAmount->amount, 2)}}</td>
                                    @can('credit-voucher-show')
                                    <td>
                                        <a href="{{route('credit-vouchers.show', $voucher->id)}}" class="btn btn-xs btn-warning" ><i class="fa fa-eye"></i></a>
                                    </td>
                                    @endcan
                                    @can('credit-voucher-create')
                                    <td>
                                        <a href="/vouchers/{!! $voucher->id !!}/payments" class="btn btn-xs btn-warning" ><i class="fa fa-usd"></i></a>
                                    </td>
                                    @endcan
                                    @can('credit-voucher-delete')
                                    <td>
                                        <a href="{{route('credit-vouchers.destroy', $voucher->id)}}" class="btn btn-xs btn-danger deletable"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $vouchers->links() }}
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
                    $.getJSON('{{url('/load-chart-of-accounts?type=credit')}}', {
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