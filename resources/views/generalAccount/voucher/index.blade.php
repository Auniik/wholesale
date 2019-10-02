@extends('layout.app')
@section('title', 'Voucher Payments')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-success btn-sm" href="/{{$voucher->isDebit() ? 'debit' : 'credit'}}-vouchers/{!! $voucher->id !!}">View Voucher</a>
                            <a class="btn btn-success btn-sm" href="/vouchers/{!! $voucher->id !!}/payments/create">Create Payment</a>
                        </div>
                        <h4 class="panel-title">{!! $voucher->isDebit() ? 'Debit' : 'Credit' !!} Voucher Payments</h4>
                    </div>
                    <div class="panel-body">

                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th width="1%">Sl</th>
                                    <th width="10%" style="text-align: center">Invoice ID</th>
                                    <th class="text-center">Purpose</th>
                                    <th width="15%" class="text-center">Date</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-center" width="1%" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($voucher->payments as $payment)
                                    @if ($payment->paid)
                                        <tr>
                                            <td>{!! $loop->index++ !!}</td>
                                            <td>
                                                {{$payment->voucher->isDebit() ? 'D' : 'C'}}-{{ str_pad($payment->id, 3, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td>{{ $voucher->chartsNames() }}</td>
                                            <td class="text-center">{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td class="text-right">{{ number_format($payment->paid, 2 )}}</td>
                                            <td>
                                                <a href="/voucher-payments/{!! $payment->id !!}" class="btn btn-xs btn-warning" >
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="/voucher-payments/{!! $payment->id !!}" class="btn btn-xs btn-danger deletable" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection