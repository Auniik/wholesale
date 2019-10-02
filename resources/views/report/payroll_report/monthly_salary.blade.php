
@extends('layout.app')   <!-- Created by DT 19.08.2018 -->
@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .emp_img{
            height: 35px;
            width: 35px;
            border: solid 1px #dcdcdc;
            padding: 2px;
            border-radius: 20px;
        }
        .modal-dialog{
            width: 740px;
        }
    </style>
	<div id="content" class="content min-form" style="min-height: 700px;">
		<?php
			$msg = Session::get('msg');
			echo $msg;
            Session::put('msg','');
            $year = date('Y');
		?>
		<div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <div class="pull-right">
                                {{-- <button class="btn btn-info" onclick="addEmptype()">Find</button> --}}
                            </div>
                        </div>
                        <h4 class="panel-title">Salary Informetion</h4>
                    </div>
                    <!-- <input type="text" style="border:0;border-color: #fff;outline: 0;height: 1px;color: #fff"> -->
                    <div class="panel-body" id="tabArea">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select id="month" class="form-control" name="month" required>
                                            <option value="">Select Month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="year" value="{!! $year !!}" maxlength="4" placeholder="Year" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="submit" class="btn btn-info"> Get</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		    <div class="col-md-12 hidden" id="view">
	            <div class="panel">
	                <div class="panel-heading">
                        <div class="panel-heading-btn">
                        </div>
	                    <h4 class="panel-title">Salary Report</h4>
	                </div>
	                <!-- <input type="text" style="border:0;border-color: #fff;outline: 0;height: 1px;color: #fff"> -->
	                <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%">Department</th>
                                            <th width="5%">Salary</th>
                                            <th width="15%">Bonus</th>
                                            <th width="15%">Provident Fund</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load_data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
					</div>
	            </div>
	        </div>
	    </div>
	</div>

@endsection
@section('script')
<script>
    $('#submit').click(function(){

        var month   = $('#month').val();
        var year    = $('#year').val();
        var url = '';

        if(month=='' || year==''){
            if(month==''){
                $('#month').parent().addClass('has-error');
            }else{
                $('#month').parent().removeClass('has-error');
            }
            if(year==''){
                $('#year').parent().addClass('has-error');
            }else{
                $('#year').parent().removeClass('has-error');
            }
        }else{
            $.ajax({
                type    : 'post',
                url     : url,
                data    : {'month':month,'year':year,'_token':'{{csrf_token()}}'},
                dataType: 'json',
                success : function(data){
                    console.log(data);
                    var htmls = '';
                    for (var key in data){
                        htmls+= '<tr>'+
                                    '<td>'+data[key]['employee_data']+'</td>'+
                                    '<td>'+data[key]['payable']+' '+'.BDT</td>'+
                                    '<td>'+data[key]['payable']+' '+'.BDT</td>'+
                                    '<td>'+data[key]['payable']+' '+'.BDT</td>'+
                                '</tr>';
                    }
                    $('#load_data').html(htmls);
                    $('#view').removeClass('hidden');
                },
                error : function(data){
                    console.log(data);
                    alert('sorry');
                }
            });
        }
    });

</script>


@endsection
