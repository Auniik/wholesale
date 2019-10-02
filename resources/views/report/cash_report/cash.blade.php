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
		<div class="col-md-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<button class="btn btn-xs btn-info pull-right printbtn" onclick="printPage('print_body')"><i class="fa fa-print"></i>&nbsp; Print</button>
					<h4 class="panel-title"><i class="fa fa-list-ul"></i> &nbsp; Cash Reports </h4>
				</div>
				<div class="panel-body">
					<!-- <form method="post"> -->
							{!! Form::open(array('url' => 'report-cash-show','class'=>'form-horizontal author_form','method'=>'GET','data-parsley-validate novalidate')) !!}
							<div class="report_filler ">
								<div class="row " >
									<div class="col-md-12 ">
										<div class="col-md-3">
											<label>Select account</label>
											
											<? $id= isset($input)?$input['id']:''?>
                                        	{{Form::select('id',$account,$id,['class'=>'form-control select','placeholder'=>'Select account','required'])}}
										</div>
										<div class="col-md-9">
											<div class="col-md-3 no-padding">
												<label class="control-label col-md-12" for="Date">Start Date* :</label>
													@php $current_date = date('Y-m-d') @endphp
													<input class="form-control datepicker" placeholder="Start Date" name="start" type="text" autocomplete="off" value="{{isset($input)?$input['start']:date('d-m-Y')}}">
											</div>
											<div class="col-md-1 no-padding" style="margin-top: 3px;">
												<label class="col-md-12"> &nbsp; </label>
													<input class="form-control text-center" type="text" value="TO" readonly="" >
											</div>
											<div class="col-md-3 no-padding">
												<label class="control-label col-md-12" for="Date">End Date* :</label>
													<input class="form-control datepicker" placeholder="End Date" name="end" type="text" autocomplete="off" value="{{isset($input)?$input['end']:date('d-m-Y')}}">
											</div>
											<div class="col-md-1 ">
												<label class="col-md-12" for="Date">&nbsp;</label>
													<button type="submit" class="btn btn-success btn-bordred waves-effect w-md waves-light pull-left">
														Confirm
													</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							{!! Form::close(); !!}
							@if(isset($input)) 
							<div class="row" id="print_body">
								<div class="col-md-12">
									<hr>
									<div class="col-md-12 text-center">
										<h4><b>Cash Report</b></h4>
										<p class="text-center"><strong >Report: {{ Request::get('start') }} &nbsp; &nbsp; to &nbsp; &nbsp; {{ Request::get('end') }}</strong>
										<p><b>Account: </b>{{ $accountInfo->account_name }}</p>
									</div>
									<table class="table table-responsive table-hover table-striped table-condensed table-bordered">
										<thead>
											<tr>
												<th>Sl</th>
												<th>Date</th>
												<th>Invoice no</th>
												<th>Particular</th>
												<th>Credit</th>
												<th>Debit</th>
												<th>Balance</th>
											</tr>
										</thead>
										
										<tbody>
										<?php 
											$i = 1;
											$credit_amount = 0;
											$debit_amount = 0;
											$total_amount = $previous_total;
										?>
										<tr style="font-weight: 600">
											<td>1</td>
											<td>{{ Request::get('start') }}</td>
											<td>---</td>
											<td>Previous Balance</td>
											<td class="text-right">@convert(round($previous_total,2))</td>
											<td class="text-right">0.00</td>
											<td class="text-right">@convert(round($previous_total,2))</td>
										</tr>
										@foreach($cash_report as $cash_reports)

										<?php 
										$i++;
											if ($cash_reports->type == 1) {
												$total_amount = $total_amount + $cash_reports->total_amount; 
											}
											else{
												$total_amount = $total_amount - $cash_reports->total_amount; 
											}
										?>
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $cash_reports->date->format('d-M-Y') }}</td>
											
											<td><a href=""> {{ $cash_reports->invoice_no }}</a></td>
											
											<td>
												@if($cash_reports->source_type == 1)
													@foreach(optional(optional($cash_reports->transaction())->getHistoryItem->Payment)->getItems as $item)
														{{ $item->getSector->sector_name }}{{ !$loop->last ? ',' : '' }}
													@endforeach
												@elseif($cash_reports->source_type == 2)
													@foreach(optional(optional($cash_reports->transaction())->getHistoryItem->payment)->getItems as $item)
														{{ $item->getSector->sector_name }}{{ !$loop->last ? ',' : '' }}
													@endforeach
												@elseif($cash_reports->source_type == 3)
													Salary
												@elseif($cash_reports->source_type == 4)
													Balance transfer
												@endif

											</td>

											@if($cash_reports->type == 1)
											<td class="text-right">@convert(round($cash_reports->total_amount,2))</td>
											 
											@else
												<td class="text-right">0.00</td>
											@endif

											@if($cash_reports->type == 2)
												<td class="text-right">@convert(round($cash_reports->total_amount,2))</td>
											
											@else
												<td class="text-right">0.00</td>
											@endif
											<td class="text-right">@convert(round($total_amount,2))</td>
										</tr>
										@if($cash_reports->type == 1)
										@php
											$credit_amount += $cash_reports['total_amount']; 
										@endphp
										@endif
										@if($cash_reports->type == 2)
										@php
											$debit_amount += $cash_reports['total_amount'];
										@endphp
										@endif
										@endforeach
										<tr style="font-weight: 600">
											<td>*</td>
											<td class="text-right" colspan="3">Total Balance =</td>
											<td class="text-right">@convert(round($credit_amount,2))</td>
											<td class="text-right">@convert(round($debit_amount,2))</td>
											<td class="text-right">@convert(round($total_amount,2))</td>
										</tr>
										</tbody>
									</table>
								</div>	
							</div>
							@endif
						
					</div>
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