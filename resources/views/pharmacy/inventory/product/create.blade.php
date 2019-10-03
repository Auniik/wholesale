@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-btn pull-right">
                    <a class="btn btn-success btn-sm" href="{{route('products.index')}}">View Products</a>
                </div>
                <h4 class="panel-title">Add New Product</h4>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{route('products.store')}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <label class="control-label" for="product_name">Name * :</label>
                            <input class="form-control" type="text" id="product_name" name="name"
                                   placeholder="Product Name" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label" for="category">Category * :</label>
                            <select class="form-control select2" id="category" name="category_id" required>
                                <option value="">Select Product Category</option>
                                @foreach ($categories ?? [] as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="manufacturer_id">Manufacturer * :</label>
                            <select class="form-control select2" id="manufacturer_id" name="manufacturer_id" required>
                                <option value="">Select Manufacturer</option>
                                @foreach ($manufacturers ?? [] as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label" for="unit_cost">Unit Cost * :</label>
                            <input class="form-control" value="0" type="number" id="unit_price" min="0"
                                   name="unit_price" placeholder="Unit Cost" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="sales_price">Sales Price * :</label>
                            <input class="form-control" value="0" type="number" id="sales_price" min="0"
                                   name="sales_price" placeholder="Sales Price" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label" for="stock_limitation">Stock Limitation * :</label>
                            <input class="form-control" value="0" type="number" id="stock_limitation" min="0"
                                   name="stock_limitation" placeholder="Stock Limitation" data-parsley-required="true" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="status">Status * :</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" selected="selected">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1"></label>
                        <div class="col-md-6 col-sm-6"><br>
                            <button type="submit" id="submit" class="btn btn-success col-md-12">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#product_name').val('{{old('name')}}')
            $('#category').val('{{old('category_id')}}').change()
            $('#manufacturer_id').val('{{old('manufacturer_id')}}').change()
        })
    </script>
@endsection