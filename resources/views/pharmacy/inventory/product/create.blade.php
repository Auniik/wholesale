@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-btn pull-right">
                    <a class="btn btn-success btn-sm" href="{{route('inventory-products.index')}}">View Products</a>
                </div>
                <h4 class="panel-title">Add New Product</h4>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{route('inventory-products.store')}}" accept-charset="UTF-8" class="form-horizontal author_form" id="commentForm" role="form" data-parsley-validate novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <label class="control-label" for="specification">Name * :</label>
                            <input class="form-control" type="text" id="product_name" name="name" placeholder="Product Name" value="{{old('name')}}" data-parsley-required="true" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label" for="specification">Category * :</label>
                            <select class="form-control select2" id="category" name="category_id" required>
                                <option value="">Select Product Category</option>
                                @foreach ($categories ?? [] as $category)
                                    <option value="{{optional($category)->id}}">{{optional($category)->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="specification">Manufacturer * :</label>
                            <select class="form-control select2" id="brand_id" name="brand_id" required>
                                <option value="">Select Manufacturer</option>
                                @foreach ($brands ?? [] as $brand)
                                    <option value="{{optional($brand)->id}}">{{optional($brand)->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <label class="control-label" for="specification">Pack Size :</label>
                            <input class="form-control" value="0" type="number" id="pack_size" min="0" name="pack_size" placeholder="Stock Limitation"  />
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="retail_unit_id">Retail Unit * :</label>
                            <select class="form-control select2" id="retail_unit_id" name="unit_id" required>
                                <option value="">Select Product Unit</option>
                                @foreach ($units->get('retail', []) as $unit)
                                    <option value="{{optional($unit)->id}}">{{optional($unit)->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1" style="width: 4%">
                            <h1 class="mt-20">=</h1>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="wholesale_unit_id">Wholesale Unit * :</label>
                            <select class="form-control select2" id="wholesale_unit_id" name="wholesale_unit_id" required>
                                <option value="">Select Product Unit</option>
                                @foreach ($units->get('wholesale', []) as $unit)
                                    <option value="{{optional($unit)->id}}">{{optional($unit)->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label" for="unit_cost">Unit Cost * :</label>
                            <input class="form-control" value="0" type="number" id="unit_cost" min="0" name="unit_cost" placeholder="Stock Limitation" data-parsley-required="true" />
                            <input type="hidden" name="retail_unit_tp" id="retail_unit_cost"/>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="stock_limitation">Sales Price * :</label>
                            <input class="form-control" value="0" type="number" id="sales_price" min="0" name="sales_price" placeholder="Stock Limitation" data-parsley-required="true" />
                            <input type="hidden" name="retail_sales_price" id="retail_sales_price"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label" for="stock_limitation">Stock Limitation * :</label>
                            <input class="form-control" value="0" type="number" id="stock_limitation" min="0" name="stock_limitation" placeholder="Stock Limitation" data-parsley-required="true" />
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
        $('#pack_size, #unit_cost, #sales_price').keyup(function (e) {
            let unitCost = parseFloat($('#unit_cost').val())
            let packSize = parseFloat($('#pack_size').val())
            let salesPrice = parseFloat($('#sales_price').val())

            if (packSize<=0){
                alert('Enter Pack Size!');
            }
            else{
                $('#retail_unit_cost').val((unitCost/packSize).toFixed(2));
                $('#retail_sales_price').val((salesPrice/packSize).toFixed(2));
            }

        })
    </script>
@endsection