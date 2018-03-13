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
                            <li class="active">
                                <a data-toggle="tab" href="#parking_spot_tab">
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
                            <div id="parking_spot_tab" class="tab-pane fade active in">
                                <div class="table-toolbar">
                                    <a style="text-decoration:none" href="<?php echo route("add_parking_spot", array('id' => $user_id)); ?>">
                                        <div class="btn-group">
                                            <button id="sample_editable_1_new" class="btn green">
                                                Add Parking Spot <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <div class="portlet box grey-cascade">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-globe"></i>Active Spots
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                ID
                                                            </th>
                                                            <th>
                                                                Spot Address
                                                            </th>
                                                            <th>
                                                                Spot Description
                                                            </th>
                                                            <th>
                                                                Actions
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($active_spots as $spots) {
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td>
                                                                    <?php echo $spots['id'] ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $spots['address'] ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $spots['description'] ?>
                                                                </td>
                                                                <td>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a style="text-decoration:none" href="<?php echo route("single_parking_spot", array('user_id' => $user_id, 'spot_id' => $spots['id'])); ?>" title="View">
                                                                        view
                                                                    </a> 
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="portlet box grey-cascade">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-globe"></i>Inactive Spots
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <table class="table table-striped table-bordered table-hover" id="sample_2">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                ID
                                                            </th>
                                                            <th>
                                                                Spot Address
                                                            </th>
                                                            <th>
                                                                Spot Description
                                                            </th>
                                                            <th>
                                                                Actions
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($inactive_spots as $spots) {
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td>
                                                                    <?php echo $spots['id'] ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $spots['address'] ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $spots['description'] ?>
                                                                </td>
                                                                <td>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a style="text-decoration:none" href="<?php echo route("single_parking_spot", array('user_id' => $user_id, 'spot_id' => $spots['id'])); ?>" title="View">
                                                                        view
                                                                    </a> 
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet box grey-cascade" style="border-color: #fff !important;"></div>
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
        var table2 = $('#sample_2');
        // begin first table
        table.dataTable({
            "columns": [{
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": false
                }],
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 8,
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
        // begin 2nd table
        table2.dataTable({
            "columns": [{
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": false
                }],
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 8,
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