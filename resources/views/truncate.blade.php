
@extends('layout.app')
@section('content')
    <!-- begin #content -->
    <div id="content" class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                        </div>
                        <h4 class="panel-title">All Table From Databse</h4>
                    </div>

                    <!--  -->
                    <div class="view_uom_set">
                        <div class="panel-body">
                            <legend class="alert alert-warning text-center">Careful! Your simple mistake can cause big trouble.</legend>

                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Sl</th>
                                    <th width="65%">Tabel Name</th>
                                    <th width="10%">Total Data</th>
                                    <th width="15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                @foreach($allData as $key => $data)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$data['table']}}</td>
                                        <td>{{$data['row']}}</td>
                                        <td>
                                            <? $table = $data['table']; ?>
                                            {!! Form::open(array('url' =>"truncate/$table",'method'=>'GET','id'=>'form')) !!}
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirmDelete()"><i class="fa fa-trash"></i></button>
                                            {!! Form::close() !!}
                                        </td>

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
    <!-- end #content -->
@endsection
