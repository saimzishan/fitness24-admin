@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content"
         <!-- BEGIN PAGE HEADER-->
         <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Users <small>View</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo route("all_user"); ?>">Users</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;">View</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-users"></i>User Details
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#profile_tab">
                                    Profile </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_vehicles", array('id' => $user_id)); ?>">
                                    Vehicles </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_parking_spots", array('id' => $user_id)); ?>">
                                    Parking Spots </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_credit_cards", array('id' => $user_id)); ?>">
                                    Credit Cards </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("merchant_payments", array('id' => $user_id)); ?>">
                                    Merchant Payments </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_parking_history", array('id' => $user_id)); ?>">
                                    Parking History </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_favorite_location", array('id' => $user_id)); ?>">
                                    Favorites </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_search_history", array('id' => $user_id)); ?>">
                                    Search History </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="profile_tab" class="tab-pane fade active in">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                Picture
                                            </th>
                                            <th>
                                                First Name
                                            </th>
                                            <th>
                                                Last Name
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Phone Number
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($user->archive == 0) {
                                            $staus = '<span id="user' . $user->id . '" user_id="' . $user->id . '" status="1" class="icon fa fa-rotate-right user_status"></span>';
                                        } else {
                                            $staus = '<span id="user' . $user->id . '" user_id="' . $user->id . '"  status="0" class="icon fa fa-power-off user_status"></span>';
                                        }
                                        ?>
                                        <tr  class="odd gradeX">
                                            <td>
                                                <img style="width: 50px; height: 50px;" src="<?php echo CommonHelper::$driver['s3_uploads'] . 'users/user_' . $user->id . '/' . $user->profile_image; ?>" alt=""/>
                                            </td>
                                            <td>
                                                <?php echo $user->first_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $user->last_name; ?>
                                            </td>
                                            <td>
                                                <a href="javascript:;" style="text-decoration:none">
                                                    <?php echo $user->email; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $user->phone_number; ?>
                                            </td>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;
                                                <a style="text-decoration:none" href="<?php echo route("edit_user", array('id' => $user->id)); ?>" title="Edit">
                                                    <div class="fa fa-edit"></div>
                                                </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="text-decoration:none" title="Change Status">
                                                    <?php echo $staus; ?>
                                                </a> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<div class="clearfix">
</div>
<script>
    var route_url = '<?php echo route("user_status") ?>';
    $(document).on('click', ".user_status", function () {
        var status = $(this).attr('status');
        var user_id = $(this).attr('user_id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to change user status?',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                user_status_change(status, user_id, route_url);
            }
        });
    });
</script>
@stop