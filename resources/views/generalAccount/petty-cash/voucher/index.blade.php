@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('petty-cash-voucher-create')
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href='{{route('petty-cash-vouchers.create')}}'>Create Voucher</a>
                    </div>
                    @endcan
                    <h4 class="panel-title"> Petty Cash Vouchers </h4>
                </div>
                <div class="panel-body" id="tabArea">
                    <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                            <th width="1%">Sl</th>
                            <th width="10%">Date</th>
                            <th>Charts</th>
                            <th width="15%">Created By</th>
                            <th width="10%">Amount</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; ?>
                        @foreach($pettyCashVouchers as $key => $voucher)
                            <tr class="odd gradeX">
                                <td>{{++$key}}</td>
                                <td>{{$voucher->date->format('d/m/Y')}}</td>
                                <td>{{$voucher->chartsNames() ?? ''}}</td>
                                <td>{{$voucher->user->name}}</td>
                                <td>{{number_format($voucher->amount, 2)}}</td>
                                <td>
                                    @can('petty-cash-voucher-show')
                                    <a a href="{{route('petty-cash-vouchers.show', $voucher->id)}}"  class="btn btn-xs btn-warning"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    @endcan
                                    @can('petty-cash-voucher-delete')
                                        <a a href="{{route('petty-cash-vouchers.destroy', $voucher->id)}}"  class="btn btn-xs btn-danger deletable"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$pettyCashVouchers->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
