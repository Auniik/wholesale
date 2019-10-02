@extends('layout.app')
@section('title', 'Cash Collections')
@section('content')
    <style type="text/css">

        .table>tbody>tr>td{
            padding: 3px !important;
        }

        .table>thead>tr>th{
            padding: 3px !important;
        }

        .search_header{
            padding: 15px;
        }

        legend {
            margin-bottom: 5px !important;
        }
        @media print {
            form,
            .panel-heading,
            footer, #tour-11,
            .header-right,
            .navbar-brand,
            #tour-2,
            .header-left,
            .sidebar-menu,
            .sidebar-content,
            #header {
                display: none !important;
            }
            #page-content {
                margin-top: 0 !important;
            }
        }

    </style>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button class="btn btn-xs btn-info pull-right printbtn" onclick="printPage('print_body')"><i class="fa fa-print"></i>&nbsp; Print</button>
                <h4 class="panel-title"><i class="fa fa-list-ul"></i> &nbsp; Cash Collection Reports </h4>
            </div>
            <div class="panel-body">
                <!-- <form method="post"> -->
                <form action="" method="GET">
                    <div class="report_filler ">
                        <div class="row " >
                            <div class="col-md-10 col-md-offset-1 search_header">
                                <div class="form-group col-md-4">
                                    <label class="control-label col-md-12" for="Date">Start Date* :</label>
                                    <div class="col-md-12">
                                        <input class="form-control datepicker" placeholder="Start Date" name="start" type="text" value="{{\Illuminate\Support\Facades\Input::get('end') ?? date('d-m-Y')}}">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-md-12"> &nbsp; </label>
                                    <div class="col-md-12 no-padding" >
                                        <input class="form-control text-center" type="text" value="TO" readonly="" >
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label col-md-12" for="Date">End Date* :</label>
                                    <div class="col-md-12">
                                        <input class="form-control datepicker" placeholder="End Date" name="end" type="text" value="{{\Illuminate\Support\Facades\Input::get('end') ?? date('d-m-Y')}}">
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-md-12" for="Date">&nbsp;</label>

                                    <div class="col-sm-12 ">

                                        <button type="submit" class="btn btn-success btn-bordred waves-effect w-md waves-light m-b-5">
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hr">
                    </div>
                </form>
                @if(isset($users))
                    <div class="row" id="print_body">
                        <div class="col-md-12 col-xs-12">
                            <div class="row">
                                <h4 class="text-center"><strong>Cash Collection Report</strong></h4>
                                <div class="col-xs-6 text-right">
                                    <p><strong><span class="text-right">Start Date: &nbsp; {{ \Illuminate\Support\Facades\Input::get('start') ?? '' }}</span></strong></p>
                                </div>
                                <div class="col-xs-6">
                                    <p class=""><strong>End Date: &nbsp;{{ \Illuminate\Support\Facades\Input::get('end') ?? '' }} </strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10 col-xs-10 col-xs-offset-1">
                            {{--                            <legend ><p class="" style="border-bottom: none">Petty Cash</p></legend>--}}
                            <table class="table table-bordered">
                                <thead class="alert alert-success">
                                <tr>
                                    <th width="7%">Sl no</th>
                                    <th>User</th>
                                    <th width="40%">Section</th>
                                    <th width="20%">Collection</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $total = 0;
                                ?>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{!! $loop->index + 1 !!}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            {{ count($user->outdoorPayments) ? 'Outdoor payment' : '' }}
                                            {{ count($user->indoorDueReceive) ? ', Indoor payment' : '' }}
                                            {{ count($user->serviceSalesDueReceive) ? ', Service sales payment' : '' }}
                                        </td>
                                        <td>
                                            <?php
                                             $total += $user->outdoorPayments->sum('payment_amount') + $user->indoorDueReceive->sum('payment_amount') + $user->serviceSalesDueReceive->sum('payment_amount');
                                            ?>
                                            {{ $user->outdoorPayments->sum('payment_amount') + $user->indoorDueReceive->sum('payment_amount') + $user->serviceSalesDueReceive->sum('payment_amount') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-danger text-center">No Data Found !</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td class="text-right" colspan="3"><strong>Total =</strong></td>

                                    <td><b></b>{{ $total }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('custom_js/printThis.js')}}"></script>
    <script type="text/javascript">
        function printPage(id) {
            window.print();
            // $('#' + id).printThis({
            //     'importStyle': true,
            //     'importCSS': true,
            // });
        }
    </script>
@endsection