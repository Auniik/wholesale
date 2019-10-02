@extends('layout.app')
@push('style')
    <style type="text/css">
        /*form{display: inline;}*/
        .form-group{width: 100%;height: auto; overflow: hidden; display: block !important; margin: 5px;}
        .form-control{width: 100% !important;}
        .control-label{
            color: black !important;
        }

    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @can('petty-cash-deposit-create')
                <div class="panel-heading-btn pull-right">
                    <a href="#addNew" data-toggle="modal" class="btn btn-success btn-sm">New Deposit</a>
                    <!-- #addNew -->
                    <div class="modal fade" id="addNew">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{route('petty-cash-deposits.store')}}" method="post" class="form-horizontal">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title"> Deposit Amount</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4">Payment Date :</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input type="hidden" class="form-control" autocomplete="off" name="date" readonly value="{{date('Y-m-d')}}">
                                                    <input type="text" class="form-control" autocomplete="off" readonly value="{{date('d/m/Y')}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4">Received By :</label>
                                                <div class="col-md-8 col-sm-8">
                                                    {{--<input type="text" class="form-control" name="received_by" autocomplete="off">--}}
                                                    <select name="received_by" class="form-control select2">
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4">Account  :</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <select name="account_id" id="account_id" class="form-control select2">
                                                        <option value="">Select Account</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div>Balance :<span class="current-balance"> No account Selected</span></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4">Amount  :</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input type="number" class="form-control" name="amount" id="amount" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end edit section -->
                </div>
                @endcan
                <h4 class="panel-title">Petty Cash Deposit (Current Balance: {{number_format($deposits->sum('amount') - $expense , 2)}} TK) </h4>
            </div>
            <div class="panel-body" id="tabArea">

                <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="1%">Sl</th>
                            <th>Date</th>
                            <th>Received By</th>
                            <th>Paid By</th>
                            <th>Received From</th>
                            <th width="15%"class="text-right">Account</th>
                            <th width="1%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        @foreach($deposits as $key => $deposit)
                            <tr class="odd gradeX">
                                <td>{{++$key}}</td>
                                <td>{{$deposit->date->format('d/m/Y')}}</td>
                                <td>{{optional($deposit->receivedBy)->name}}</td>
                                <td>{{$deposit->createdBy->name}}</td>
                                <td>{{$deposit->depositTransaction->account->account_name}}</td>
                                <td align="right">{{number_format($deposit->amount, 2)}} TK</td>
                                <td>
                                    @can('petty-cash-deposit-delete')
                                    <a href="{{route('petty-cash-deposits.destroy', $deposit->id)}}"  class="btn btn-xs btn-danger deletable"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$deposits->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('#account_id').change(function (e) {
            $.getJSON('{{url('getBalance')}}',
                {id: $(this).val()},
                function (data) {
                    $('.current-balance').html(` ${data.balance} TK`);
                    if (data.balance <= 0) {
                        alert('You shouldn\'t transfer from this account.');
                        $('#amount').attr('readonly', true);
                    } else {
                        $('#amount').attr({
                            max: data.balance,
                            readonly: false
                        });
                        $('#amount').val(0);
                    }
            })
        })

    </script>
@endsection
