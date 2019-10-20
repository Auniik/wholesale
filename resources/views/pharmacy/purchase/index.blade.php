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
                        <div class="row search-voucher">
                            <form method="get">
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="manufacturer_id">Manufacturer Name
                                        :</label>
                                    <div class="col-md-12 ">
                                        <input type="hidden" id="manufacturer_id" name="manufacturer_id">
                                        <input type="text" class="form-control manufacturer_name"
                                               placeholder="Manufacturer Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="service">Invoice ID :</label>
                                    <div class="col-md-12">
                                        <input type="text" name="invoice_id" value="{{request('invoice_id')}}"
                                               class="form-control" placeholder="Invoice ID" autocomplete="off">
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
                                <th width="5%">Sl</th>
                                <th>Challan ID</th>
                                <th>Date</th>
                                <th>Manufacturer Name</th>
                                <th>Total Amount</th>
                                {{--<th>Discount</th>--}}
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
                                        <a  href="{{route('product.purchases.show', $purchase->id)
                                        }}">{{$purchase->challan_id}}</a>
{{--                                        @cannot('')--}}
                                        @endcan
                                    </td>
                                    <td>{{$purchase->date->format('d/m/Y')}}</td>
                                    <td>{{$purchase->manufacturer->name}}</td>
                                    <td>{{number_format($purchase->amount, 2)}}</td>
                                    {{--<td>{{number_format($purchase->discount, 2)}}</td>--}}
                                    <td>{{number_format($purchase->paid, 2)
                                    }}</td>
                                    <td>{{number_format($purchase->due, 2)}}</td>
                                    <td class="text-center">
                                        <label class="btn btn-xs btn-default"
                                               disabled="">{{$purchase->totalAmount != $purchase->paid ? 'Partial' : 'Paid'}}</label>
                                    </td>
                                    {{--<td><a href="{{route('product.purchases.edit', $purchase->id)}}" class="btn--}}
                                    {{--btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o"></i></a></td>--}}
                                    <td>
                                        @can('pharmacy-purchase-delete')
                                        <a href="{{route('product.purchases.destroy', $purchase->id)}}" class="btn
                                        btn-xs btn-danger deletable"><i class="fa fa-trash-o"></i></a>
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

@section('script')
    <script src="{{asset('custom_js/loadDetails.js')}}"></script>
    <script>

        loadDetails({
            selector: '.manufacturer_name',
            url: '{!! url('/load-manufacturers') !!}',
            select: (event, ui) => {
                $(this.selector).val(ui.item.data.name);
                $("#manufacturer_id").val(ui.item.data.id);
                if ($("#manufacturer_id").val()){
                    $(this.selector).removeClass('has-error').attr('title', '');
                }
            },
            search: function (event) {
                $(this.selector).addClass('has-error').prop('title', 'Party Not Recognized');
                $("#manufacturer_id").val('');
            }
        });
    </script>
@stop
