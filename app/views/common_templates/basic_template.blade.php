<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Fitness24 Admin Panel</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        @include('common_templates.css_template')
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-quick-sidebar-over-content">
        <!-- BEGIN HEADER -->
        @include('common_templates.header')
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            @include('common_templates.sidebar_template')
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            @yield('content')
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <!--@include('common_templates.quick_sidebar_template')-->
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner">
                2017 &copy; Fitness24 Admin Panel.
            </div>
        </div>
        <!-- END FOOTER -->
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        @include('common_templates.scripts_template')
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>