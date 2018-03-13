@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Vehicle Models <small>Add new model</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Vehicle Models</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Vehicle Model</a>
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
                            <i class="fa fa-globe"></i>Enter Model
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'post_new_model', 'name'=>'post_new_model', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Add Model</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('model',Input::old("model"),array('id'=>'model','class'=>'form-control','placeholder'=>'Enter Model', 'required')) }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="make_id" value="<?php echo $make_id; ?>">
                                    <div class="form-group">
                                        <label>Model Generation</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="generation" id="generation" class="form-control">
                                                <option value="select">Select generation</option>
                                                <option value="1st generation">1st generation</option>
                                                <option value="2nd generation">2nd generation</option>
                                                <option value="3rd generation">3rd generation</option>
                                                <option value="4th generation">4th generation</option>
                                                <option value="5th generation">5th generation</option>
                                                <option value="6th generation">6th generation</option>
                                                <option value="7th generation">7th generation</option>
                                                <option value="8th generation">8th generation</option>
                                                <option value="9th generation">9th generation</option>
                                                <option value="10th generation">10th generation</option>
                                                <option value="11th generation">11th generation</option>
                                                <option value="12th generation">12th generation</option>
                                                <option value="13th generation">13th generation</option>
                                                <option value="14th generation">14th generation</option>
                                                <option value="15th generation">15th generation</option>
                                                <option value="16th generation">16th generation</option>
                                                <option value="17th generation">17th generation</option>
                                                <option value="18th generation">18th generation</option>
                                                <option value="19th generation">19th generation</option>
                                                <option value="20th generation">20th generation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--                                    <div data-provides="fileinput" class="fileinput fileinput-new">
                                                                            <div style="width: 150px; height: 150px; line-height: 150px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
                                                                                <img style="width: 160px; height: 150px;" src="<?php // echo CommonHelper::getCategoryImage('');                                             ?>" alt=""/>
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn default btn-file">
                                                                                    <span class="fileinput-new">
                                                                                        Select image </span>
                                                                                    <span class="fileinput-exists">
                                                                                        Change </span>
                                                                                    <input type="file" name="image">
                                                                                </span>
                                                                                <a data-dismiss="fileinput" class="btn red fileinput-exists" href="#">
                                                                                    Remove </a>
                                                                            </div>
                                                                        </div>-->




                                    <div  class="form-group">
                                        <label class="control-label">Select Image <span class="required">
                                                * </span>
                                        </label>
                                        <div class="input-group">
                                            <div><div style="margin-left:15px;"><span style="color:red;" >image size should be 498 * 498 or Bigger </span></div>
                                                <div class="col-md-3" id="dp">
                                                    <button class="btn btn-success" id="upload_ajax"  type="button">
                                                        <span class="docs-tooltip" data-toggle="tooltip">
                                                            Browse
                                                        </span>
                                                    </button>
                                                </div>
                                                <!--<div class="col-md-3"><input type="file" accept="image/*" onchange="changedp(this)" id="my_file1" style="display: block;" name="banner"  required=""/></div>-->

                                                <!--<a onClick="browse_img()"></a> <span></span> <a href="#"></a>-->
                                            </div>
                                        </div>
                                        <!--                                        <div class="col-md-9" id="add" style=" display:  none;">
                                                                                    <button type="submit" style="float: right; margin: 13px 100px 0 0;" class="btn green button-submit">Save Cropped Image</button>
                                                                                </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Add Model">
                            </div>
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
        function validateForm() {
        var x = document.forms["post_new_model"]["generation"].value;
        if (x == "select") {
            //            apprise("Profile Image must be Selected");
                $.alert({
                title: 'Error!',
                content: 'Please select model generation',
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
            action: site_url + "/ajaxUpload",
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
                    
                    $('#dp').prepend('<div id="imageCont" style="display: none; position:relative;" ><img id="imgRel" style="width: 365px;" src="<?php echo URL::to('/'); ?>/assets/admin/layout/img/avatar1.jpg"  alt=""><div onclick="del(\'' + name + '\')" class="del" style="position:absolute; top:-10px; right: -333px; cursor: pointer;" ><img src="<?php echo URL::to('/'); ?>/assets/admin/layout/img/cross.png"></div></div>');
                    $('#dp').append('<input id="imgRel_val" type="hidden" class="numberfile" value="' + response.name + '" name="image" />')
                    $('#add').show();
                
                    } else {
                    $('.ajx_loder').hide();
                apprise('Image size should be 498 * 498 or Bigger');
                }
            ;
        }
        });


    
    });
    
    function img_selector(name) {
        
        var url = "<?php echo URL::to('/') . '/' . CommonHelper::$driver['main_banner_path']; ?>" + name;
                
                    $.ajax({
                    type: "post",
                    url: site_url + "/imageSelector",
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