$(document).ready(function () {
    $('#dob').datepicker({
        dateFormat: 'yy-mm-dd',
        onClose: function (selectedDate) {
            // Set The min date for valid to
            $("#dob").datepicker("option", "minDate", selectedDate);
        }
    });
});
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function hudMsg(type, message, timeOut) {

    $('.hudmsg').remove();

    if (!timeOut) {
        timeOut = 3000;
    }

    var timeId = new Date().getTime();

    if (type != '' && message != '') {
        $('<div class="hudmsg ' + type + '" id="msg_' + timeId + '"><img src="' + site_url + '/assets/msg_' + type + '.png" alt="" />' + message + '</div>').hide().appendTo('body').fadeIn();

        var timer = setTimeout(
                function () {
                    $('.hudmsg#msg_' + timeId + '').fadeOut('slow', function () {
                        $(this).remove();
                    });
                }, timeOut
                );
    }
}

//////////////// Start Change user status process ///////////
function user_status_change(status, user_id, route_url) {
    if (user_id != '') {
        $.ajax({
            type: "POST",
            data: {id: user_id, archive: status},
            url: route_url,
            success: function (data) {
                change_user_status(status, user_id);
            }
        });
    }
    else {
        hudMsg("error", "User status Could not be changed");
    }
}

function video_status_change(status, video_id, key, route_url) {

    if (video_id != '') {
        $.ajax({
            type: "POST",
            data: {id: video_id, key: key, val:status},
            url: route_url,
            success: function (data) {
                change_video_status(status, video_id, key);
            }
        });
    }
    else {
        hudMsg("error", "User status Could not be changed");
    }
}
function change_video_status(status, video_id, key) {
    if (status == 0) {
        if(key == 'archived'){
        $('#'+ key + video_id).addClass('fa-power-off');
        $('#' + key + video_id).removeClass('fa-rotate-right');
        $('#' + key + video_id).attr("status", "1");
        hudMsg("success", "Video has been Deleted");
        }
         if(key == 'is_featured'){
        $('#'+ key + video_id).html('MakeFeatured');
        $('#' + key + video_id).attr("status", "1");
        hudMsg("success", "Video has been Featured");
        }
         if(key == 'is_free'){
        $('#'+ key + video_id).html('MakeFree');
        $('#' + key + video_id).attr("status", "1");
        hudMsg("success", "Video has been Made Free");
        }
    }
    else {
        if(key == 'archived'){
        $('#'+ key + video_id).removeClass('fa-power-off');
        $('#' + key + video_id).addClass('fa-rotate-right');
        $('#' + key + video_id).attr("status", "0");
        hudMsg("success", "Video has been Deleted");
        }
         if(key == 'is_featured'){
        $('#'+ key + video_id).html('UnFeatured');
        $('#' + key + video_id).attr("status", "0");
        hudMsg("success", "Video has been UnFeatured");
        }
         if(key == 'is_free'){
        $('#'+ key + video_id).html('MakePaid');
        $('#' + key + video_id).attr("status", "0");
        hudMsg("success", "Video has been Made Paid");
        }
    }
}

function change_user_status(status, user_id) {
    if (status == 0) {
        $('#user' + user_id).removeClass('fa-power-off');
        $('#user' + user_id).addClass('fa-rotate-right');
        $('#user' + user_id).attr("status", "1");
        hudMsg("success", "User has been Activated");
    }
    else {
        $('#user' + user_id).removeClass('fa-rotate-right');
        $('#user' + user_id).addClass('fa-power-off');
        $('#user' + user_id).attr("status", "0");
        hudMsg("success", "User has been Deactivated");
    }
}
//////////////// End Change user status process /////////////

//////////////// Start Change Vehicle status process ///////////
function vehicle_change_status(status, vehicle_id, route_url) {
    if (vehicle_id != '') {
        $.ajax({
            type: "POST",
            data: {id: vehicle_id, archive: status},
            url: route_url,
            success: function (data) {
                change_vehicle_status(status, vehicle_id);
            }
        });
    }
    else {
        hudMsg("error", "Vehicle status Could not be changed");
    }
}
function change_vehicle_status(status, vehicle_id) {
    if (status == 0) {
        $('#vehicle' + vehicle_id).removeClass('fa-power-off');
        $('#vehicle' + vehicle_id).addClass('fa-rotate-right');
        $('#vehicle' + vehicle_id).attr("status", "1");
        hudMsg("success", "Vehicle has been Activated");
    }
    else {
        $('#vehicle' + vehicle_id).removeClass('fa-rotate-right');
        $('#vehicle' + vehicle_id).addClass('fa-power-off');
        $('#vehicle' + vehicle_id).attr("status", "0");
        hudMsg("success", "Vehicle has been Deactivated");
    }
}
//////////////// End Change vehicle status process /////////////

//////////////// Start Change Spot status process ///////////
function spot_change_status(status, spot_id, route_url) {
    if (spot_id != '') {
        $.ajax({
            type: "POST",
            data: {id: spot_id, archive: status},
            url: route_url,
            success: function (data) {
                change_spot_status(status, spot_id);
            }
        });
    }
    else {
        hudMsg("error", "Spot status Could not be changed");
    }
}
function delete_nutrition(id, route_url){
    if (id != '') {
        $.ajax({
            type: "POST",
            data: {id:id},
            url: route_url,
            success: function (data) {
                $('#video_'+id).remove();
            }
        });
    }
    else {
        hudMsg("error", "Spot status Could not be changed");
    }
}
function change_spot_status(status, spot_id) {
    if (status == 0) {
        $('#spot' + spot_id).removeClass('fa-power-off');
        $('#spot' + spot_id).addClass('fa-rotate-right');
        $('#spot' + spot_id).attr("status", "1");
        hudMsg("success", "Spot has been Activated");
    }
    else {
        $('#spot' + spot_id).removeClass('fa-rotate-right');
        $('#spot' + spot_id).addClass('fa-power-off');
        $('#spot' + spot_id).attr("status", "0");
        hudMsg("success", "Spot has been Deactivated");
    }
}
//////////////// End Change Spot status process /////////////

//////////////// Start Change Vehicle Make status process ///////////
function make_status_change(status, make_id, route_url) {
    if (make_id != '') {
        $.ajax({
            type: "POST",
            data: {id: make_id, archive: status},
            url: route_url,
            success: function (data) {
                change_make_status(status, make_id);
            }
        });
    }
    else {
        hudMsg("error", "Make type status Could not be changed");
    }
}
function change_make_status(status, make_id) {
    if (status == 0) {
        $('#make' + make_id).removeClass('fa-power-off');
        $('#make' + make_id).addClass('fa-rotate-right');
        $('#make' + make_id).attr("status", "1");
        hudMsg("success", "Make type has been Activated");
    }
    else {
        $('#make' + make_id).removeClass('fa-rotate-right');
        $('#make' + make_id).addClass('fa-power-off');
        $('#make' + make_id).attr("status", "0");
        hudMsg("success", "Make type has been Deactivated");
    }
}
//////////////// End Change Make status process /////////////
//
//////////////// Start Change Model status process ///////////
function model_status_change(status, model_id, route_url) {
    if (model_id != '') {
        $.ajax({
            type: "POST",
            data: {id: model_id, archive: status},
            url: route_url,
            success: function (data) {
                change_model_status(status, model_id);
            }
        });
    }
    else {
        hudMsg("error", "Model status Could not be changed");
    }
}
function change_model_status(status, model_id) {
    if (status == 0) {
        $('#model' + model_id).removeClass('fa-power-off');
        $('#model' + model_id).addClass('fa-rotate-right');
        $('#model' + model_id).attr("status", "1");
        hudMsg("success", "Model has been Activated");
    }
    else {
        $('#model' + model_id).removeClass('fa-rotate-right');
        $('#model' + model_id).addClass('fa-power-off');
        $('#model' + model_id).attr("status", "0");
        hudMsg("success", "Model has been Deactivated");
    }
}
//////////////// End Change Model status process /////////////