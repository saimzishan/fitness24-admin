@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Parking Spot <small>view</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Spots</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">View</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>Spot Details
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Picture
                                        </th>
                                        <th>
                                            Spot Address
                                        </th>
                                        <th>
                                            Spot Description
                                        </th>
<!--                                        <th>
                                            Status
                                        </th>-->
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($spot['archive'] == 0) {
                                        $staus = '<span id="spot' . $spot['id'] . '" spot_id="' . $spot['id'] . '" status="1" class="icon fa fa-rotate-right spot_status"></span>';
                                    } else {
                                        $staus = '<span id="spot' . $spot['id'] . '" spot_id="' . $spot['id'] . '"  status="0" class="icon fa fa-power-off spot_status"></span>';
                                    }
                                    ?>
                                    <tr  class="odd gradeX">
                                        <td>
                                            <?php echo $spot['id'] ?>
                                        </td>
                                        <td>
                                            <img style="width: 50px; height: 50px;" src="<?php echo CommonHelper::$driver['s3_uploads'] . 'users/user_' . $user->id . '/spot_images/' . $photos[0]['image'];?>" alt=""/>
                                        </td>
                                        <td>
                                            <?php echo $spot['address'] ?>
                                        </td>
                                        <td>
                                            <?php echo $spot['description'] ?>
                                        </td>
<!--                                        <td>
                                            <?php
//                                            if ($spot['is_reserved'] == 0) {
//                                                echo 'Open';
//                                            } else {
//                                                echo 'Reserved';
//                                            }
                                            ?>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:;" style="font-size:10px;" class="change_reserve_status" user_id="<?php // echo $user_id; ?>" parking_id="<?php // echo $spot['id']; ?>" is_reserved="<?php // echo $spot['is_reserved']; ?>">change</a>
                                        </td>-->
                                        <td>
                                            <a style="text-decoration:none" href="javascript:;" id="map_view" lat="<?php echo $spot['lat']; ?>" lng="<?php echo $spot['lng']; ?>" title="Map View">
                                                Map View
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a style="text-decoration:none" href="<?php echo route("edit_parking_spot", array('user_id' => $user_id, 'spot_id' => $spot['id'])); ?>" title="Edit">
                                                <div class="fa fa-edit"></div>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="text-decoration:none" title="Change Status">
                                                <?php echo $staus; ?>
                                            </a> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <div class="row" id="display_map" style="display: none;">
            <div class="col-md-12" >
                <div id="map_canvas" style="width:700px; height:500px;">

                </div>
            </div>
        </div>
        <div style="margin-top: 10px;">  
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>Spot Availability
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Day
                                        </th>
                                        <th>
                                            Available from
                                        </th>
                                        <th>
                                            Available to
                                        </th>
                                        <th>
                                            Price per hour
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="Spot_availability">
                                    <?php
                                    foreach ($days as $day) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $day['day']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($day['archive'] == 0) {
                                                    echo date('h:i a',strtotime($day['time']['start_time']));
                                                } else {
                                                    echo '<span style="color:red;">Not Available</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($day['archive'] == 0) {
                                                    echo date('h:i a',strtotime($day['time']['end_time']));
                                                } else {
                                                    echo '<span style="color:red;">Not Available</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;
                                                <?php
                                                if ($day['archive'] == 0) {
                                                    echo '$' . $day['price_per_hour'];
                                                } else {
                                                    echo '$0';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a style="text-decoration:none" href="<?php echo route("edit_availability", array('id' => $day['id'], 'user_id' => $user_id, 'spot_id' => $spot['id'])); ?>" title="Change">
                                                    <div class="fa fa-edit"></div>
                                                </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a style="text-decoration:none" href="javascript:;" >
                                                    <?php
                                                    if ($day['archive'] == 0) {
                                                        $staus = '<span id="day' . $day['id'] . '" day_id="' . $day['id'] . '" spot_id="' . $spot['id'] . '" user_id="' . $user_id . '" status="1" class="icon fa fa-power-off day_status" title="Deactivate"></span>';
                                                        echo $staus;
                                                    } else {
                                                        $staus = '<span id="day' . $day['id'] . '" day_id="' . $day['id'] . '" spot_id="' . $spot['id'] . '" user_id="' . $user_id . '" status="0" class="icon fa fa-rotate-right day_status" title="Activate"></span>';
                                                        echo $staus;
                                                    }
                                                    ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>Spot Features
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <a style="text-decoration:none" href="<?php echo route("add_feature", array('user_id' => $user_id, 'spot_id' => $spot['id'])); ?>">
                                <div class="btn-group">
                                    <button class="btn green">
                                        Add Feature <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </a>
                        </div>
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Feature
                                        </th>
                                        <th>
                                            Created
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($spot_features as $feature) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $feature['id'] ?>
                                            </td>
                                            <td>
                                                <?php echo $feature['feature']['feature'] ?>
                                            </td>
                                            <td>
                                                <?php echo $feature['created_at'] ?>
                                            </td>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;
                                                <a style="text-decoration:none" href="javascript:;" class="delete_parking_feature" id="<?php echo $feature['id']; ?>" user_id="<?php echo $user_id; ?>" parking_id="<?php echo $spot['id']; ?>" title="Delete">
                                                    <div class="fa fa-trash-o"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
</div>
<script>
    $(document).on('click', "#map_view", function () {
        var lat = $(this).attr('lat');
        var lng = $(this).attr('lng');
        document.getElementById("display_map").style.display = "block";

        var myOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var myMarkerLatlng = new google.maps.LatLng(lat, lng);
        var marker = new google.maps.Marker({
            position: myMarkerLatlng,
            map: map,
            title: 'Spot Location!'
        });
    });
    var route_url1 = '<?php echo route("spot_status") ?>';
    $(document).on('click', ".spot_status", function () {
        var status = $(this).attr('status');
        var spot_id = $(this).attr('spot_id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to change spot status?',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                spot_change_status(status, spot_id, route_url1);
            }
        });
    });
    var route_url = '<?php echo route("spot_available") ?>';
    $(document).on('click', ".day_status", function () {
        var day_id = $(this).attr('day_id');
        var spot_id = $(this).attr('spot_id');
        var user_id = $(this).attr('user_id');
        var status = $(this).attr('status');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to Change Availability?',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                $.ajax({
                    type: "POST",
                    data: {id: day_id,
                        archive: status,
                        spot_id: spot_id,
                        user_id: user_id
                    },
                    url: route_url,
                    success: function (data) {
                        $("#Spot_availability").html(data);
                        hudMsg("success", "Availability changed");
                    }
                });
            }
        });
    });
    $(document).on('click', ".delete_parking_feature", function () {
        var user_id = $(this).attr('user_id');
        var parking_feature_id = $(this).attr('id');
        var parking_id = $(this).attr('parking_id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to Delete this Feature?',
            confirmButton: 'yes',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn-danger',
            columnClass: 'col-md-4 col-md-offset-4',
            animation: 'zoom',
            confirm: function () {
                window.location.assign(site_url + "/deletespotfeature/" + user_id + "/" + parking_id + "/" + parking_feature_id);
            }
        });
    });
//    $(document).on('click', ".change_reserve_status", function () {
//        var user_id = $(this).attr('user_id');
//        var parking_id = $(this).attr('parking_id');
//        var is_reserved = $(this).attr('is_reserved');
//        $.confirm({
//            title: 'Confirm!',
//            content: 'Are you sure to change Reserve Status?',
//            confirmButton: 'yes',
//            confirmButtonClass: 'btn btn-success',
//            cancelButtonClass: 'btn-danger',
//            columnClass: 'col-md-4 col-md-offset-4',
//            animation: 'zoom',
//            confirm: function () {
//                window.location.assign(site_url + "/reserveStatus/" + user_id + "/" + parking_id + "/" + is_reserved);
//            }
//        });
//    });
</script>
@stop