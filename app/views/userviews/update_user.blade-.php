@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Users <small>Update user</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Users</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Edit user</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row profile">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-users"></i>Edit User
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'update_user', 'name'=>'user_updation', 'enctype'=>'multipart/form-data'))}}
                        <?php echo Form::model($user, array('route' => array('update_user', $user->id))); ?>
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('full_name',Input::old("full_name"),array('id'=>'full_name','class'=>'form-control','placeholder'=>'Full Name','required')) }}
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::email('email',Input::old("email"),array('id'=>'email','class'=>'form-control','placeholder'=>'Email Address','required', 'readonly')) }}
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group" style="width: 80%">
                                            <input class="form-control" type="password" autocomplete="off" placeholder="Password" name="password" />
                                        </div>
                                    </div>
                                    <div data-provides="fileinput" class="fileinput fileinput-new" id="old_image">
                                        <div style="width: 180px; height: 170px; line-height: 150px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
                                            <img style="width: 180px; height: 160px;" src="<?php echo CommonHelper::$driver['s3_uploads'] . 'users/'. $user->profile_image; ?>" alt=""/>
                                        </div>
                                        <!--                                        <div>
                                                                                    <span class="btn default btn-file">
                                                                                        <span class="fileinput-new">
                                                                                            Change image </span>
                                                                                        <span class="fileinput-exists">
                                                                                            Change </span>
                                                                                        <input type="file" name="profile_image">
                                                                                    </span>
                                                                                    <a data-dismiss="fileinput" class="btn red fileinput-exists" href="#">
                                                                                        Remove </a>
                                                                                </div>-->
                                    </div>
                                    <div  class="form-group">
                                        <div class="input-group">
                                            <div><div style="margin-left:15px;"><span style="color:red;" >image size should be 132 * 132 or Bigger </span></div>
                                                <div class="col-md-3" id="dp">
                                                    <button class="btn btn-success" id="upload_ajax"  type="button">
                                                        <span class="docs-tooltip" data-toggle="tooltip">
                                                            Change Image
                                                        </span>
                                                    </button>
                                                </div>
        <!--                                                <div class="col-md-3"><input type="file" accept="image/*" onchange="changedp(this)" id="my_file1" style="display: block;" name="banner"  required=""/></div>-->

    <!--                                                <a onClick="browse_img()"></a> <span></span> <a href="#"></a>-->
                                            </div>
                                        </div>
                                        <!--<div class="col-md-9" id="add" style=" display:  none;">-->
                                        <!--<button type="submit" style="float: right; margin: 13px 100px 0 0;" class="btn green button-submit">Save Cropped Image</button>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="margiv-top-10">
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                            <input type="submit" class="btn green" value="Update User">
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <div id="image_resize">  </div>
</div>
<div class="clearfix">
</div>
<script>

    $(function () {
        var btnUpload = $("#upload_ajax");

        var up_archive = new AjaxUpload(btnUpload, {
            responseType: "json",
            action: site_url + "/ajaxUploadUser",
            name: "uploadfile",
            onSubmit: function (file, ext) {
                $('.ajx_loder').show();
                if (!(ext && /^(jpeg|JPEG|png|PNG|jpg|JPG|gif)$/.test(ext))) {
                    apprise('Only jpeg , JPG , gif , or png images are Allowed');
                    $('.ajx_loder').hide();
                    return false;
                }

            },
            onComplete: function (file, response) {

                var name = response.name;
                if (name != false) {
                    img_selector(name);

                    $('#old_image').hide();
                    $('#dp').prepend('<div id="imageCont" style="display: none; position:relative;" ><img id="imgRel" style="width: 365px;" src="<?php echo url(); ?>/assets/admin/layout/img/avatar1.jpg"  alt=""><div onclick="del(\'' + name + '\')" class="del" style="position:absolute; top:-10px; right: -333px; cursor: pointer;" ><img src="<?php echo url(); ?>/assets/admin/layout/img/cross.png"></div></div>');
                    $('#dp').append('<input id="imgRel_val" type="hidden" class="numberfile" value="' + response.name + '" name="profile_image" />')
                    $('#add').show();

                } else {
                    $('.ajx_loder').hide();
                    apprise('Image size should be 132 * 132 or Bigger');
                }
                ;
            }
        });



    });

    function img_selector(name) {

        var url = "<?php echo URL::to('/') . '/' . CommonHelper::$driver['main_banner_path']; ?>" + name;

        $.ajax({
            type: "post",
            url: site_url + "/userImageSelector",
            data: {name: name, url: url},
            success: function (result) {

                $('#image_resize').html(result).show();
                $('.ajx_loder').hide();
            },
            error: function () {
                $('.ajx_loder').hide();
                apprise('Something Gone wrong.');
            },
        });
    }

    function del(name) {
        $('.ajx_loder').show();
        $.ajax({
            type: "post",
            url: site_url + "/delImages",
            data: {name: name},
            success: function (result) {

                $('.ajx_loder').hide();
                $('#upload_ajax').show();
                $('#imageCont').hide();
                $('#add').hide();
                $('#imgRel_val').remove();
                $('#image_resize').html('').hide();
                $('#old_image').show();

            },
            error: function () {
                $('.ajx_loder').hide();
                apprise('Something Gone wrong.');
            },
        });
    }
</script>
@stop