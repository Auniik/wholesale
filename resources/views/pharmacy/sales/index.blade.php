@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('pharmacy-sales-create')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="{{route('inventory-product-sales.create')}}">Sell Products</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">All Sold Products</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row search-voucher">
                            <form method="get">
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="patient_id">Patient / Customer
                                        Name</label>
                                    <div class="col-md-12 ">
                                        <select name="patient_id" id="patient_id" class="form-control select">
                                            <option value="">Select All</option>
                                            @foreach($patients as $id => $name)
                                                <option value="{{$id}}" {{request('patient_id') == $id ? 'selected' :
                                                ''}}>{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="invoice">Invoice ID :</label>
                                    <div class="col-md-12">
                                        <input type="number" name="invoice_id" value="{{request('invoice_id')}}"
                                               class="form-control" placeholder="Invoice ID">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-md-12 no-padding" >&nbsp;</label>
                                    <div class="col-sm-12 no-padding">
                                        <button type="submit" style="margin-top: 2px;" class="btn btn-success col-md-12">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                                <th width="1%">Sl</th>
                                <th>Invoice ID</th>
                                <th>Patient/Customer</th>
                                <th>Date</th>
                                <th class="text-right">Total Amount</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Paid</th>
                                <th class="text-right">Due</th>
                                <th width="8%" colspan="3" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $sales->firstItem() )
                            @foreach($sales as $sale)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>{{$sale->invoice_id}}</td>
                                    <td>{{$sale->patient_name}}</td>
                                    <td>{{$sale->date->format('d/m/Y')}}</td>
                                    <td class="text-right">{{$sale->subtotal}}</td>
                                    <td class="text-right">{{$sale->discount}}</td>
                                    <td class="text-right">{{$sale->paid}}</td>
                                    <td class="text-right">{{$sale->due}}</td>

                                    @can('pharmacy-sales-create')
                                        <td>

                                            <a href="{{route('pharmacy-sales.create', $sale->id)}}"
                                               class="btn btn-xs btn-warning" ><i class="fa fa-usd"></i></a>
                                        </td>
                                    @endcan

                                    @can('pharmacy-sales-show')
                                    <td><a href="{{route('inventory-product-sales.show', $sale->id)}}" class="btn btn-xs btn-warning" ><i class="fa fa-eye"></i></a></td>
                                    @endcan
{{--                                    <td><a href="{{route('inventory-product-sales.edit', $sale->id)}}" class="btn btn-xs btn-success" ><i class="fa fa-pencil-square-o"></i></a></td>--}}
                                    @can('pharmacy-sales-delete')
                                    <td><a href="{{route('inventory-product-sales.destroy', $sale->id)}}" class="btn btn-xs btn-danger deletable"><i class="fa fa-trash-o"></i></a></td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection