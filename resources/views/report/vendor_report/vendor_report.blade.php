@extends('layout.app')
@section('content')
@php
	
@endphp
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
					<h4 class="panel-title"><i class="fa fa-list-ul"></i> &nbsp; Vendor wise Reports </h4>
				</div>
				<div class="panel-body">
					<!-- <form method="post"> -->
						
							{!! Form::open(array('url' => 'report-vendor-wise-show','class'=>'form-horizontal author_form','method'=>'GET','data-parsley-validate novalidate')) !!}
							<div class="report_filler ">
								<div class="row " >
									<div class="col-md-12 ">
										<div class="col-md-3">
											<label>Select Client</label>
											
											<? $id= isset($input)?$input['id']:''?>
                                        	{{Form::select('id',$vendor,$id,['class'=>'form-control select','placeholder'=>'Select vendor','required'])}}
										</div>
										<div class="col-md-9">
											<div class="col-md-3 no-padding">
												<label class="control-label col-md-12" for="Date">Start Date* :</label>
													@php $current_date = date('d-m-Y') @endphp
													<input class="form-control datepicker" placeholder="Start Date" name="start" type="text" value="{{isset($input)?$input['start']:date('d-m-Y')}}">
											</div>
											<div class="col-md-1 no-padding" style="margin-top: 3px;">
												<label class="col-md-12"> &nbsp; </label>
													<input class="form-control text-center" type="text" value="TO" readonly="" >
											</div>
											<div class="col-md-3 no-padding">
												<label class="control-label col-md-12" for="Date">End Date* :</label>
													<input class="form-control datepicker" placeholder="End Date" name="end" type="text" value="{{isset($input)?$input['end']:date('d-m-Y')}}">
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
						<hr>
							<div class="row" id="print_body">
								<div class="col-md-12">
									<div class="col-md-12 text-center">
										<h4><b>Vendor Report</b></h4>
										<p class="text-center"><strong >Report: {{ Request::get('start') }} &nbsp; &nbsp; to &nbsp; &nbsp; {{ Request::get('end') }}</strong>
										<p><b>Vendor: </b>{{ $vendorInfo->company_name}}, <b>Email: </b>{{ $vendorInfo->email_id}}, <b>Mobile: </b>{{ $vendorInfo->mobile_no}}, <b>Address: </b>{{ $vendorInfo->address}}, </p>
									</div>
									<table class="table table-responsive table-hover table-striped table-condensed table-bordered">
										<thead>
											<tr>
												<th>Sl</th>
												<th>Date</th>
												<th>Invoice no</th>
												<th>Particular</th>
												<th>Payable</th>
												<th>Paid</th>
												<th>due</th>
											</tr>
										</thead>
										<tbody>
											@php 
												$i = 0; 
												$total_payable = 0;
												$total_paid = 0;
												$total_dues = 0;
											@endphp 
											@foreach($vendor_report as $vendor_reports)
											@php 
												$i++; 
												
												$total_due = $vendor_reports->total_amount - $vendor_reports->total_paid;
											@endphp
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $date = date('d-M-Y', strtotime($vendor_reports->created_at)) }}</td>
												<td>{{ $vendor_reports->invoice_no }}</td>
												<td>{{ $vendor_reports->total_amount }}</td>
												<td>
													@foreach(optional($vendor_reports->getHistoryItem->payment)->getItems as $item)
														{{optional($item->getSector)->sector_name}}{{ !$loop->last ? ',' : '' }}
													@endforeach
												</td>
												<td>{{ $vendor_reports->total_paid }}</td>
												<td>{{ $total_due }}</td>
											</tr>
											@php
												$total_payable += $vendor_reports['total_amount'];
												$total_paid += $vendor_reports['total_paid'];
												$total_dues += $total_due;
											@endphp
											@endforeach

											<tr style="font-weight: 600">
												<td class="text-right" colspan="4">Total =</td>
												<td>{{ $total_payable }}</td>
												<td>{{ $total_paid }}</td>
												<td>{{ $total_dues }}</td>
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