@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Coupons <small>Edit Coupon</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Coupons
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Edit Coupon</a>
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
                            <i class="fa fa-globe"></i>Enter Coupon Information
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'update_promo_code', 'name'=>'post_promo_code', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Type</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="type" id="type" class="form-control">
                                                <?php if($coupon->type == 'Monthly'){ ?>
                                                <option selected value="Monthly">Monthly</option>
                                                <option value="Weekly">Weekly</option>
                                                <?php }else{ ?>
                                                <option value="Monthly">Monthly</option>
                                                <option selected value="Weekly">Weekly</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Code</label>
                                        <div class="input-group" style="width: 80%">
                                            <input name="coupon_code" class="form-control" value="{{$coupon->coupon_code}}" id="coupon_code" required />
                                        </div>
                                    </div>                                
<!--                                    <div class="form-group">
                                        <label>Send to user</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="send_to" id="send_to" class="form-control">
                                                <option value='0'>Select User</option>
                                                <option value='all'>All Users</option>
                                                ?php
                                                foreach ($users as $user) {
                                                    echo '<option value="' . $user->id . '">' . $user->first_name . ' ' . $user->last_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="form-group" id="city">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country Code</label>
                                        <div class="input-group" style="width: 80%">
                                            <input name="country_code" class="form-control" value="{{$coupon->country_code}}" id="country_code" required />
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label>Expiry Date</label>
                                        <div class="input-group" style="width: 80%">
                                            <input name="expiry_date" class="form-control" value="<?php echo date('m/d/Y', strtotime($coupon->expiry_date));?>" id="expiry_date" required />
                                            <input type="hidden" name="id" class="form-control" value="{{$coupon->id}}" id="id" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" id="email">
                                       
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
        //$("#expiry_date").datepicker("option", "defaultDate", new Date(<?php date('yy ,m,d', strtotime($coupon->expiry_date)); ?>));
        //$('#expiry_date').datepicker("setDate", new Date(<?php date('Y,m,d', strtotime($coupon->expiry_date)); ?> ));
   // $("#expiry_date").datepicker("setDate", "<?php echo date('m/d/Y', strtotime($coupon->expiry_date)); ?>");    
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