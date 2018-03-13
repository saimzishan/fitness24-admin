@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Create Merchant first 
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Create Merchant</a>
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
                            <i class="fa fa-globe"></i>Enter Merchant Information
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'post_merchant', 'name'=>'add_merchant', 'enctype'=>'multipart/form-data'))}}
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
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('name',Input::old("name"),array('id'=>'name','class'=>'form-control','placeholder'=>'Enter Name', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('dob',Input::old("dob"),array('id'=>'dob','class'=>'form-control','placeholder'=>'Date of Birth', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('address',Input::old("address"),array('id'=>'address','class'=>'form-control','placeholder'=>'Enter Address', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('city',Input::old("city"),array('id'=>'city','class'=>'form-control','placeholder'=>'Enter City', 'required')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('state',Input::old("state"),array('id'=>'state','class'=>'form-control','placeholder'=>'Enter State', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Zipcode</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('zipcode',Input::old("zipcode"),array('id'=>'zipcode','class'=>'form-control','placeholder'=>'Enter Zipcode','onkeypress'=>'return isNumber(event)', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Account No.</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('account_no',Input::old("account_no"),array('id'=>'account_no','class'=>'form-control','placeholder'=>'Enter Account No.','onkeypress'=>'return isNumber(event)', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Routing No.</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('routing_no',Input::old("routing_no"),array('id'=>'routing_no','class'=>'form-control','placeholder'=>'Enter Routing No.','onkeypress'=>'return isNumber(event)', 'required')) }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Save Merchant">
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
    google.maps.event.addDomListener(window, 'load', function () {
        new google.maps.places.SearchBox(document.getElementById('address'));
        directionsDisplay = new google.maps.DirectionsRenderer({'draggable': true});
    });
    $(document).ready(function () {
        $('#dob').datepicker({
            format: 'yy-mm-dd',
            onClose: function (selectedDate) {
                // Set The min date for valid to
                $("#dob").datepicker("option", "minDate", selectedDate);
            }
        });
    });
</script>
@stop