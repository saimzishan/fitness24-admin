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
                            <li class="active">
                                <a data-toggle="tab" href="#vehicle_tab">
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
                                    Favorites</a>
                            </li>
                            <li class="">
                                <a data-toggle="" href="<?php echo route("user_search_history", array('id' => $user_id)); ?>">
                                    Search History </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="vehicle_tab" class="tab-pane fade active in">
                                <div class="table-toolbar">
                                    <a style="text-decoration:none" href="<?php echo route("add_vehicle", array('id' => $user_id)); ?>">
                                        <div class="btn-group">
                                            <button id="sample_editable_1_new" class="btn green">
                                                Add New Vehicle <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </a>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                Licence Plate
                                            </th>
                                            <th>
                                                Make
                                            </th>
                                            <th>
                                                Model
                                            </th>
                                            <th>
                                                Year
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($vehicles as $vehicle) {
                                            if ($vehicle['archive'] == 0) {
                                                $vehicle_staus = '<span id="vehicle' . $vehicle['id'] . '" vehicle_id="' . $vehicle['id'] . '" status="1" class="icon fa fa-rotate-right vehicle_status"></span>';
                                            } else {
                                                $vehicle_staus = '<span id="vehicle' . $vehicle['id'] . '" vehicle_id="' . $vehicle['id'] . '"  status="0" class="icon fa fa-power-off vehicle_status"></span>';
                                            }
                                            ?>
                                            <tr  class="odd gradeX">
                                                <td>
                                                    <?php echo $vehicle['id'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $vehicle['licence'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $vehicle['make'] ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($vehicle['model'])) {
                                                        $model_gen = explode("=", $vehicle['model']);
                                                        echo $model_gen[0] . ' ' . $model_gen[1];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $vehicle['year'] ?>
                                                </td>
                                                <td>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a style="text-decoration:none" href="<?php echo route("edit_vehicle", array('user_id' => $user_id, 'vehicle_id' => $vehicle['id'])); ?>" title="Edit">
                                                        <div class="fa fa-edit"></div>
                                                    </a> 
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="javascript:void(0)" style="text-decoration:none" title="Change Status">
                                                        <?php echo $vehicle_staus; ?>
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
                    "orderable": false
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
    var vehicle_url = '<?php echo route("vehicle_status") ?>';
    $(document).on('click', ".vehicle_status", function () {
        var status = $(this).attr('status');
        var vehicle_id = $(this).attr('vehicle_id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to change vehicle status?',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                vehicle_change_status(status, vehicle_id, vehicle_url);
            }
        });
    });

</script>
@stop