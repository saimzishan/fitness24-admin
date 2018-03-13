@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    FAQ <small>Add FAQ Categories</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">FAQ Category
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New FAQ Category</a>
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
                            <i class="fa fa-globe"></i>Create New FAQ Category
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'postFaqCat', 'name'=>'postFaqCat', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                                if (isset($faq)) { ?>
                                    <input type="hidden" readonly name="id" value="{{$faq->id}}" >
                                <?php
                                }
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group" style="width: 80%">
                                            <?php
                                            if( isset($faq)) { ?>
                                            {{ Form::text('name' ,$faq->Name,Input::old("name"),array('id'=>'name','class'=>'form-control','placeholder'=>'Name','required')) }}
                                             <?php } else { ?>
                                            {{ Form::text('name' ,Input::old("name"),array('id'=>'name','class'=>'form-control','placeholder'=>'Name','required')) }}
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="input-group" style="width: 80%">
                                            <?php if( isset($faq)) { ?>
                                            {{ Form::textarea('description',$faq->Description,Input::old("description"),array('id'=>'description','class'=>'form-control','placeholder'=>'Description','required')) }}
                                            <?php } else { ?>
                                            {{ Form::textarea('description',Input::old("description"),array('id'=>'description','class'=>'form-control','placeholder'=>'Description','required')) }}
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Name</label>
                                        <div class="input-group" style="width: 80%">
                                            <?php
                                            if( isset($faq)) { ?>
                                            {{ Form::text('arabicName' ,$faq->arabicName,Input::old("arabicName"),array('id'=>'arabicName','class'=>'form-control','placeholder'=>'Arabic Name')) }}
                                             <?php } else { ?>
                                            {{ Form::text('arabicName' ,Input::old("arabicName"),array('id'=>'arabicName','class'=>'form-control','placeholder'=>'Arabic Name')) }}
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Arabic Description</label>
                                        <div class="input-group" style="width: 80%">
                                            <?php if( isset($faq)) { ?>
                                            {{ Form::textarea('arabicDescription',$faq->arabicDescription,Input::old("arabicDescription"),array('id'=>'arabicDescription','class'=>'form-control','placeholder'=>'Arabic Description')) }}
                                            <?php } else { ?>
                                            {{ Form::textarea('arabicDescription',Input::old("arabicDescription"),array('id'=>'arabicDescription','class'=>'form-control','placeholder'=>'Arabic Description')) }}
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Save">
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
</div>
<script>
    $(document).ready(function () {
        $('#expiry_date').datepicker({
            dateFormat: 'yy-mm-dd',
            onClose: function (selectedDate) {
                // Set The min date for valid to
                $("#expiry_date").datepicker("option", "minDate", selectedDate);
            }
        });


        var route_url = '<?php echo route("select_city") ?>';
        $(document).on('change', "#users-state", function () {

            var state = $(this).attr('value');
            $.ajax({
                type: "POST",
                data: {state: state},
                url: route_url,
                success: function (data) {
                    $("#city").html('');
                    $("#city").html(data);
                }
            });
        });


        var route_url1 = '<?php echo route("select_email") ?>';
        $(document).on('change', "#send_to", function () {
            var user_id = $(this).attr('value');
            $.ajax({
                type: "POST",
                data: {user_id: user_id},
                url: route_url1,
                success: function (data) {
                    $("#email").html('');
                    $("#city").html('');
                    $("#email").html(data);
                }
            });
        });


    });

    function validateForm() {
        var x = document.forms["post_promo_code"]["send_to"].value;
        if (x == 0) {
//            apprise("Profile Image must be Selected");
            $.alert({
                title: 'No user!',
                content: 'Please select a User',
                confirmButton: 'Ok',
                confirmButtonClass: 'btn btn-success',
                columnClass: 'col-md-4 col-md-offset-4',
                animation: 'zoom'
            });
            return false;
        }
    }
</script>
@stop