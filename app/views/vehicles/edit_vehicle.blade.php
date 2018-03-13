@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Vehicles <small>Edit vehicle</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Vehicles</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Edit vehicle</a>
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
                            Edit Vehicle
                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{Form::open(array('route' => 'update_vehicle', 'name'=>'add-vehicle', 'enctype'=>'multipart/form-data'))}}
                        <?php echo Form::model($vehicle, array('route' => array('update_user', $vehicle->id))); ?>
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Licence Plate</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('licence',Input::old("licence"),array('id'=>'licence','class'=>'form-control','placeholder'=>'Licence Plate','required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Make Year</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('year',Input::old("year"),array('id'=>'year','class'=>'form-control','placeholder'=>'Making year', 'onkeypress'=>'return isNumber(event)', 'required')) }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id"  value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="id"  value="<?php echo $vehicle->id; ?>">
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Make</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="make" id="vehicle_make" class="form-control">
                                                <?php
                                                foreach ($vehicle_make as $make) {
                                                    $selected = '';
                                                    if ($vehicle->make == $make['name']) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="' . $make['id'] . '" ' . $selected . '>' . $make['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Model</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="model" id="vehicle_model" class="form-control">
                                                <?php
                                                foreach ($models as $model) {
                                                    $selected_model = '';
                                                    if ($vehicle->model == $model['model']) {
                                                        $selected_model = 'selected';
                                                    }
                                                    echo '<option value="' . $model['model'] . '" ' . $selected_model . '>' . $model['model'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--                                    <div data-provides="fileinput" class="fileinput fileinput-new">
                                                                            <div style="width: 110px; height: 100px; line-height: 150px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
                                                                                <img style="width: 110px; height: 100px;" src="<?php // echo url();   ?>/assets/uploads/<?php // echo $vehicle->vehicle_image;   ?>" alt=""/>
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn default btn-file">
                                                                                    <span class="fileinput-new">
                                                                                        Change image </span>
                                                                                    <span class="fileinput-exists">
                                                                                        Change </span>
                                                                                    <input type="file" name="vehicle_image">
                                                                                </span>
                                                                                <a data-dismiss="fileinput" class="btn red fileinput-exists" href="#">
                                                                                    Remove </a>
                                                                            </div>
                                                                        </div>-->
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Update Vehicle">
    <!--                            <a href="<?php // echo route("home");    ?>" class="btn default">
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
<script>
    var route_url = '<?php echo route("select_model") ?>';
    $(document).on('change', "#vehicle_make", function () {
        var id = $(this).attr('value');
        $.ajax({
            type: "POST",
            data: {make_id: id},
            url: route_url,
            success: function (data) {
                $("#vehicle_model").html(data);
            }
        });
    });
</script>
@stop