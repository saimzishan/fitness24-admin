@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Vehicles 
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Vehicles</a>
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
                            <i class="fa fa-globe"></i>Vehicle List
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>
                        <div class="tab-content">
                            <div class="table-toolbar">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th>
                                                Driver Name
                                            </th>
                                            <th>
                                                Vehicle Licence
                                            </th>
                                            <th>
                                                Used Spot ID
                                            </th>
                                            <th>
                                                Status
                                            </th>
<!--                                            <th>
                                                Actions
                                            </th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($vehicles as $vehicle) {
                                            ?>
                                            <tr  class="odd gradeX">
                                                <td>
                                                    <?php echo $vehicle['name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $vehicle['licence'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $vehicle['parking_id'] ?>
                                                </td>
                                                <td>
                                                    &nbsp;&nbsp;&nbsp;
                                                    Waiting for towing
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a style="text-decoration:none" href="javascript:;" class="change_reserve_status" id="<?php echo $vehicle['id']; ?>" title="Change Status">
                                                        Checkout
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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

        $(document).on('click', ".change_reserve_status", function () {
            var id = $(this).attr('id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to check out?',
                confirmButton: 'yes',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn-danger',
                columnClass: 'col-md-4 col-md-offset-4',
                animation: 'zoom',
                confirm: function () {
                    window.location.assign(site_url + "/changeStatus/" + id);
                }
            });
        });

    </script>
    @stop