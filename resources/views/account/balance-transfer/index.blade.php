@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('balance-transfer-create')
                        <a href="{{ route('balance-transfers.create') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus-square"></i>&nbsp; New Balance Transfer</a>
                    @endcan
                    <h4 class="panel-title"><i class="fa fa-balance-scale"></i> &nbsp;Fund Transfer List </h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table class="table table-responsive table-stripped table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>From Account</th>
                                <th>To Account</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($balanceTransfers as $key => $balanceTransfer)
                                <tr title="{{ $balanceTransfer->description }}">
                                    <td>{{++$key}}</td>
                                    <td>{{ $balanceTransfer->id }}</td>
                                    <td>{{$balanceTransfer->fromAccount->account_name}}</td>
                                    <td>{{$balanceTransfer->toAccount->account_name}}</td>
                                    <td>{{ $balanceTransfer->date->format('d/m/Y')}}</td>
                                    <td>{{ number_format($balanceTransfer->amount, 2)}}</td>
                                    <td class="approve-col">
                                        {{--@can('balance-transfer-approve')--}}
                                        {{--@endcan--}}
                                        @if (!$balanceTransfer->approved_at)
                                            @can('balance-transfer-approve')
                                            <a title="Approval won't undo" class="btn btn-default btn-xs approve">Approve</a>
                                            <input type="hidden" class="id" value="{{$balanceTransfer->id}}">
                                            @endcan
                                            @else
                                            <a class="btn btn-teal btn-xs" disabled="">Approved</a>
                                        @endif
                                    </td>
                                    <td title="Delete Transfer">

                                        <a href="{{route('balance-transfers.show', $balanceTransfer)}}"  class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>
                                    @can('balance-transfer-delete')
                                            <a href="{{ route('balance-transfers.destroy', $balanceTransfer->id) }}"  class="btn btn-danger btn-xs deletable"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <p class="pull-right">{{ $balanceTransfers->links() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('.approve').click(function (e) {
            let balance_transfer = $(this).parent().find('.id').val();
            let url = `{{url('/')}}/balance-transfers/${balance_transfer}/approve`;
            $.ajax({
                type: "post",
                url,
                data: {balance_transfer, _token: '{{csrf_token()}}'},
                success: function (data) {
                    $('#successMessage').html(data);
                    $('.approve').attr('disabled', true)
                    location.reload(true)
                }
            })
        })
    </script>
@endsection
