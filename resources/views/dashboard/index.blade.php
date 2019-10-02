@extends('layout.app')
@push('style')
    <link rel="stylesheet" href="{{asset('plugins/calender/jquery-calendar.css')}}">
    <style>
        .calendar-month-events-day{
            font-size: 16px;
        }

        h4 small{
            display: none;
        }
        .calendar .event-date{
            display: none;
        }
        .modal-body br{
            display: none;
        }

        .event-name {
            font-size: 13px;
        }
        .modal.in .modal-dialog {
            transform: translate(15%, 15%) !important;
        }
    </style>
@endpush
@section('content')
    
    @include('dashboard.accounts')


    <div id="content" class="content" style="font-size: 11px !important;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading no-print">
                        <h4>Installment Calender</h4>
                    </div>
                    <div class="panel-body mar" id="print_body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('script')
    <script src="{{asset('plugins/calender/jquery-calendar.js')}}"></script>
    <script src="{{asset('plugins/calender/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('plugins/calender/jquery.touchSwipe.js')}}"></script>

    <script>
        moment.locale('bn');
        var now = moment();
        var events = [
            @foreach($installments as $key => $installment)
            <?php
                $modalText = "<h5><b>Invoice ID</b> : $installment->voucherId</h5> <h5><b>Voucher Type</b>: $installment->payment_type</h5> <h5><b>Party</b> : $installment->name</h5>  <h5><b>Total Amount </b>: $installment->voucherTotal TK</h5> <h5><b >Installment</b> : $installment->installmentAmount TK</h5> <hr> <a href=\'vouchers/$installment->voucherId/payments/create?id=$installment->installmentId&amount=$installment->installmentAmount\' class=\'btn btn-success\'>Pay Now</a>";
            ?>
            {
            start: '{{ $installment->unixDate}}',
            end: '{{ $installment->unixDate}}',
            title: '{!! $installment->purpose!!}',
            content: '{!! $modalText !!}',
            category:'{{$installment->installmentType}}'
            },
            @endforeach

            @foreach($tasks as $key => $task)
            {
                start: '{{ $task->unixDate }}',
                end: '{{ $task->unixDate }}',
                title: '{!! 'Task: '. $task->name!!}',
                content: "{!! $task->calenderModal() !!}",
                category:'{{ 'Task' }}'
            },
            @endforeach

        ];
    </script>

    <script>
        $(document).ready(function() {
            var myCalendar = $('#calendar').Calendar({
                events,
                locale: 'bn',
                // 'day', 'week', 'month'
                view: 'month',
                // enable keyboard navigation
                enableKeyboard: true,
                // default view
                defaultView: {
                    largeScreen: 'month',
                    smallScreen: 'month',
                    smallScreenThreshold: 1000
                },
                weekday: {
                    timeline: {
                        fromHour: 9, // start hour
                        toHour: 18, // end hour
                        intervalMinutes: 60,
                        format: 'HH:mm',
                        heightPx: 35,
                        autoResize: false
                    },
                    dayline: {
                        weekdays: [0, 1, 2, 3, 4, 5, 6],
                        format: 'dddd DD / MM',
                        heightPx: 31,
                        month: {
                            format: 'MMMM YYYY',
                            heightPx: 30,
                            weekFormat: 'w'
                        }
                    }
                },
                month: {
                    format: 'MMMM YYYY',
                    heightPx: 31,
                    weekline: {
                        format: 'w',
                        heightPx: 60
                    },
                    dayheader: {
                        weekdays: [0, 1, 2, 3, 4, 5, 6],
                        format: 'dddd',
                        heightPx: 30
                    },
                    day: {
                        format: 'DD'
                    }
                },
                // timestamp in the week to display
                unixTimestamp: moment().format('X'),
                // event options
                event: {
                    hover: {
                        delay: 500
                    }
                },
                // category options
                categories: {
                    enable: false,
                    hover: {
                        delay: 500
                    }
                },
                // display the current time
                now: {
                    enable: true,
                    refresh: true,
                    heightPx: 1,
                    style: 'solid',
                    color: '#03A9F4'
                }
            }).init();
        });
    </script>


    <script>
        $(document).ready(function (e) {
            $.get('get-account-dashboard', function(data){
                console.log(data)
                accountsTransaction(data.data.accounts, data.data.hospital_dues)
            })

        })

        function accountsTransaction(accounts, hospital)
        {
            $('.advance-payment').text(accounts.advancePayment.toFixed(2))
            $('.petty-cash').text(accounts.availablePettyCash.toFixed(2))

            let dailyExpense = accounts.dailyTransaction.debit + accounts.todayExpense;
            let dailyIncome = accounts.dailyTransaction.credit + accounts.todayIncome;
            let monthlyExpense = accounts.monthlyTransaction.debit + accounts.monthlyExpense;
            let monthlyIncome = accounts.monthlyTransaction.credit + accounts.monthlyIncome;

            $('.monthly-expanse').text(monthlyExpense.toFixed(2))
            $('.monthly-income').text(monthlyIncome.toFixed(2))
            $('.daily-expense').text(dailyExpense.toFixed(2))
            $('.daily-income').text(dailyIncome.toFixed(2))

            let receivableAmount = accounts.totalVoucherAmount.credit - accounts.grossTransaction.credit

            $('.receivable-amount').text(receivableAmount.toFixed(2))

            $('.outdoor-due').text(hospital.outdoor.toFixed(2))
            $('.indoor-due').text(hospital.indoor.toFixed(2))
            $('.service-due').text(hospital.service_sale.toFixed(2))


        }

    </script>


@endsection