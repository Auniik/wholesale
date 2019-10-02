@extends('layout.app')
@section('title', 'Debit Vouchers')
@push('style')
    <style>
        td {
            padding: 5px !important;
        }
        .btn-xs, .btn-group-xs > .btn {
            padding: 1px 6px;
            margin: 5px;
        }
        .btn-group > .btn:first-child {
            margin-left: 7px;
        }
    </style>
@endpush
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('debit-voucher-create')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="{{route('debit-vouchers.create')}}">Create Debit Voucher</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">Debit Vouchers</h4>
                    </div>
                    <div class="panel-body">
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
                                    <label class="control-label col-md-12" for="service">Chart of Accounts :</label>
                                    <div class="col-md-12">
                                        <input type="text" id="sector_name" class="form-control" placeholder="Chart of Account Name" autocomplete="off">
                                        <input type="hidden" name="sector_id" id="sector_id">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="service">Invoice ID :</label>
                                    <div class="col-md-12">
                                        <input type="number" name="voucher_id" value="{{request('voucher_id')}}" class="form-control" placeholder="Invoice ID">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-md-12 no-padding" >&nbsp;</label>
                                    <div class="col-sm-12 no-padding">
                                        <button type="submit" style="margin-top: 2px;" class="btn btn-success col-md-12">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                                <th width="1%">Sl</th>
                                <th width="8%" class="text-center">Invoice ID</th>
                                <th width="15%">Client / Vendor Name</th>
                                <th width="8%" class="text-center">Date</th>
                                <th >Chart of Accounts</th>
                                <th class="text-right" width="10%">Amount</th>
                                <th class="text-right" width="10%">Paid</th>
                                <th width="5%" class="text-center">Verification Status</th>
                                <th width="5%" class="text-center">Status</th>
                                <th width="5%" class="text-center">Type</th>
                                <th width="11%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $vouchers->firstItem() )
                            @foreach($vouchers as $voucher)
                                <?php
                                    $voucher->approved_at ? $paidAmount = abs($voucher->paidAmount->amount ?? 0) : $paidAmount = $voucher->sectorPayments->sum('paid_amount');
                                ?>

                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>D-{{str_pad($voucher->id, 3, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$voucher->party->name}}</td>
                                    <td>{{$voucher->date->format('d/m/Y')}}</td>
                                    <td>
                                       {{$voucher->chartsNames()}}
                                    </td>
                                    <td class="text-right">{{number_format($voucher->amount, 2)}}</td>
                                    <td class="text-right">{{number_format($paidAmount, 2)}}</td>
                                    <td class="text-center">
                                        @if ($voucher->confirmed_at)
                                            <a href="#" class="btn btn-xs btn-teal" style="margin-right: 1px !important;" disabled
                                               title="Verified at: {{$voucher->confirmed_at}}">Verified</a>
                                        @endif
                                    </td>



                                @if(!$voucher->approved_at)
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" style="width:64px"
                                                    class="btn btn-xs btn-warning dropdown-toggle"
                                                    {{--@cannot('confirm-debit-voucher') disabled @endcan--}}
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Pending
                                            </button>
                                            <ul class="dropdown-menu" style="min-width: 80px; left: 6px; top: 80%;">
                                                <li>
                                                    @if (!$voucher->confirmed_at)
                                                        @can('confirm-debit-voucher')
                                                            <a
                                                                href="{{route('debit-voucher.confirm',
                                                                ['debit_voucher' => $voucher->id, 'set' => 'true'])}}"
                                                                class="bg-default">Verify</a>
                                                        @endcan
                                                    @else
                                                        @can('approve-debit-voucher')
                                                            <a href="/debit-vouchers/{{$voucher->id}}/edit"
                                                               class="bg-default">
                                                                Approve
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                        <td></td>
                                    @else
                                        <td>
                                            <a href="#" class="btn btn-xs btn-teal" style="margin-right: 1px !important;" disabled
                                               title="Approved at: {{$voucher->approved_at}}">Approved</a>
                                        </td>
                                        <td class="text-center">
                                            <label class="btn btn-xs btn-default" disabled="">
                                                {{$voucher->amount != $paidAmount ? 'Partial' : 'Paid'}}
                                            </label>
                                        </td>
                                    @endif


                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs" role="group">

                                            <a title="Due Payment"
                                               @if($voucher->approved_at)
                                               href="/vouchers/{!! $voucher->id !!}/payments/create"
                                               @else
                                               disabled
                                               @endif
                                               class="btn btn-xs btn-primary" > <i class="fa fa-usd"></i> </a>

                                            @can('debit-voucher-show')
                                                <a title="View Voucher" href="{{ route('debit-vouchers.show', $voucher->id)}}" class="btn btn-xs btn-warning" ><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('debit-voucher-delete')
                                                <a title="Delete Voucher" href="{{ route('debit-vouchers.destroy', $voucher->id)}}" class="btn btn-xs btn-danger deletable"><i class="fa fa-trash-o"></i></a>
                                            @endcan
                                        </div>
                                    </td>
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

    <script>
        $('.approve').click(function (e) {
            let commissionAssignId = $(this).parent().find('.id').val();
            let url = `{{url('/')}}/commission-assigns/${commissionAssignId}/approve`;
            $.ajax({
                type: "post",
                url,
                data: {commissionAssignId, _token: '{{csrf_token()}}'},
                success: function (data) {
                    $('#successMessage').html(data);
                    $('.approve').attr('disabled', true);
                    location.reload(true)
                }
            })
        })
    </script>
@endsection