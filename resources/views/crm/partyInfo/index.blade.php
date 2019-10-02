@extends('layout.app')
@section('title', 'Party List')
@section('content')
<div id="content" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading-btn pull-right">
                        <a href="{{route('parties.create')}}" class="btn btn-success btn-sm"><i class="icon ion-nav icon-round"></i> Add New Vendor / Supplier</a>
                    </div>
                    <h4 class="panel-title">All Vendor / Supplier </h4>
                </div>
                <div class="panel-body">

                        <div class="row">
                            <form action="">
                            <div class="col-md-12">
                                <div class="form-group col-md-5 pull-right">
                                    <div class="col-md-10 col-sm-10">
                                        <input type="text" placeholder="Party Name" name="party_name"
                                               value="{{request('party_name')}}"
                                               class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-success col-md-2 col-sm-2">Search</button>
                                </div>
                            </div>
                            </form>
                        </div>


                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th>Name</th>
                                <th>Telephone</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th width="10%">Status</th>
                                <th colspan="2" width="5%" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @php($sl = $parties->firstItem())
                        @foreach($parties as $key => $party)
                            <tr>
                                <td>{{$sl++}}</td>
                                {{--<td> <a href="{{route('patients.show',$hospitalService->id)}}" class="btn btn-xs btn-link">{{$hospitalService->name}}</a></td>--}}
                                <td>{{$party->name}}</td>
                                <td>{{$party->telephone}}</td>
                                <td>{{$party->mobile_number}}</td>
                                <td>{{$party->email}}</td>

                                <td>{{status($party->status)}}</td>
                                <td><a class="btn btn-xs btn-success" href="{{route('parties.edit', $party)}}"><i class="fa fa-edit"></i></a></td>
                                <td>
                                    <form method="POST" action="{{route('parties.destroy', $party)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirmDelete();"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{$parties->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

