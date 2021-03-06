@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Broadcast Message to Users
                </h3>
               
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
                            
                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{Form::open(array('route' => 'broadcast_message', 'name'=>'user-registration', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::select('type',['Generic', 'All Category'],null,array('id'=>'full_name','class'=>'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Message</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('broadcastMessage',null,array('id'=>'full_name','class'=>'form-control','placeholder'=>'Type your Message here','required')) }}
                                        </div>
                                    </div>
                                </div>
                             
                                
                                </div>
                            </div>
                            <div class="form-body">
                                <input type="submit" class="btn green" value="Send Message">
    <!--                            <a href="<?php // echo route("home");                                                                       ?>" class="btn default">
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
<div id="image_resize">  </div>
<div class="clearfix">
</div>
<script>
    google.maps.event.addDomListener(window, 'load', function () {
        new google.maps.places.SearchBox(document.getElementById('locatin'));
        directionsDisplay = new google.maps.DirectionsRenderer({'draggable': true});
    });
    function validateForm() {
        var x = document.forms["user-registration"]["profile_image"].value;
        if (x == null || x == "") {
//            apprise("Profile Image must be Selected");
            $.alert({
                title: 'No image!',
                content: 'Please select Profile image',
                confirmButton: 'Ok',
                confirmButtonClass: 'btn btn-success',
                columnClass: 'col-md-4 col-md-offset-4',
                animation: 'zoom'
            });
            return false;
        }
    }
</script>
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

        var url = "<?php echo CommonHelper::$driver['main_banner_path']; ?>" + name;

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

            },
            error: function () {
                $('.ajx_loder').hide();
                apprise('Something Gone wrong.');
            },
        });
    }
</script>
@stop