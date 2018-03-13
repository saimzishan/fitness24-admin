@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Parking Spot <small>Edit parking availability</small>
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
                        <a href="javascript:;" style="text-decoration: none;">Spot Availability</a>
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
                            <i class="fa fa-globe"></i>Availability on <?php echo $day['day']; ?>
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'post_availability', 'name'=>'post_availability'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Available from</label>
                                        <div class="input-group" style="width: 80%">
                                            <input type="text" id="timeformat1" name="start_time" class='form-control' placeholder="01:00:00" value="<?php echo $day['time']['start_time']; ?>" required>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $day['id']; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <input type="hidden" name="spot_id" value="<?php echo $spot_id; ?>">
                                        <input type="hidden" name="archive" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>To</label>
                                        <div class="input-group" style="width: 80%">
                                            <input type="text" id="timeformat2" name="end_time" class='form-control' placeholder="23:00:00" value="<?php echo $day['time']['end_time']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price per Hour</label>
                                        <div class="input-group" style="width: 80%">
                                            <input type="text" name="price_per_hour" class='form-control' placeholder="Price per hour" value="<?php echo $day['price_per_hour']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Max Price</label>
                                        <div class="input-group" style="width: 80%">
                                            <input type="text" name="max_price" class='form-control' placeholder="Max price" value="<?php echo $day['max_price']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Update Info">
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
        $('#timeformat1').timepicker({'timeFormat': 'H:i:s'});
        $('#timeformat2').timepicker({'timeFormat': 'H:i:s'});
    });
</script>
@stop