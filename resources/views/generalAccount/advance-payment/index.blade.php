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
                        @can('advance-voucher-create')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="{{route('advance-payment-vouchers.create')}}">Create Advance Payment</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">Advance Payment Vouchers</h4>
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
                                <th width="5%" class="text-center">Verification</th>
                                <th width="5%" class="text-center">Status</th>
                                <th width="5%" class="text-center">Type</th>
                                <th width="11%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $vouchers->firstItem() )
                            @foreach($vouchers as $voucher)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>D-{{str_pad($voucher->id, 3, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{optional($voucher->party)->name}}</td>
                                    <td>{{$voucher->date->format('m/d/Y')}}</td>
                                    <td>
                                       {{$voucher->chartsNames()}}
                                    </td>
                                    <td class="text-right">{{number_format($voucher->amount, 2)}}</td>
                                    <td class="text-right">{{$voucher->approved_at ? number_format(abs($voucher->paidAmount->amount ?? 0), 2) : number_format($voucher->sectorPayments->sum('paid_amount'), 2) }}</td>
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
                                            @can('approve-advance-voucher')
                                                @if ($voucher->isPaymentType('advance'))
                                                    <form action="{{action('AdvancePaymentController@adjust', $voucher)}}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-xs btn-primary">Adjust Now</button>
                                                    </form>
                                                @endif
                                            @endcan
                                            @if ($voucher->isPaymentType('adjusted'))
                                                <button type="button"  class="btn btn-xs btn-teal" disabled>Adjusted</button>
                                            @endif
                                        </td>
                                    @endif

                                    {{--@if($voucher->approved_at)--}}
                                        {{--<td class="text-center" >--}}
                                            {{--<a href="#" class="btn btn-xs btn-teal" style="margin-right: 1px !important;" disabled title="Approved at: {{$voucher->approved_at}}">Approved</a>--}}
                                        {{--</td>--}}
                                        {{--<td class="text-center">--}}
                                            {{--@can('approve-advance-voucher')--}}
                                                {{--@if ($voucher->isPaymentType('advance'))--}}
                                                    {{--<form action="{{action('AdvancePaymentController@adjust', $voucher)}}" method="post">--}}
                                                        {{--@csrf--}}
                                                        {{--<button type="submit" class="btn btn-xs btn-primary">Adjust Now</button>--}}
                                                    {{--</form>--}}
                                                {{--@endif--}}
                                            {{--@endcan--}}
                                            {{--@if ($voucher->isPaymentType('adjusted'))--}}
                                                {{--<button type="button"  class="btn btn-xs btn-teal" disabled>Adjusted</button>--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
                                    {{--@else--}}
                                        {{--<td class="text-center">--}}
                                            {{--<div class="btn-group">--}}
                                                {{--<button type="button" style="width:64px" class="btn btn-xs btn-warning dropdown-toggle" @cannot('approve-advance-voucher') disabled @endcan data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                                    {{--Pending--}}
                                                {{--</button>--}}
                                                {{--@can('approve-advance-voucher')--}}
                                                    {{--<ul class="dropdown-menu" style="min-width: 80px; left: 6px; top: 80%;">--}}
                                                        {{--<li><a href="{{action('GeneralPaymentController@edit', $voucher->id)}}" class="bg-default">Approve</a></li>--}}
                                                    {{--</ul>--}}
                                                {{--@endcan--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td></td>--}}
                                    {{--@endif--}}

                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs" role="group">
                                            @if($voucher->approved_at)
                                                <a title="Due Payment" href="/vouchers/{!! $voucher->id !!}/payments/create" class="btn btn-xs btn-primary" > <i class="fa fa-usd"></i> </a>
                                            @else
                                                <a class="btn btn-xs btn-primary" disabled="" > <i class="fa fa-usd"></i> </a>
                                            @endif
                                            @can('advance-voucher-show')
                                            <a title="View Voucher" href="{{ route('debit-vouchers.show', $voucher->id)}}" class="btn btn-xs btn-warning" ><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('advance-voucher-delete')
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
