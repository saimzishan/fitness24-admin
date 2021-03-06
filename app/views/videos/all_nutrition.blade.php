@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Video <small>All Nutrition List</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Nutrition</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">All Nutrition</a>
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
                            <i class="icon-users"></i>All Nutrition
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>
                        <div class="table-toolbar">
                            <a style="text-decoration:none" href="<?php echo route("add_nutrition"); ?>">
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn green">
                                        Add New Nutrition <i class="fa fa-plus"></i>
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
                                        Type
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
                                    if ($video->archived == 0) {
                                    
                                ?>
                                    <tr id="video_{{$video->id}}"  class="odd gradeX">
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
                                           <?php echo $video->type; ?>
                                        </td>
                                        <td>
                                        @if($video->type!='text')
                                            <img src="{{CommonHelper::$driver['s3_uploads'] . 'Images/'.$video->thumb}}" width="80"/>
                                        @endif
                                        </td>
                                        <td>
                                            <?php echo $video->full_name; ?>
                                        </td>
                                       
                                        <td video_id="{{$video->id}}">
                                            
                                            &nbsp;&nbsp;&nbsp;
                                            <a style="text-decoration:none;cursor: pointer;" href="<?php echo route("edit_video", array('id' => $video->id, 'nutrition'=>'1')); ?>" title="Edit">
                                                <div class="fa fa-edit"></div>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a class="nutrition_del" data-id="{{$video->id}}" style="text-decoration:none;cursor: pointer;" href="javascript:void(0)" title="Edit">
                                                <div style="color: red;" class="fa fa-trash-o"></div>
                                            </a>
                                  
                                            
                                        </td>
                                    </tr>
                                <?php } }?>
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

    var route_url = '<?php echo route("delete_nutrition") ?>';
    $(document).on('click', ".nutrition_del", function () {
       var id = $(this).attr('data-id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to you want to delete ? ',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
              delete_nutrition(id, route_url);
              setTimeout(function () { location.reload(1); }, 4000);
            }
        });
    });
    
</script>
@stop