@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @can('inventory-settings-create')
                    <div class="panel-heading-btn pull-right">
                        <a class="btn btn-success btn-sm" href="{{route('inventory-products.create')}}">Add New Product</a>
                    </div>
                    @endcan
                    <h4 class="panel-title">Inventory Products</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-md-5 pull-right">
                                <label class="control-label col-md-2 col-sm-2  p-10" for="service_search">Search :</label>
                                <div class="col-md-10 col-sm-10">
                                    <input class="form-control" type="text" value=""  name="service_search" placeholder="Search Service" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                            <th width="5%">Sl</th>
                            <th width="10%">Product Id</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Manufacturer</th>
                            <th width="10%">Unit</th>
                            <th width="10%">Status</th>
                            <th width="10%" class="text-center">Action</th>
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
                            <td>{{$product->brand->name}}</td>
                            <td>{{$product->unit->name}}</td>
                            <td>{{status($product->status)}}</td>
                            @can('inventory-settings-update')
                            <td class="text-center">
                                <!-- edit section -->
                                <a href="{{route('inventory-products.edit', $product->id)}}" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i></a>
                                <!-- #modal-dialog -->
                                <div class="modal fade" id="modal-dialog{{$product->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form">
                                                @csrf
                                                @method('patch')
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Product Edit</h4>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3" for="product_name">Product Name * :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="text" id="product_name" name="name" value="{{$product->name}}" data-parsley-required="true" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3" for="specification">Product Category *:</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <select class="form-control" id="select-required" name="category_id" data-parsley-required="true">
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}" {{$product->category_id==$category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3" for="specification">Product Unit *:</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <select class="form-control" id="select-required" name="unit_id" data-parsley-required="true">
                                                            @foreach($units as $unit)
                                                                <option value="{{$unit->id}}" {{$product->unit_id == $unit->id ? 'selected' : ''}}>{{$unit->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3" for="stock_limitation">Stock limitation :</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control" type="number" id="stock_limitation" name="stock_limitation" placeholder="Stock limitation" min="0" step="any" value="{{$product->stock_limitation}}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3">Product Status *:</label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" value="1" id="radio-required" {{$product->status ? 'checked' : ''}} /> Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="status" id="radio-required2" value="0" {{!$product->status ? 'checked' : ''}}/> Inactive
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--<input type="hidden" name="product_id" value="{{$product->product_id}}">--}}
                                                <div class="modal-footer">
                                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end edit section -->
                            </td>
                            @endcan

                            {{--@can('inventory-settings-delete')--}}
                            {{--<td class="text-center">--}}
                                {{--<!-- delete section -->--}}
                                {{--<form method="POST" action="{{route('inventory-products.destroy', $product)}}" class="del-btn" accept-charset="UTF-8">--}}
                                    {{--@csrf--}}
                                    {{--@method('delete')--}}
                                    {{--<button type="submit" onclick="return confirmDelete();" class="btn btn-xs btn-danger">--}}
                                        {{--<i class="fa fa-trash-o" aria-hidden="true"></i>--}}
                                    {{--</button>--}}
                                {{--</form>--}}
                                {{--<!-- delete section end -->--}}
                            {{--</td>--}}
                            {{--@endcan--}}
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