@extends('common_templates.basic_template')
@section('content')
<style>
.green-madison
{
    background-color:green !important;
}
.black-madison
{
    background-color:black !important;
}
.yellow-madison
{
    background-color:red !important;
}
.grey-madison
{
    background-color:grey !important;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <?php
                
                if (Session::has('message')) {
                    echo CommonHelper::generateHtmlAlert(Session::get('message'));
                }
                ?>
                <h3 class="page-title">
                    Dashboard 
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="javascript:;" style="text-decoration: none;">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Dashboard</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS -->
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                           <?php echo $dashboard['users']; ?> 
                        </div>
                        <div class="desc">
                            Total Users
                        </div>
                    </div>
                    <a class="more" href="<?php echo route("all_user"); ?>" style="text-decoration: none;">
                        View <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
                
                
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison green-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                           <?php echo $videos['user_videos']; ?> 
                        </div>
                        <div class="desc">
                            Total Videos
                        </div>
                    </div>
                    <a class="more green-madison" href="<?php echo route("all_videos"); ?>" style="text-decoration: none;">
                        View <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
                
                
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison yellow-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                           <?php echo $nutrition_videos['user_nutrition_videos']; ?> 
                        </div>
                        <div class="desc">
                            Total Nutrition Videos
                        </div>
                    </div>
                    <a class="more yellow-madison" href="<?php echo route("all_nutrition"); ?>" style="text-decoration: none;">
                        View <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
                
                
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison black-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                           <?php echo $expireUsers; ?> 
                        </div>
                        <div class="desc">
                            Total Expire Users
                        </div>
                    </div>
                    <a class="more black-madison" href="<?php echo route("all_user"); ?>" style="text-decoration: none;">
                        View <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
                
                
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison grey-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                           <?php echo $premimum; ?> 
                        </div>
                        <div class="desc">
                            Total Premimum Users
                        </div>
                    </div>
                    <a class="more grey-madison" href="<?php echo route("all_user"); ?>" style="text-decoration: none;">
                        View <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
                
                
            </div>
        </div>
        <!-- END DASHBOARD STATS -->
    </div>
</div>
@stop

