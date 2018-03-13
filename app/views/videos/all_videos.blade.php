@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Video <small>All Videos List</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Videos</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">All Videos</a>
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
                            <i class="icon-users"></i>All Videos
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                    ?>
                        <div class="table-toolbar">
                            <a style="text-decoration:none" href="<?php echo route("add_video"); ?>">
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn green">
                                        Add New Video <i class="fa fa-plus"></i>
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
                                        Arabic Title
                                    </th>
                                    <th>
                                        English Title
                                    </th>
                                     <th>
                                        Category
                                    </th>
                                    <th>
                                        Thumb
                                    </th>
                                    <th>
                                        Created By
                                    </th>
                                   
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($videos as $video) {
                                    //print_r(CommonHelper::$driver['s3_uploads'] . 'images/'.$video->thumb);exit;
                                    if ($video->archived == 0 || $video->archived == 1) {
                                        $staus = '<span status="0" key="archived" id="archived'.$video->id .'" msg="Delete" class="fa fa-trash-o video_status" style="color: red"></span>';
                                    } 
                                    
                                    $featured = ($video->is_featured == 1) 
                                            ? '<span status="0" key="is_featured" id="is_featured'.$video->id .'" msg="Mark Un Featured" class=" video_status">UnFeatured</span>'
                                            : '<span status="1" key="is_featured" id="is_featured'.$video->id .'" msg="Mark Featured" class=" video_status">MakeFeatured</span>' ;
                                    
                                    $free = ($video->is_free == 1) 
                                            ? '<span status="0" key="is_free" id="is_free'.$video->id .'" msg="Make Paid" class=" video_status">MakePaid</span>'
                                            : '<span status="1" key="is_free" id="is_free'.$video->id .'" msg="Make Free" class=" video_status">MakeFree</span>' ;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <?php echo $video->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $video->title_ar; ?>
                                        </td>
                                        <td>
                                            <?php echo $video->title_en; ?>
                                        </td>
                                        <td>
                                            {{$video->categories->title_ar}} / {{$video->categories->title_en}}
                                        </td>
                                        <td>
                                            <img src="{{CommonHelper::$driver['s3_uploads'] . 'Images/'.$video->thumb}}" width="80"/>
                                        </td>
                                        <td>
                                            <?php echo $video->full_name; ?>
                                        </td>
                                       
                                        <td id="video_{{$video->id}}" video_id="{{$video->id}}">
                                            
                                            &nbsp;&nbsp;&nbsp;
                                            <a style="text-decoration:none;cursor: pointer;" href="<?php echo route("edit_video", array('id' => $video->id)); ?>" title="Edit">
                                                <div class="fa fa-edit"></div>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="text-decoration:none;cursor: pointer;" title="Change Status">
                                                <?php echo $staus; ?>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="text-decoration:none;cursor: pointer;" title="Change Status">
                                                 {{$free}}
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="text-decoration:none;cursor: pointer;" title="Change Status">
                                                {{$featured}}
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
                setTimeout(function () { location.reload(1); }, 4000);
            }
        });
    });
    
</script>
@stop