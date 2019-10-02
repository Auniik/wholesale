<?
$info = \App\Models\PrimaryInfo::first();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Smart Hospital ERP</title>
    <meta content="Admin Dashboard" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Themesbrand" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App Icons -->
    <link rel="shortcut icon" href="">
    <!-- App css -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/plugin/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <style>
        .bg-thumbnail{
            {{--background-image: url({{asset('/images/bg.jpg')}});--}}
            background-image: linear-gradient( rgba(90, 90, 90, 0.37), rgba(0, 0, 0, 0.3) ), url({{asset('/images/bg.jpg')}});
            background-size: cover;
            background-position:center top;
        }
        .footer{
            background: #2d2d2d94;

        }
    </style>
    <link href="{{asset('backend/css/custom.css')}}" rel="stylesheet" type="text/css" />

</head>


<body class="bg-thumbnail">

<!-- Loader -->
<div id="preloader"><div id="status"><div class="spinner"></div></div></div>

<!-- Begin page -->
<div class="accountbg"></div>
<div class="container">
    <div class="col-md-12">
        <br>
        <br>
        <br>
    </div>
    <div class="col-md-8">
        <div class="login-information">
{{--            <h2>{{optional($info)->company_name}} </h2>--}}
            <div>
{{--                {{ optional($info)->description }}--}}
            </div>
        </div>
    </div>
    <div class="col-md-4 pull-right">

        <div class="well login-box">
            <div class="card-body">

                <h3 class="text-center m-0">
                    <a href="{{URL::to('/')}}" class="logo logo-admin"><img src="{{asset('images/smarterplogo.gif')}}" alt="logo"></a>
                    {{--<div><i class="fa fa-plus" style="font-size: 150px; color: #dfdfdf;" aria-hidden="true"></i></div>--}}

                </h3>

                <div class="p-3">

                    <form method="POST" action="{{ route('login') }}" class="form-horizontals">
                        @csrf

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">

                            <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">

                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="custom-control custom-checkbox">
                                    {{--<input class="custom-control-input form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
                                    <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    {{--<label class="custom-control-label" for="remember" style="color: rgba(0,0,0,0.8);">Remember me</label>--}}
                                    <label class="" for="remember" style="color: rgba(0,0,0,0.8);">Remember me</label>
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>

                        <div class="form-group m-t-10 mb-0 row">
                            <div class="col-12 m-t-20">
                                <a class="btn btn-link" style="color: #006bca;" href="{{ route('password.request') }}">
                                    {{--{{ __('Forgot Your Password?') }}--}}
                                </a>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center " style="color:white">
                   Powered <i class="mdi mdi-heart text-danger"></i> by <a href="http://smartsoftware.com.bd" style="color:#8ad4ff;" target="_blank" alt="Smart Software LTD."> Smart Software LTD. </a>
                </div>
            </div>
        </div>
    </footer>



<!-- App js -->
<script src="{{asset('js/app.js')}}"></script>

</body>
</html>