@extends('layout.app')
@push('style')
    <style>
        span.badge.badge-default {
            width: 83px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('installments-list')
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href="{{route('installments.index')}}">Installments</a>
                    </div>
                    @endcan
                    <h4 class="panel-title">Installments of <a href="{{url('/debit-vouchers/'.$voucher->id)}}" class="btn btn-xs btn-default">{{$voucher->id}}</a></h4>
                </div>
                <div class="panel-body print_body">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover table-bordered " id="my_table">
                            <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th>Purpose</th>
                                <th>Payable Date</th>
                                <th width="15%" class="text-right">Amount</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1 ?>
                            @foreach ($voucher->installments as $key => $installment)
                                <tr>
                                    <td class="text-center">{{$sl++}}</td>
                                    <td>
                                        {{$installment->purpose}}
                                    </td>
                                    <td>{{$installment->date->format('d/m/Y')}}</td>
                                    <td class="text-right">{{number_format($installment->amount, 2)}}</td>
                                    <td class="text-center">{{$installment->status()}}</td>

                                    <td class="text-center">
                                        @if (!$installment->isPaid())
                                            <a href="{{url('/')}}/vouchers/{{$voucher->id}}/payments/create?id={{$installment->id}}&amount={{$installment->amount}}" class="btn btn-warning btn-xs" title="Pay Now" ><i class="fa fa-usd"></i></a>
                                            @can('installments-delete')
                                            <a href="{{route('installments.destroy', $installment->id)}}" class="btn btn-danger btn-xs deletable" title="delete" ><i class="fa fa-trash-o"></i></a>
                                            @endcan
                                        @else
                                            <a class="btn btn-danger btn-xs disabled" ><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{--{{$installments->links()}}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


