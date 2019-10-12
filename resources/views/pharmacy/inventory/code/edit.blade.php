@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel">
                    <div class="panel-heading">
                        <div class="panel-heading-btn pull-right">
                            @can('inventory-settings-create')
                                <div class="create_button">
                                    <a href="/products/codes" class="btn btn-sm btn-success" >All Codes</a>
                                </div>
                            @endcan
                        </div>
                        <h4 class="panel-title">Edit Product Code </h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form action="{{route('product.codes.update', $code->id)}}" method="post">
                                @csrf
                                @method('patch')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="">Code Name</label>
                                        <input class="form-control" type="text" value="{{$code->name}}" name="name"
                                        autocomplete="off"
                                               placeholder="Code name">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="">Product Name</label>
                                        <input class="form-control product_name" type="text" value="{{$code->product->name}}"
                                               autocomplete="off" placeholder="Product name">
                                        <input type="hidden" name="product_id" class="product_id"
                                               value="{{$code->product_id}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="">Quantity</label>
                                        <input class="form-control" type="text" value="{{$code->quantity}}" name="name"
                                               autocomplete="off" readonly
                                               placeholder="Quantity">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">&nbsp;</label>
                                                <button type="submit" class="btn btn-success col-md-12">Save
                                                    Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
            selector: '.product_name',
            url: '{{url('/load-product')}}',
            select: function (event, ui) {
                $('.product_id').val(ui.item.data.id);
            },
            search: function (event) {

            }
        })
    </script>

@stop