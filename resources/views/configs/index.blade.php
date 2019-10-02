@extends('layout.app')
@section('content')
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">System Configs </h4>
                    </div>
                    <div class="panel-body">
                        <form action="/system-configs/store" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center">Outdoor Settings</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="outdoor-discount" name="outdoor_discount"
                                                           data-toggle="toggle" value="1" {{$config->outdoor_discount ?
                                                           'checked': ''}}
                                                           data-size="mini" data-onstyle="success">
                                                    Outdoor Discount
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="outdoor-sms" name="outdoor_sms"
                                                           data-toggle="toggle" value="1" {{$config->outdoor_sms ?
                                                           'checked':''}}
                                                           data-size="mini" data-onstyle="success">
                                                    Outdoor SMS
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{--<div class="form-group">--}}
                                            {{--<input type="checkbox" checked data-toggle="toggle">--}}
                                            {{--<label for="Outdoor">Outdoor Discount</label>--}}
                                            {{--</div>--}}
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-4"><br><br>
                                    <input type="submit" class="btn btn-success col-md-12">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
