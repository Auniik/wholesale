<!DOCTYPE html>
<html lang="en-US">
@php($baseUrl = url('/'))
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <meta name="Googlebot" content="all" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Cache-Control" content="no-cache"> <!-- tells browser not to cache -->
    <meta http-equiv="Expires" content="0"> <!-- says that the cache expires 'now' -->
    <meta http-equiv="Pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->

    <meta name="csrf-param" content="_csrf">
    <title>@yield('title') | Smart Hospital ERP</title>
    <link rel="shortcut icon" href="{{asset('images/logo/favicon.png')}}" sizes="16x16">
    <meta http-equiv="refresh" content="1801">
{{--    <link rel="stylesheet" href="{{asset('css/app.css')}}">--}}
    <link href="{{asset('sc_theme/css/bootstrap.min.css')}}" rel="stylesheet">
    {{--<link href="{{asset('ui/jquery-ui.css')}}" rel="stylesheet">--}}
    <link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    {{--<link href="{{asset('sc_theme/css/site.css')}}" rel="stylesheet">--}}
    <link href="{{asset('sc_theme/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/animate.css')}}" rel="stylesheet">
    {{--<link href="{{asset('sc_theme/css/dropzone.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('sc_theme/css/grutier.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('sc_theme/css/bootstrap-tour.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('sc_theme/css/select2.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/reset.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/layout.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/components.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/plugins.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/default.theme.css')}}" rel="stylesheet">
    {{--<link href="{{asset('sc_theme/css/sign.css')}}" rel="stylesheet">--}}
    <link href="{{asset('sc_theme/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('sc_theme/css/bootstarp.toggle.css')}}" rel="stylesheet">
{{--    <link href="{{asset('sc_theme/css/fullcalender.css')}}" rel="stylesheet">--}}
    <script src="{{asset('sc_theme/js/moment.min.js')}}"></script>
{{--    <script src="{{asset('sc_theme/js/jquery.min.js')}}"></script>--}}

    <link href="{{asset('backend/trumbowyg/ui/trumbowyg.css')}}" rel="stylesheet">
    <link href="{{asset('backend/trumbowyg/plugins/table/ui/trumbowyg.table.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
{{--    <link href="{{asset('backend/plugin/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">--}}
    <link href="{{asset('backend/css/chosen.css')}}" rel="stylesheet">
{{--    <link href="{{asset('backend/plugin/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet" />--}}
    <!-- Custom Fonts -->
    {{--<link href="https://unpkg.com/ionicons@4.4.4/dist/css/ionicons.min.css" rel="stylesheet">--}}
    <link href="{{asset('backend/css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @stack('style')
</head>

<body class="page-session page-header-fixed page-sidebar-fixed demo-dashboard-session">

<section id="wrapper">
    <div id="header">
        <div class="header-left" style="background:#00B1E1">
            <div class="navbar-minimize-mobile left" style="background:#00B1E1">
                <i class="fa fa-bars"></i>
            </div>
            <div class="navbar-header" style="background:#00B1E1">
                <a class="navbar-brand text-bold" href="{{url('/')}}" title="Hospital ERP">Hospital ERP</a> </div>
        </div>
        <div class="header-right">
            <div class="navbar navbar-toolbar navbar-primary">
                <ul class="nav navbar-nav navbar-left">
                    <li id="tour-2" class="navbar-minimize">
                        <a href="javascript:void(0);" title="Minimize sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-search">
                        <form id="tour-3" class="navbar-form">
                            <div class="form-group has-feedback">
                                <h4 style=" padding-top: 10px; margin: 0px; color: #fff;">{{ optional(auth()->user()->companyInfo)->company_name }}</h4>
                            </div>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Start notification part -->
                    <li id="tour-5" class="dropdown navbar-notification">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="count label label-danger rounded">1</span></a>
                        <div class="dropdown-menu animated flipInX">
                            <div class="dropdown-header">
                                <span class="title">Notifications <strong>(1)</strong></span>
                            </div>
                            <div class="dropdown-body niceScroll" style="overflow: hidden;" tabindex="6">
                                <div class="media-list small">
                                    <a href="/backend/web/accesscontrol/reloadpermission" class="media">
                                        <div class="media-object pull-left"><i class="fa fa-share-alt fg-info"></i></div>
                                        <div class="media-body">
                                                <span class="media-text">
                                            <strong>New Features : </strong> New features available, please click to reload features.
                                        </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div id="ascrail2006" class="nicescroll-rails" style="width: 5px; z-index: 1000; cursor: default; position: absolute; top: 0px; left: -10px; height: 281px; display: none;">
                                <div style="position: relative; top: 0px; float: right; width: 10px; height: 0px; background-color: rgb(66, 66, 255); border: 0px none; background-clip: padding-box; border-radius: 5px;"></div>
                            </div>
                            <div id="ascrail2006-hr" class="nicescroll-rails" style="height: 10px; z-index: 1000; top: 271px; left: 0px; position: absolute; cursor: default; display: none;">
                                <div style="position: absolute; top: 0px; height: 10px; width: 0px; background-color: rgb(66, 66, 66); border: 0px none; background-clip: padding-box; border-radius: 5px;"></div>
                            </div>
                        </div>
                    </li>
                    <!-- Ends notification part -->

                    <!-- Start reload refresh -->
                    <li id="refreshButton" style="margin-right: 5px;">
                        <a href="/backend/web/accesscontrol/reloadpermission" title="Reload Permission" style="color:#fff;"><i class="fa fa-refresh"></i></a> </li>
                    <!-- Ends reload refresh -->

                    <!-- Start profile -->
                    <li id="tour-6" class="dropdown navbar-profile">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="meta">
                            <span class="avatar"><img src="{{asset('images/dr.png')}}" class="img-circle" alt="admin"></span>
                                <span class="text hidden-xs hidden-sm text-muted"></span>
                                <span class="caret"></span>
                                </span>
                        </a>
                        <!-- Start dropdown menu -->
                        <ul class="dropdown-menu animated flipInX">
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
                </ul>
            </div>
        </div>
    </div>


    <aside id="sidebar-left" class="sidebar-circle sidebar-light">
        {{--block--}}
        <div id="tour-8" class="sidebar-content">
            <div class="media">
                <a class="pull-left has-notif avatar" href="javascript:void(0);">
                    <img src="{{asset('images/dr.png')}}" alt="admin">
                </a>
                <div class="media-body">
                    {{--@dd(auth()->user()->employees)--}}
                    <h4 class="media-heading">{{auth()->user()->name}}<span></span></h4>
                    @if(!auth()->user()->employees)
                        <small>{{auth()->user()->role->name}}</small>
                    @else
                        <small>{{auth()->user()->employees->designation->name}}</small>
                    @endif
                </div>
            </div>
        </div>
        {{--blockend--}}
        <div id="innerDiv">
            <div class="page-wrapper">
                @include('_partials.sidebar')
            </div>
        </div>
    </aside>
    <section id="page-content" style="min-height: 832px;">

        <div class="body-content animated fadeIn bg-thumbnail" >
            <div class="col-md-8 col-md-offset-3" id="success-text">
                @if(session()->has('success'))
                    <div class="col-md-12 no-padding" id="">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{session()->get("success")}}
                        </div>
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="col-md-12 no-padding" id="success-text">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{session()->get("error")}}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible " role="alert">
                        <ol>
                            @foreach ($errors->all() as $error) <li class="">{{ $error }}</li> @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </ol>
                    </div>
                @endif
            </div>

            <div class="col-md-8 col-md-offset-3">
                @if (!defaultAccount())
                    <div class="alert alert-warning" role="alert">
                        <strong>Warning!</strong> You have to set a default account for transaction.
                        <a href="{{url('/accounts')}}">here</a>
                    </div>
                @endif
            </div>

            @yield('content')
        </div>

        <input type="hidden" value="{{url('/')}}" id="rootUrl">

        <footer class="footer-content">
                <span id="tour-19">
                Version : 1.0.1, Powered by : <a href="http://www.smartsoftware.com.bd" target="_blank">Smart Software LTD.</a>
            </span>
        </footer>
    </section>
</section>

<div id="back-top" class="animated pulse circle no-print">
    <i class="fa fa-angle-up"></i>
</div>

<div class="preloader no-print">
    <div class="preloader-container">
        <span class="animated-preloader"></span>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery-1.10.2.js')}}"></script>
{{--<script src="{{asset('sc_theme/js/jquery.min.js')}}"></script>--}}

{{--<script src="{{asset('backend/plugin/bootstrap/js/bootstrap.min.js')}}"></script>--}}
<script src="{{asset('sc_theme/js/bootstrap.min.js')}}"></script>
{{--<script src="{{asset('ui/jquery-ui.js')}}"></script>--}}
<script src="{{asset('js/jquery.form-repeater.js')}}"></script>

@yield('script')
@stack('js-script')
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('sc_theme/js/jquery.cookie.js')}}"></script>
<!-- Bootstrap Core JavaScript -->


{{--<script src="{{asset('sc_theme/js/typeahead.bundle.min.js')}}"></script>--}}

<script src="{{asset('sc_theme/js/jquery.nicescroll.min.js')}}"></script>
{{--<script src="{{asset('sc_theme/js/jquery.easing.1.3.min.js')}}"></script>--}}
<script src="{{asset('sc_theme/js/jquery.waypoints.min.js')}}"></script>
{{--<script src="{{asset('sc_theme/js/bootstrap-tour.min.js')}}"></script>--}}
<script src="{{asset('sc_theme/js/select2.js')}}"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('backend/plugin/metisMenu/metisMenu.min.js')}}"></script>
<script src="{{asset('plugins/switcher/jquery.switcher.js')}}"></script>
<!-- DataTables JavaScript -->
{{--<script src="{{asset('backend/plugin/datatables/js/jquery.dataTables.min.js')}}"></script>--}}
{{--<script src="{{asset('backend/plugin/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset('backend/plugin/datatables-responsive/dataTables.responsive.js')}}"></script>--}}
<script src="{{asset('backend/js/chosen.jquery.js')}}"></script>
<script src="{{asset('backend/plugin/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{asset('sc_theme/js/apps.js')}}"></script>
{{--<script src="{{asset('sc_theme/js/blankon.form.element.js')}}"></script>--}}
{{--<script src="{{asset('sc_theme/js/demo.js')}}"></script>--}}
<script src="{{asset('sc_theme/js/bootstrap-toggle.js')}}"></script>
<script src="{{asset('sc_theme/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('sc_theme/js/fullcalendar.js')}}"></script>

<script>
    $(document).ready(function() {
        // current url processing
        var path = decodeURIComponent(window.location.pathname.replace(/\/$/, ""));
        var pathArr, urlArr = [];
        pathArr = path.split('/');
        var pathMatch = pathArr[1] + '/' + pathArr[2] + '/' + pathArr[3]; // live
        // var pathMatch = pathArr[1]+'/'+pathArr[2]+'/'+pathArr[3]+'/'+pathArr[4]; // local

        jQuery('.sidebar-menu ul li a').each(function() {
            var url = window.location.href.split('?')[0];
            if (url === this.href) {
                $(this).parents('li.submenu').addClass('active open');
                $(this).parents('li').addClass('active');
            }
        });
        // select2
        $(".select").select2();
    });
</script>

<!-- Custom Theme JavaScript -->
{{--<script src="{{asset('backend/js/sb-admin-2.js')}}"></script>--}}
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('backend/js/custom.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>--}}
<script src="{{asset('sc_theme/js/moment.min.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>--}}
<script>
    $('[data-selected-value]').each(function (i, item) {
        item = $(item);
        item.val(
            item.data('selected-value')
        )
    });
    $(document).on('focus', '.datepicker', function(){
        $('.datepicker').datepicker({
            dateFormat: "dd-mm-yy",
            autoHide: true,
            changeMonth: true,
            changeYear: true
        });
    })

    function confirmDelete(){
        return confirm("Do You Sure Want To Delete This Data ?");
    }


</script>
 {{--success or error message hiding process--}}
<script type="text/javascript">
    $(document).ready( function() {
        $('#success-text').delay(2000).fadeOut();
    });

    if(!!window.performance && window.performance.navigation.type === 2)
    {
        window.location.reload();
    }
</script>

@if(session()->has('error'))
    <script type="text/javascript">
        swal({
            type: 'error',
            title: '{{session()->get("error")}}',
            showConfirmButton: true
        })
    </script>
@endif

<script type="text/javascript">
    function deleteConfirm(id){
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $("#"+id).submit();
            }
        })
    }
</script>

</body>

</html>
