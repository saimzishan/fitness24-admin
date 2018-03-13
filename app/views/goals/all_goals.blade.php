@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Video <small>All Goals List</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Goals</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">All Goals</a>
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
                            <i class="icon-users"></i>All Goals
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>
                      
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Arabic Title
                                    </th>
                                    <th>
                                        English Title
                                    </th>
                                    <th>
                                        Created
                                    </th>                                  
                                    <th>
                                        Updated
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($goals as $goal) {
                                  
                                ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <?php echo $goal->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $goal->title_ar; ?>
                                        </td>
                                        <td>
                                            <?php echo $goal->title_en; ?>
                                        </td>
                                        <td>
                                            <?php echo $goal->created_at; ?>
                                        </td>
                                                                           
                                        <td>
                                            <?php echo $goal->updated_at; ?>
                                          
                                        </td>
                                        <td>
                                             <a style="text-decoration:none;cursor: pointer;" href="<?php echo route("edit_goal", array('id' => $goal->id)); ?>" title="Edit">
                                                <div class="fa fa-edit"></div>
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
    var route_url = '<?php echo route("video_status") ?>';
    $(document).on('click', ".video_status", function () {
        var status = $(this).attr('status');
        var key = $(this).attr('key');
        var msg = $(this).attr('msg');
        var video_id = $(this).attr('id').split(key)[1];
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to ' + msg,
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                video_status_change(status, video_id, key, route_url);
            }
        });
    });
    
</script>
@stop