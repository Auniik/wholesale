<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hospital Erp</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('public/backend/plugin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/ui/jquery-ui.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('public/backend/plugin/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('public/backend/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/sweetalert2.min.css')}}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="{{asset('public/backend/plugin/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{asset('public/backend/plugin/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/css/chosen.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/plugin/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <!-- Morris Charts CSS -->
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('public/backend/plugin/tagbox/css/jquery.tagit.css')}}">

    <!-- Custom Fonts -->
    <link href="{{asset('public/backend/plugin/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/css/custom.css')}}" rel="stylesheet">

    <style type="text/css">
        .modal .modal-dialog .modal-content {
            border: 1px solid #DDD;
            margin-left: 200px !important;
        }
    </style>


</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Hospital Erp</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right" >
            <!-- /.dropdown -->
            <span id="loadSubmenuHere">
                @include('_partials.subMenu')
            </span>



            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                    <i class="fa fa-user fa-fw"></i> <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li> <a href="{{URL::to('profile')}}"> <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} </a> </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

