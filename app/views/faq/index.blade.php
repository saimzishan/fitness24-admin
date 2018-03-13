@extends('common_templates.basic_template')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Faq <small>All Faq List</small>
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">

                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo route("home"); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="" style="text-decoration:none">FAQ</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="" style="text-decoration:none">All Faq</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey-cascade">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-users"></i>All FAQ
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="table-toolbar">
                                <a style="text-decoration:none" href="<?php echo route("newFaq"); ?>">
                                    <div class="btn-group">
                                        <button id="sample_editable_1_new" class="btn green">
                                            Add New FAQ <i class="fa fa-plus"></i>
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
                                            catID
                                        </th>
                                        <th>
                                            Question
                                        </th>

                                        <th>
                                            Answer
                                        </th>
                                        <th>
                                            Arabic Question
                                        </th>

                                        <th>
                                            Arabic Answer
                                        </th>
                                        <th>
                                            like_count
                                        </th>
                                        <th>
                                            dislike_count
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($faq as $codes) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <?php echo $codes['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['catID']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['Question']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['Answer']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['arabicQuestion']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['arabicAnswer']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['like_count']; ?>
                                        </td>
                                        <td >
                                            <?php echo $codes['dislike_count']; ?>
                                        </td>
                                        <td>
                                            <?php echo $codes['Status']; ?>
                                        </td>
                                        <td>
                                            <a style="text-decoration:none" href="<?php echo route("newFaq", array('id' => $codes['id'])); ?>" title="Edit">
                                                <div class="fa fa-edit"></div>
                                            </a>


                                            <a style="text-decoration:none; color: #ff0000" href="<?php echo route("deleteFaq", array('id' => $codes['id'])); ?>" title="Delete">
                                                <div class="fa fa-trash-o"></div>
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