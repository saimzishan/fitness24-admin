@extends('common_templates.basic_template')
@section('content')
<style>
#loader-icon2{
   
 position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  background-image:url('ajax-loader.gif');
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
.imageclass{
   left : 37%;
top : 45%;
position:absolute;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Videos <small>Add new Video</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Videos</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Video</a>
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
                            <i class="icon-users"></i> Create New <?php if($nutrition==1){ echo "Nutrition";} else{echo "Video";}?>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{Form::open(array('id'=>'uploadForm2','route' => 'post_edit_video', 'name'=>'add-video', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6 ">
                                     <div class="form-group">
                                        <label>Make Video Free ?</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::checkbox('is_free', 1, ($video['is_free']==1)?True:False, array('id'=>'is_free','class'=>'form-control', ($video['is_free']==1)? 'checked': '' )) }}
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label>Send Notification to Users?</label>
                                        <div class="input-group" >
                                            {{ Form::checkbox('is_notification', 1, ($video['is_send_notification']==1)?True:False, array('id'=>'is_notification','class'=>'form-control', ($video['is_send_notification']==1)? 'checked': '' )) }}
                                        </div>
                                    </div>
                                    <div class="form-group" id="showNotifcation" <?php if($video['is_send_notification']!=1){?>style="display:none"<?php }?> >
                                        <label>Notification</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('notification','',array('id'=>'title_en','class'=>'form-control','placeholder'=>'Enter Notification')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>English Title</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('title_en',$video['title_en'],array('id'=>'title_en','class'=>'form-control','placeholder'=>'English Ttile','required')) }}
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label>English Description</label>
                                        <div class="input-group" >
                                            {{ Form::textarea('description_en', $video['description_en'] , array('id'=>'description_en','class' => 'ckeditor','placeholder'=>'English Description',)) }}
                                        </div>
                                    </div>   
                                     <div class="form-group">
                                        <div id="hidethumb">
                                            <?php if(($video['type']=='image' || $video['type']=='video') && $video['thumb']){?>
                                            <div data-provides="fileinput" class="fileinput fileinput-new" id="old_image">
                                                <div style="width: 180px; height: 170px; line-height: 150px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
                                                    <img style="width: 180px; height: 160px;" src="<?php echo CommonHelper::$driver['s3_uploads'] . 'Images/'. $video->thumb; ?>" alt=""/>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                        <div id="video" class="all_nutirition_type" <?php if($video['type']=='image' || $video['type']=='text'){?> style="display:none"<?php }?>>
                                            <label>Upload New Video</label>
                                            <div class="input-group" style="width: 100%">
                                                {{ Form::file('video',array('id'=>'video_up','class'=>'form-control','placeholder'=>'English Ttile')) }}
                                            </div>
                                        </div>
                                        <?php if($nutrition){?>
                                        <div id="image" class="form-group all_nutirition_type" <?php if($video['type']!='image'){?> style="display:none"<?php }?>>
                                        <label>Upload Image</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::file('image',array('id'=>'image_up','class'=>'form-control ','placeholder'=>'English Ttile')) }}
                                        </div>
                                    </div>
                                        <?php }?>
                                    </div>
                                  
                                </div>
                                <div class="col-md-6 ">
                                    <?php if(!$nutrition){?>
                                    <div class="form-group">
                                        <label>This Video is Featured ?</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::checkbox('is_featured', 1, ($video['is_featured']==1)?True:False, array('id'=>'is_featured','class'=>'form-control', ($video['is_featured']==1)? 'checked': '')) }}
                                        </div>
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <div class="input-group" style="width: 100%">
<!--                                            {{ Form::select('category_id', $categories) }}-->
                                            <select name="category_id" id="category_id" required>
                                                <?php foreach ($categories as $key => $value) { ?>
                                                <option value="{{$value['id']}}" <?php if($value['id']==$video['category_id']) {echo 'selected';}?>>
                                                    {{$value['title']}}
                                                   </option>                             
                                               <?php }?>

                                            </select>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="form-group">
                                        <label>Arabic Title</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('title_ar',$video['title_ar'],array('id'=>'title_ar','class'=>'form-control','placeholder'=>'Arabic Ttile','required')) }}
                                        </div>
                                    </div>
                                    <?php if($nutrition){?>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <div class="input-group" >
                                            <select class="form-control input-inline input-sm input-small" id="nut_type" name="type">
                                                <option value="video" <?php if($video['type']=='video'){echo "selected";}?> >Video</option>
                                                <option value="image" <?php if($video['type']=='image'){echo "selected";}?> >Image</option>
                                                <option value="text" <?php if($video['type']=='text'){echo "selected";}?> >Text</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="form-group">
                                        <label>Arabic Description</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::textarea('description_ar', $video['description_ar'] , array('id'=>'description_ar','class' => 'ckeditor','placeholder'=>'Arabic Descriptions',)) }}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Tags</label>
                                        <?php $keywords=explode(',', $video['keyword']); ?>
                                        <select size="9" name="tags[]" id="tags" multiple required>
                                        <?php //if($keywords[0]==$goal['id']) {echo "selected";}?>
                                            <?php foreach ($goals as $key => $goal) { 
                                                
                                            $keyExist=array_key_exists($key,$keywords);?>
                                                <option value="{{$goal['id']}}"  <?php foreach($keywords as $keyTag){ if($keyTag == $goal['id']){echo "selected";}}?>>
                                                    {{$goal['title_en']}} / {{$goal['title_ar']}}
                                                   </option>                             
                                               <?php }?>
                                                   
                                        </select>
<!--                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('tags',Input::old("tags"),array('id'=>'tags','class'=>'form-control','placeholder'=>'Tag1, Tag2,','required')) }}
                                        </div>-->
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="margiv-top-10">
                            <?php if($nutrition)
                            {?>
                                <input type="hidden" name="nutrition" value="1">
                            <?php }?>
                            <input type="hidden" name="id" value="<?php echo $video->id; ?>">
                                <input type="submit" class="btn green" value="Save Video">
    <!--                            <a href="<?php // echo route("home");                                                                       ?>" class="btn default">
                                    Cancel </a>-->
                            </div>
                            {{ Form::close() }}
                            <div id="loader-icon2" style="display:none;"><img src="LoaderIcon.gif" class="imageclass" /></div>
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

$('#is_notification').click(function() {
  $('#showNotifcation')[this.checked ? "show" : "hide"]();
});
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
    $('#nut_type').on('change', function() {
        var type = this.value;
        $('.all_nutirition_type').hide();
        $('#'+type).show();
            
    });
</script>
@stop