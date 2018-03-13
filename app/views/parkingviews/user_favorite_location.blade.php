@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Users <small>view</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Users</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">View</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
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
                            <li class="">
                                <a data-toggle="" href="<?php echo route("view_user", array('id' => $user_id)); ?>">
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
                            <li class="active">
                                <a data-toggle="tab" href="#favorite_parking_tab">
                                    Favorites </a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_search_history", array('id' => $user_id)); ?>">
                                    Search History </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="favorite_parking_tab" class="tab-pane fade active in">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Location Address
                                            </th>
                                            <th>
                                                 City
                                            </th>
                                            <th>
                                                 State
                                            </th>
                                            <th>
                                                 Country
                                            </th>
                                            <th>
                                                Created
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($favorite_locations as $favorits) {
                                            ?>
                                            <tr  class="odd gradeX">
                                                <td>
                                                    <?php echo $favorits['id'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $favorits['location']['name'].'  , '.$favorits['location']['address'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $favorits['location']['city'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $favorits['location']['state'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $favorits['location']['country'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $favorits['created_at'] ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<script>
    $(document).ready(function () {
        var table = $('#sample_1');
        // begin first table
        table.dataTable({
            "columns": [{
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }],
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "pagingType": "bootstrap_full_number",
            "language": {
                "lengthMenu": "_MENU_ records",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{// set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

    });

</script>
@stop