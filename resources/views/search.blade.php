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
    </div>
    <!-- END HEADER -->
    <!-- END PAGE HEADER WRAPPER -->
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper">
        <div class="content">
            <!-- START CONTAINER FLUID -->
            <div class="container-fluid container-fixed-lg">
                <div class="row p-t-20">
                    <div class="input-group col-sm-4">
                        <input id="searchKey" type="search" class="form-control input-lg" placeholder="Keyword" onKeyUp="doSearch(this.value)">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                    <div id="searchbox" class="col-sm-4" style="background: #FFF; line-height: 1.5em; padding: 10px; display: none; max-height: 500px; overflow: auto;"></div>
                </div>
                <!-- END PLACE PAGE CONTENT HERE -->
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
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


<script>
    var xhr = false;
    var search = false;

    function doSearch(val) {
        if (xhr)
            xhr.abort();

        if (val.length >= 2) {
            xhr = $.ajax({
                url: '{{ url('/search') }}',
                type: 'get',
                data: {	keyword:val, project:1},
                success: function(response) {
                    $('#searchbox').html(response);
                    if (!search) {
                        $("#searchbox").show();
                        search = true;
                    }
                }
            });
        }

        if (val.length < 2) {
            $("#searchbox").hide();
            search = false;
        }
    }
</script>
</body>
</html>
