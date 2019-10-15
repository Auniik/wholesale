@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('pharmacy-purchase-create')
                            <div class="panel-heading-btn pull-right">
                                <a class="btn btn-primary btn-sm" href="/quotations/create">Add New
                                    Quotation</a>
                            </div>
                        @endcan
                        <h4 class="panel-title">All Quotations</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th>Invoice ID</th>
                                <th>Date</th>
                                <th>Party Name</th>
                                <th>Ship to</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th width="8%" colspan="3" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $quotations->firstItem() )
                            @foreach($quotations as $quotation)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>
                                        {{--@can('pharmacy-purchase-show')--}}
                                            <a  href="{{route('quotations.show', $quotation->id)
                                        }}">{{$quotation->invoice_id}}</a>
                                        {{--@endcan--}}
                                    </td>
                                    <td>{{$quotation->date}}</td>
                                    <td>{{$quotation->party->name}}</td>
                                    <td>{{$quotation->shipping_address}}</td>
                                    <td>{{number_format($quotation->amount, 2)}}</td>
                                    <td>{{number_format($quotation->discount, 2)}}</td>
                                    <td><a href="/quotations/{{$quotation->id}}/challans/create" class="btn
                                    btn-xs btn-warning" data-toggle="modal"><i class="fa fa-cart-plus"></i></a></td>
                                    <td><a href="{{route('quotations.edit', $quotation->id)}}" class="btn
                                    btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td>
{{--                                        @can('pharmacy-purchase-delete')--}}
                                            <a href="{{route('quotations.destroy', $quotation->id)}}" class="btn
                                        btn-xs btn-danger deletable"><i class="fa fa-trash-o"></i></a>
                                        {{--@endcan--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $quotations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
