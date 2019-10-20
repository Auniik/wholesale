@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('pharmacy-sales-create')
                        <div class="panel-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="{{route('product.sales.create')}}">Sell Products</a>
                        </div>
                        @endcan
                        <h4 class="panel-title">All Sold Products</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row search-voucher">
                            <form method="get">
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="party_id">Party Name</label>
                                    <div class="col-md-12 ">
                                        <input name="party_id" id="party_id" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12" for="invoice">Invoice ID :</label>
                                    <div class="col-md-12">
                                        <input type="number" name="invoice_id" value="{{request('invoice_id')}}"
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
                                <th width="1%">Sl</th>
                                <th>Invoice ID</th>
                                <th>Patient/Customer</th>
                                <th>Date</th>
                                <th class="text-right">Total Amount</th>
                                {{--<th class="text-right">Discount</th>--}}
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
                                    <td>{{$sale->party->name}}</td>
                                    <td>{{$sale->date->format('d/m/Y')}}</td>
                                    <td class="text-right">{{$sale->amount}}</td>
                                    {{--<td class="text-right">{{$sale->discount}}</td>--}}
                                    <td class="text-right">{{$sale->paid}}</td>
                                    <td class="text-right">{{$sale->due}}</td>

                                    @can('pharmacy-sales-create')
                                        {{--<td>--}}

                                            {{--<a href="{{route('product.sales.create', $sale->id)}}"--}}
                                               {{--class="btn btn-xs btn-warning" ><i class="fa fa-usd"></i></a>--}}
                                        {{--</td>--}}
                                    @endcan

                                    @can('pharmacy-sales-show')
                                    <td><a href="{{route('product.sales.show', $sale->id)}}" class="btn btn-xs
                                    btn-warning" ><i class="fa fa-eye"></i></a></td>
                                    @endcan
{{--                                    <td><a href="{{route('inventory-product-sales.edit', $sale->id)}}" class="btn btn-xs btn-success" ><i class="fa fa-pencil-square-o"></i></a></td>--}}
                                    @can('pharmacy-sales-delete')
                                    <td><a href="{{route('product.sales.destroy', $sale->id)}}" class="btn
                                    btn-xs
                                    btn-danger deletable"><i class="fa fa-trash-o"></i></a></td>
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

@section('script')
    <script>
        $(() => {
            $("#party_id").select2({
                placeholder: "Search for a Party",
                minimumInputLength: 1,
                ajax: {
                    url: "{{url('load-parties')}}",
                    dataType: 'json',
                    quietMillis: 250,
                    data: (term, page) => {
                        return {
                            name: term, // search term
                        };
                    },
                    results: (data) => {
                        return {
                            results: $.map(data, (item) => {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },

            });
        })

    </script>
@stop


