@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Vehicle Types <small>Edit type</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Vehicle types</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Edit vehicle type</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>
                            Edit Vehicle Type
                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{Form::open(array('route' => 'update_make_type', 'name'=>'post_make_model', 'enctype'=>'multipart/form-data'))}}
                        <?php echo Form::model($make, array('route' => array('update_make_type', $make['id']))); ?>
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Edit Make</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('name',Input::old("name"),array('id'=>'name','class'=>'form-control','placeholder'=>'example ...(toyota, Honda)','required')) }}
                                        </div>
                                        <input type="hidden" name="id"  value="<?php echo $make['id']; ?>">
                                    </div>
<!--                                    <div data-provides="fileinput" class="fileinput fileinput-new">
                                        <div style="width: 150px; height: 150px; line-height: 150px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
                                            <img style="width: 150px; height: 150px;" src="<?php // echo CommonHelper::$driver['s3_uploads'] . 'vehicles_make/' .$make['photos']['image']; ?>" alt=""/>
                                        </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new">
                                                    Change image </span>
                                                <span class="fileinput-exists">
                                                    Change </span>
                                                <input type="file" name="image">
                                            </span>
                                            <a data-dismiss="fileinput" class="btn red fileinput-exists" href="#">
                                                Remove </a>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Update">
    <!--                            <a href="<?php // echo route("home");         ?>" class="btn default">
                                    Cancel </a>-->
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<div class="clearfix">
</div>
@stop