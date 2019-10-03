@extends('layout.app')
@section('content')
<div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('pharmacy-purchase-create')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="/products/purchases/create">Purchase A New
                                Product</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">All Products Purchases</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">Sl</th>
                                <th>Challan ID</th>
                                <th>Date</th>
                                <th>Manufacturer Name</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Total Paid</th>
                                <th>Due</th>
                                <th width="8%" colspan="2" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $purchases->firstItem() )
                            @foreach($purchases as $purchase)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>
                                        @can('pharmacy-purchase-show')
                                        <a  href="{{route('purchases.show', $purchase->id)
                                        }}">{{$purchase->challan_id}}</a>
{{--                                        @cannot('')--}}
                                        @endcan
                                    </td>
                                    {{--<td>{{$purchase->date->format('d/m/Y')}}</td>--}}
                                    {{--<td>{{$purchase->manufacturer->name}}</td>--}}
                                    {{--<td>{{number_format($purchase->subtotal, 2)}}</td>--}}
                                    {{--<td>{{number_format($purchase->discount, 2)}}</td>--}}
                                    {{--<td>{{number_format($purchase->paid ? $purchase->paid : $purchase->paid_amount, 2)--}}
                                    {{--}}</td>--}}
                                    {{--<td>{{number_format($purchase->due, 2)}}</td>--}}
{{--                                    <td><a href="{{route('inventory-product-purchases.edit', $purchase->id)}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o"></i></a></td>--}}
                                    @if($purchase->approved_at)
                                        <td class="text-center" >
                                            <a href="#" class="btn btn-xs btn-teal" style="margin-right: 1px !important;" disabled title="Approved at: {{$purchase->approved_at}}">Approved</a>
                                        </td>

                                        <td class="text-center">
                                            <label class="btn btn-xs btn-default"
                                                   disabled="">{{$purchase->totalAmount != $purchase->paid ? 'Partial' : 'Paid'}}</label>
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" style="width:64px" class="btn btn-xs btn-warning dropdown-toggle" @cannot('pharmacy-purchase-approve')  @endcan data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pending
                                                </button>
                                                {{--@can('pharmacy-purchase-approve')--}}
                                                    <ul class="dropdown-menu" style="min-width: 80px; left: 6px; top: 80%;">
                                                        <li><a href="{{action('Pharmacy\InventoryProductPurchaseController@edit', $purchase->id)}}"
                                                               class="bg-default">Approve</a></li>
                                                    </ul>
                                                {{--@endcan--}}
                                            </div>
                                        </td>
                                        <td></td>
                                    @endif
                                    <td>
                                        @if ($purchase->approved_at)
                                            @can('pharmacy-purchase-create')
                                                <a href="{{route('pharmacy-purchases.create', $purchase->id)}}" class="btn btn-xs
                                        btn-warning "><i class="fa fa-usd"></i></a>
                                            @endcan
                                            @else
                                            <button type="button" class="btn btn-xs btn-primary" disabled=""> <i
                                                        class="fa
                                            fa-usd"></i></button>
                                        @endif

                                        @can('pharmacy-purchase-delete')
                                        <a href="{{route('inventory-product-purchases.destroy', $purchase->id)}}" class="btn btn-xs btn-danger deletable"><i class="fa fa-trash-o"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
