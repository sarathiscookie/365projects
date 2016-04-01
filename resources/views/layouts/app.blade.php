<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>PR365 - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="/pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/pages/ico/152.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN Vendor CSS-->
    <link href="/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <!-- BEGIN Pages CSS-->
    <link href="/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="/pages/css/pages.css" rel="stylesheet" type="text/css" />
    <!--[if lte IE 9]>
    <link href="/pages/css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript">
        window.onload = function()
        {
            // fix for windows 8
            if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="/pages/css/windows.chrome.fix.css" />'
        }
    </script>
</head>
<body class="fixed-header">
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
        <!-- START PAGE HEADER WRAPPER -->
        <!-- START HEADER -->
        <div class="header ">
            <div class=" pull-left sm-table">
                <div class="header-inner">
                    <div class="brand inline">
                        <img src="/assets/img/logo.png" alt="logo" data-src="/assets/img/logo.png" data-src-retina="/assets/img/logo_2x.png" width="78" height="22">
                    </div>
                </div>
            </div>
            <div class=" pull-right">
                <!-- START User Info-->
                @if (Auth::check())
                <div class="visible-lg visible-md m-t-10">
                    <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
                        <span class="semi-bold">{!! Auth::user()->name !!}</span> <span class="text-master"></span>
                    </div>
                    <div class="dropdown pull-right">
                        <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <img src="/assets/img/profiles/avatar.jpg" alt="" data-src="/assets/img/profiles/avatar.jpg" data-src-retina="/assets/img/profiles/avatar_small2x.jpg" width="32" height="32">
            </span>
                        </button>
                        <ul class="dropdown-menu profile-dropdown" role="menu">
                            <li><a href="#"><i class="pg-settings_small"></i> Settings</a>
                            </li>
                            <li class="bg-master-lighter">
                                <a href="{{ url('/logout') }}" class="clearfix">
                                    <span class="pull-left">Logout</span>
                                    <span class="pull-right"><i class="pg-power"></i></span>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
                @else
                    <div class="header-inner">
                        <ul class="menu list-inline">
                            <!-- Authentication Links -->
                            <li><a href="/"><i class="fs-14 pg-home"></i></a></li>
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        </ul>
                    </div>
                    @endif
                <!-- END User Info-->
            </div>
        </div>
        <!-- END HEADER -->
        <!-- END PAGE HEADER WRAPPER -->
        <!-- START PAGE CONTENT WRAPPER -->
        <div class="page-content-wrapper">

            <!-- START PAGE CONTENT -->
            @yield('content')
            <!-- END PAGE CONTENT -->

            <!-- START FOOTER -->
            <div class="container-fluid container-fixed-lg footer">
                <div class="copyright sm-text-center">
                  <p class="small no-margin sm-pull-reset text-center">
                    <span class="hint-text">Copyright © 2016</span>
                    <span class="font-montserrat">PR365</span>.
                    <span class="hint-text">All rights reserved.</span>
                        {{--<span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                                  </span>--}}
                  </p>
                  <div class="clearfix"></div>
                </div>
            </div>
        <!-- END FOOTER -->
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->



    <!-- BEGIN VENDOR JS -->
    <script src="/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-bez/jquery.bez.min.js"></script>
    <script src="/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="/pages/js/pages.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="/assets/js/scripts.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
</body>
</html>