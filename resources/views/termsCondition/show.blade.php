@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info page-panel">
                <div class="panel-heading">
                    Terms &amp; Condition
                    <div class="panel-btn pull-right">
                        <a href="{{URL::to('terms-condition/create')}}" class="btn btn-info btn-sm"> <i class="fa fa-plus"></i>  Add New </a>
                        <a href="{{URL::to('terms-condition')}}" class="btn btn-success btn-sm"> <i class="fa fa-asterisk"></i>  View All</a>
                    </div>
                </div>
                <div class="panel-body">

    <section class="col-md-12">
        <div class="hotel-view-main padding-top padding-bottom">
            <div class="p">
                <div class="journey-block">

                    <div class="col-md-12">
                        <div class="service_head">
                            <h2>{{$data->name}}</h2>
                            <div class="service_info">
                                <h5><b>Title: </b> {{$data->title}}</h5>
                            </div>
                            @if($data->file!=null)
                                <div id="pdf">
                                  <object type="application/pdf" data='{{asset("files/page/$data->file")}}?#zoom=110&scrollbar=0&toolbar=0&navpanes=0' id="pdf_content">
                                    <p>Not Found PDF File.</p>
                                  </object>
                                </div>
                            @endif
                            <div><b><u>Description:</u></b><br><? echo $data->description ?></div>
                        </div>
                    </div><!-- End col-md-11 -->

                    
    </section>
<!-- STYLE CSS-->

@endsection