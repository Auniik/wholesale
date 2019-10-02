@extends('layout.app')
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

</style>
	<div class="row">
		<div class="panel panel-inverse">
		<div class="panel-heading">
			<button class="btn btn-xs btn-info pull-right printbtn" onclick="printPage('print_body')"><i class="fa fa-print"></i>&nbsp; Print</button>
			<h4 class="panel-title"><i class="fa fa-list-ul"></i> &nbsp; Income Expense Reports </h4>
		</div>
		<div class="panel-body">
			<!-- <form method="post"> -->
			<form action="{{ url('report-income-expense-show') }}" method="GET">
					<div class="report_filler ">
						<div class="row " >
							<div class="col-md-10 col-md-offset-1 search_header">
								<div class="form-group col-md-4">
									<label class="control-label col-md-12" for="Date">Start Date* :</label>
									<div class="col-md-12">
										<input class="form-control datepicker" placeholder="Start Date" name="start" type="text" value="{{isset($input)?$input['start']:date('d-m-Y')}}">
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
										<input class="form-control datepicker" placeholder="End Date" name="end" type="text" value="{{isset($input)?$input['end']:date('d-m-Y')}}">
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
						<hr>
					</div>
					</form>
					@if(isset($input))
					<div class="row" id="print_body">
						<div class="col-md-12 col-xs-12">
							<div class="row">
								<h4 class="text-center"><strong>Income Expense Report</strong></h4>
								<div class="col-md-6 col-xs-6">
									<p><strong><span class="text-left">Start Date: &nbsp; {{ $input['start'] }}</span></strong></p>
								</div>
								<div class="col-md-6 col-xs-6">
									<p class="text-right"><strong>End Date: &nbsp; {{ $input['end'] }}</strong></p>
								</div>
							</div>
						</div>

						<div class="col-md-12 col-xs-12">
							<div class="row">
								<div class="col-md-6 col-xs-5" >
									<legend ><p class="" style="border-bottom: none">Expense</p></legend>
									<table class="table table-bordered">
										<thead class="alert alert-success">
											<tr>
												<th>Sl</th>
												<th>Sector name</th>
												<th>Amount</th>
											</tr>
										</thead>
										<tbody>
											@php
												$i = 0;
												$expense = 0;
											@endphp
											@foreach($sectorPayment as $sector_payment)
											@php $i++; @endphp
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $sector_payment->getSector->sector_name }}</td>
												<td>{{ $sector_payment->totals }}</td>
											</tr>
											@php
												$expense += $sector_payment['totals'];
											@endphp
											@endforeach
											<tr>
												<td>{{$i+1}}</td>
												<td>salary</td>
												<td>{{ $salary->total_salary }}</td>
											</tr>
											<tr>
												<td>*</td>
												<td class="text-right"><strong>Total =</strong></td>

												<td><b>@php echo  $expense+$salary->total_salary @endphp</b></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-6 col-xs-5" >
									<legend ><p class="" style="border-bottom: none">Income</p></legend>
									<table class="table  table-bordered">
										<thead class="alert alert-success">
											<tr>
												<th>Sl</th>
												<th>Sector name</th>
												<th>Amount</th>
											</tr>
										</thead>
										<tbody>
											@php
												$i = 1;
												$income = 0;
											@endphp
											@foreach($sectorIncome as $sector_income)
											@php $i++; @endphp
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $sector_income->getSector->sector_name }}</td>
												<td>{{ $sector_income->totals }}</td>
											</tr>
											@php
												$income += $sector_income['totals'];
											@endphp
											@endforeach
											<tr>
												<td>*</td>
												<td class="text-right"><strong>Total =</strong></td>
												<td><b>@php echo $income @endphp</b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							</div>
							{{--<div class="col-md-12 alert alert-success" style="margin-top: 20px">--}}
								{{--<legend ><p class="btn btn-sm btn-default" style="border-bottom: none">Total Loss Or Profit</p></legend>--}}
								{{--<table class="table table-striped table-hover table-bordered">--}}
									{{--<thead class="alert alert-success">--}}
										{{--<tr>--}}
											{{--<th>From Date</th>--}}
											{{--<th>To Date</th>--}}
											{{--<th>Total Income</th>--}}
											{{--<th>Total Expense</th>--}}
											{{--<th>Profit Or Loss</th>--}}
										{{--</tr>--}}
									{{--</thead>--}}
									{{--<tbody>--}}
										{{--<tr>--}}
											{{--<td>{{ $input['start'] }}</td>--}}
											{{--<td>{{ $input['end'] }}</td>--}}
											{{--<td >{{ $income }}</td>--}}
											{{--<td>{{ $expense }}</td>--}}
											{{--<td>{{ $income-$expense }}</td>--}}
										{{--</tr>--}}
									{{--</tbody>--}}
								{{--</table>--}}
							{{--</div>--}}

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
            $('#' + id).printThis({});
        }
    </script>
@endsection