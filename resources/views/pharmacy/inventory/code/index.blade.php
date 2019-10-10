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
                                    <a href="dd#modal-dialog" class="btn btn-sm btn-success"
                                       data-toggle="modal">Add New Code</a>
                                </div>
                            @endcan
                        </div>
                        <h4 class="panel-title">Product Codes </h4>
                    </div>
                    <div class="panel-body">
                    @can('inventory-settings-create')
                        <!-- #modal-dialog -->
                            <div class="modal fade" id="modal-dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('product.codes.store')}}"
                                              class="form-horizontal">
                                            @csrf
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Set Product Code</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-2 col-sm-2">Code *:</label>
                                                    <div class="col-md-10 col-sm-10">
                                                        <input type="text" class="form-control" name="name"
                                                               autocomplete="off" placeholder="Enter Code Name">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-2 col-sm-2">Product Name
                                                        *:</label>
                                                    <div class="col-md-10 col-sm-10">
                                                        <input type="text" class="form-control product_name" autocomplete="off"
                                                               placeholder="Search Product name">
                                                        <input type="hidden" class="product_id" name="product_id">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                                <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <!--  -->
                    <div class="view_category_set">
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th>Name</th>
                                    <th width="5%" class="text-center" colspan="2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($sl = $codes->firstItem())
                                @foreach($codes as $code)
                                    <tr class="odd gradeX">
                                        <td>{{$sl++}}</td>
                                        <td>{{$code->name}}</td>
                                        @can('inventory-settings-update')
                                            <td>
                                                <a href="codes/{{$code->id}}/edit" class="btn btn-xs btn-success" ><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            </td>
                                        @endcan
                                        @can('inventory-settings-delete')
                                            <td>
                                                <a href="{{route('product.codes.destroy', $code->id)}}"
                                                   class="btn btn-xs btn-danger deletable">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

        // $('#exampleModal').on('show.bs.modal', function (event) {
        //     var button = $(event.relatedTarget) // Button that triggered the modal
        //     var recipient = button.data('whatever') // Extract info from data-* attributes
        //     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        //     // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        //     var modal = $(this)
        //     modal.find('.modal-title').text('New message to ' + recipient)
        //     modal.find('.modal-body input').val(recipient)
        // })

        // function editModal(code_id){
        //     modal.show();
        // }

    </script>
@endsection