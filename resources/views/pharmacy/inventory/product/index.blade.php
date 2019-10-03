@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('inventory-settings-create')
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href="/products/create">Add New Product</a>
                    </div>
                    @endcan
                    <h4 class="panel-title">Inventory Products</h4>
                </div>
                <div class="panel-body">
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="form-group col-md-5 pull-right">--}}
                                {{--<label class="control-label col-md-2 col-sm-2  p-10" for="service_search">Search :</label>--}}
                                {{--<div class="col-md-10 col-sm-10">--}}
                                    {{--<input class="form-control" type="text" value=""  name="service_search" placeholder="Search Service" />--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <table id="datatable" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                            <th width="5%">Sl</th>
                            <th width="10%">Product Id</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Manufacturer</th>
                            <th width="10%">Status</th>
                            <th width="10%" class="text-center" colspan="2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($sl = $products->firstItem())
                        @foreach($products as $product)
                        <tr class="odd gradeX">
                            <td>{{$sl++}}</td>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->manufacturer->name}}</td>
                            <td>{{status($product->status)}}</td>
                            @can('inventory-settings-update')
                            <td class="text-center">
                                <a href="{{route('products.edit', $product->id)}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i></a>
                            </td>
                            @endcan

                            @can('inventory-settings-delete')
                                <td class="text-center">
                                    <a href="{{route('products.destroy', $product->id)}}" class="btn btn-xs btn-danger
                                deletable">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{$products->links()}}

            </div>
        </div>
    </div>

@endsection