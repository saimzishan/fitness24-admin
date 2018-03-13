@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Vehicles Types 
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Vehicles</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Vehicle types</a>
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
                            <i class="fa fa-globe"></i>Vehicle Types
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>
                        <div class="table-toolbar">
                            <a style="text-decoration:none" href="<?php echo route("add_make_model"); ?>">
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn green">
                                        Add New Type <i class="fa fa-plus"></i>
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
                                        Make
                                    </th>
                                    <th>
                                        Created
                                    </th>
                                    <th>
                                        Updated
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($make as $vehicle_type) {
                                    if ($vehicle_type['archive'] == 0) {
                                        $make_staus = '<span id="make' . $vehicle_type['id'] . '" make_id="' . $vehicle_type['id'] . '" status="1" class="icon fa fa-rotate-right make_status"></span>';
                                    } else {
                                        $make_staus = '<span id="make' . $vehicle_type['id'] . '" make_id="' . $vehicle_type['id'] . '"  status="0" class="icon fa fa-power-off make_status"></span>';
                                    }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <?php echo $vehicle_type['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $vehicle_type['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $vehicle_type['created_at']; ?>
                                        </td>
                                        <td>
                                            <?php echo $vehicle_type['updated_at']; ?>
                                        </td>
                                        <td>
                                            &nbsp;&nbsp;&nbsp;
                                            <a style="text-decoration:none" href="<?php echo route("view_vehicle_model", array('id' => $vehicle_type['id'])); ?>" title="View Models">
                                                Models
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a style="text-decoration:none" href="<?php echo route("edit_make", array('id' => $vehicle_type['id'])); ?>" title="Edit">
                                                <div class="fa fa-edit"></div>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="text-decoration:none" title="Change Status">
                                                <?php echo $make_staus; ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
    var route_urll = '<?php echo route("make_status") ?>';
    $(document).on('click', ".make_status", function () {
        var status = $(this).attr('status');
        var make_id = $(this).attr('make_id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to change Make status?',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                make_status_change(status, make_id, route_urll);
            }
        });
    });

</script>
@stop