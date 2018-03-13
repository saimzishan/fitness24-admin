@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Parking Spot <small>Add parking spot</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Parking Spot</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Parking Spot</a>
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
                            <i class="fa fa-globe"></i>Enter Parking Spot Information
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'post_parking_spot', 'name'=>'parking_spot', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Spot Address</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('address',Input::old("address"),array('id'=>'address','class'=>'form-control','placeholder'=>'Enter Address', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Feature</label>
                                        <div class="input-group" style="width: 100%">
                                            <select name="parking_feature[]" id="parking_feature" class="form-control" multiple size="4" required>
                                                <?php
                                                foreach ($features as $feature) {
                                                    echo '<option value="' . $feature->id . '">' . $feature->feature . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="input-group" style="width: 100%">
                                            <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                                        </div>
                                        <input type="hidden" name="user_id"  value="<?php echo $user_id; ?>">
                                        <input type="hidden" name="day[]"  value="Monday">
                                        <input type="hidden" name="day[]"  value="Tuesday">
                                        <input type="hidden" name="day[]"  value="Wednesday">
                                        <input type="hidden" name="day[]"  value="Thursday">
                                        <input type="hidden" name="day[]"  value="Friday">
                                        <input type="hidden" name="day[]"  value="Saturday">
                                        <input type="hidden" name="day[]"  value="Sunday">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Spot Number</label>
                                        <div class="input-group" style="width: 100%">
                                            {{ Form::text('spot_number',Input::old("spot_number"),array('id'=>'spot_number','class'=>'form-control','placeholder'=>'Spot number', 'onkeypress'=>'return isNumber(event)')) }}
                                        </div>
                                    </div>
<!--                                    <div data-provides="fileinput" class="fileinput fileinput-new">
                                        <div style="width: 110px; height: 100px; line-height: 150px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
                                            <img style="width: 160px; height: 150px;" src="<?php // echo CommonHelper::getCategoryImage('');                             ?>" alt=""/>
                                        </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new">
                                                    Select image </span>
                                                <span class="fileinput-exists">
                                                    Change </span>
                                                <input type="file" name="parking_image">
                                            </span>
                                            <a data-dismiss="fileinput" class="btn red fileinput-exists" href="#">
                                                Remove </a>
                                        </div>
                                    </div>-->
                                    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
                                    <input type="button" id="add_more" class="upload" value="Add More Files"/>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Save Spot" id="upload">
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
</script>
@stop