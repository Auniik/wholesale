@extends('layout.app')
@push('style')

@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ url('balance-transfers') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-list"></i>&nbsp; All Transfer</a>
                <h4 class="panel-title"><i class="fa fa-balance-scale"></i>&nbsp;Fund Transfer </h4>
            </div>
            <div class="panel-body">
                @if ($errors->any())
                    <div class="alert alert-danger fade-in">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('balance-transfers.store') }}"class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="Date">Date * :</label>
                                <div class="col-md-9 col-sm-9">
                                    <input class="form-control" type="hidden" id="Date" name="date" placeholder="Date" data-parsley-required="true" value="{{date('Y-m-d')}}" autocomplete="off" readonly/>
                                    <input class="form-control" type="text" id="Date" placeholder="Date" data-parsley-required="true" value="{{date('d/m/Y')}}" autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="from_account">From Account * :</label>
                                <div class="col-md-9 col-sm-9">
                                    <select name="transfer_from" class="form-control" id="fromAccount" required >
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                            <option  value="{{ $account->id }}">{{ $account->account_name }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        Balance: <span class="from-account">0.00</span>
                                        <input type="hidden" class="from-account-balance">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="to_account">To Account * :</label>
                                <div class="col-md-9 col-sm-9">
                                    <select name="transfer_to" id="to_account" class="form-control" required >
                                        <option class="select-account" value="">Select Account</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="account_name">Amount * :</label>
                                <div class="col-md-9 col-sm-9">
                                    <input type="number" class="form-control" id="amount" name="amount" min="0" placeholder="Amount" autocomplete="off">
                                    <span id="currentBalance">Balance:</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="account_name">Bill Description * :</label>
                                <div class="col-md-9 col-sm-9">
                                    <textarea class="form-control" id="address" name="description" rows="4"  placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3"></label>
                                <div class="col-md-9 col-sm-9">
                                    <button type="submit" class="btn btn-success col-md-12">Submit</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <label class="post_upload" for="file">
                                <img id="image_load" alt="No Image Selected" src="">
                            </label>
                            <input id="file" style="display:none" name="bank_slip" type="file" accept="image/*" required>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        $('#fromAccount').change(function() {
            let accountId = $(this).val()
            $.getJSON('{{url('getBalance')}}',
                {id: accountId},
                function (data) {
                    $('.from-account').html(`${data.balance} TK`);
                    $('.from-account-balance').val(data.balance);
                    if (data.balance <= 0){
                        alert('You shouldn\'t transfer from this account.');
                        $('#amount').attr('readonly', true);
                    }else{
                        $('#amount').attr({
                            max: data.balance,
                            readonly: false
                        });
                        $('#amount').val(0);

                        $('#to_account').html(
                            $.map(data.accounts, function (account) {
                                return '<option value="'+account.id+'">'+account.account_name+'</option>';
                            }).join('')
                        ).trigger('change')
                    }
                }
            )
        });
        $('#amount').on('keyup blur', function() {
            let amount = $(this).val()
            let existingBalance = parseFloat($('.from-account-balance').val());
            if (amount > existingBalance){
                alert('You can\'t transfer more than existing balance');
                $(this).val(existingBalance)
            }else{
                $('#currentBalance').html(`Current Balance: ${existingBalance-amount}`);
            }
        })
    </script>

@endsection