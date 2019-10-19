@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('pharmacy-purchase-create')
                            <div class="panel-heading-btn pull-right">
                                <a class="btn btn-primary btn-sm" href="/quotations/create">Add New
                                    Quotation</a>
                            </div>
                        @endcan
                        <h4 class="panel-title">Challans of Quotation</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th>Challan ID</th>
                                <th>Date</th>
                                <th>Party Name</th>
                                <th>Ship to</th>
                                <th>Transport Mode</th>
                                <th width="8%" colspan="3" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = $challans->firstItem() )
                            @foreach($challans as $challan)
                                <tr class="odd gradeX">
                                    <td>{{$sl++}}</td>
                                    <td>
                                        {{--@can('pharmacy-purchase-show')--}}
                                        <a  href="{{route('challans.show',$challan->id)
                                        }}">{{$challan->invoice_id}}</a>
                                        {{--@endcan--}}
                                    </td>
                                    <td>{{$challan->date->format('d-m-Y')}}</td>
                                    <td>{{$challan->party->name}}</td>
                                    <td>{{$challan->shipping_address}}</td>
                                    <td>{{$challan->transport_mode}}</td>
                                    <td>
                                        <a href="{{route('challans.edit', $challan->id)
                                        }}" class="btn btn-xs btn-success"><i class="fa fa-pencil-square-o"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{--                                        @can('pharmacy-purchase-delete')--}}
                                        <a href="{{route('challans.destroy', $challan->id) }}"
                                           class="btn btn-xs btn-danger deletable">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        {{--@endcan--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $challans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
