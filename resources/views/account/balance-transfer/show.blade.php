@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('balance-transfer-list')
                        <a href="{{ route('balance-transfers.index') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus-square"></i>&nbsp; All Balance Transfers</a>
                    @endcan
                    <h4 class="panel-title"><i class="fa fa-balance-scale"></i> Details&nbsp;Fund Transfer </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <table class="table table-striped" style="box-shadow: none">
                                <thead>
                                    <tr>
                                        <td>Date</td>
                                        <td>{{$balanceTransfer->date->format('m/d/y h:m:s')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Transfer From</td>
                                        <td>{{$balanceTransfer->fromAccount->account_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Transfer To</td>
                                        <td>{{$balanceTransfer->toAccount->account_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>{{$balanceTransfer->description}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Amount</b></td>
                                        <td><b>{{number_format($balanceTransfer->amount, 2)}} TK</b></td>
                                    </tr>
                                    <tr>
                                        <td>Created By</td>
                                        <td>{{$balanceTransfer->createdBy->name}}</td>
                                    </tr>
                                </thead>

                            </table>
                        </div>

                        <div class="col-md-6">
                            <img  alt="No Image Found" width="100%" height="auto" src="{{url($balanceTransfer->bank_slip)}}">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
