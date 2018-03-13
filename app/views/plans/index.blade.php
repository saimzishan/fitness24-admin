@extends('common_templates.basic_template')
@section('content')
    <style>
        .modal-dialog {
            width: 75%;
            margin: 2% auto;
        }
    </style>
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Plans <small>All Plans List</small>
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">

                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo route("home"); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="" style="text-decoration:none">Plans</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="" style="text-decoration:none">All Plans</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey-cascade">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-users"></i>All Plans
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="table-toolbar">
                                <a style="text-decoration:none" href="<?php echo route("newPlan"); ?>">
                                    <div class="btn-group">
                                        <button id="sample_editable_1_new" class="btn green">
                                            Add New Plan <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </a>
                            </div>
                              <div class="container">  
                                 <div class="row well">
                                      <div class="col-md-1">ID</div>  
                                      <div class="col-md-2">Description</div>  
                                      <div class="col-md-1">Gender</div>  
                                      <div class="col-md-1">Level</div>  
                                      <div class="col-md-2">Number Of Weeks</div>  
                                      <div class="col-md-3">Plan Days</div>
                                      <div class="col-md-2">Action</div>  
                                </div>
                                    @foreach($plansWithdays as $codes)
                                        <div class="row" style="padding: 10px; background-color: #78909C">
                                              <div class="col-md-1"> <?php echo $codes['id']; ?></div>  
                                              <div class="col-md-2"><?php echo $codes['description']; ?></div>  
                                              <div class="col-md-1"><?php if($codes['gender'] === 1){
                                                echo "Male";
                                              } else { echo "Female";} ?></div>  
                                              <div class="col-md-1"> <?php if($codes['level'] === 1) {
                                                echo "Beginner"; 
                                              } else {
                                                echo "Advance";
                                              } ?></div>  
                                              <div class="col-md-2">  
                                                <?php echo $codes['number_of_weeks']; ?>
                                              </div>  
                                              <div class="col-md-3">  <!-- input type="button" class="btn btn-info" value="View Details" data-toggle="collapse" data-target="#demo" onclick="getPlanDays({{$codes['id']}})"> -->
                                                <button style="color:eeeeee ;background-color:#eeeeee class= "btn btn-xs btn-info" data-toggle="collapse" data-target="#plandaysColaps{{ $codes['id']}}">
                                                    <span class="fa fa-angle-down "></span>
                                                </button>
                                              
                                              </div>  
                                              <div class="col-md-2"><a style="text-decoration:none" href="<?php echo route("newPlan", array('id' => $codes['id'])); ?>" 
                                                    title="Edit">
                                                    <div style="font-size: 22px;color: black;" class="fa fa-edit"></div>
                                                </a>-
                                                <a  onclick="return confirm('Are you sure you want to delete this plan?');" href="<?php echo route("deletePlan", array('id' => $codes['id'])); ?>" title="Delete">
                                                    <div style="font-size: 22px;color: black;" class="fa fa-trash-o"></div>
                                                </a>
                                            </div>  
                                        
                                         <div class="container-fluid" style=" ">
                                             <div id="plandaysColaps{{$codes['id']}}" class="collapse">
                                                <br>
                                                    <div class="row" style="padding: 10px; background-color: #EEEEEE; margin-top: 10px">
                                                      <div class="col-md-1">ID</div>  
                                                      <div class="col-md-2">planID</div>  
                                                      <div class="col-md-1">dayID</div>  
                                                      <div class="col-md-3">created_at</div>
                                                        <div class="col-md-3">Plan Days Exercises</div>  

                                                      <div class="col-md-2">Action</div>  
                                                </div>
                                                 
                                             @foreach($codes->plandays as $planDay)
                                                <div class="row" style="padding: 10px; background-color: #90A4AE">
                                                    <div class="col-md-1"> <?php echo $planDay['id']; ?></div>  
                                                      <div class="col-md-2"><?php echo $planDay['planID']; ?></div>  
                                                      <div class="col-md-1"><?php echo $planDay['dayID']; ?></div>  
                                                      <div class="col-md-3"> <?php echo $planDay['created_at']; ?></div>  
                                                      <div class="col-md-3">
                                                          <button style="color:eeeeee ;background-color:#eeeeee class="btn btn-xs btn-info" data-toggle="collapse" data-target="#plandaysExerColaps{{ $planDay['id']}}">
                                                    <span class="fa fa-angle-down"></span>
                                                </button>
                                                      </div>
                                                      <div class="col-md-2">  <?php echo $planDay['number_of_weeks']; ?>
                                                  </div>
                                                  </div>
                                                  <br>
                                                  <!-- Plan days Exercises -->
                                                    <div class="container-fluid" style="">
                                                         <div id="plandaysExerColaps{{$planDay['id']}}" class="collapse">
                                                            <br>
                                                             <!-- header EEEEEE -->
                                                            <div class="row" style="padding: 10px; background-color: #EEEEEE; margin-top: -30px">
                                                              <div class="col-md-1">ExerciseID</div>  
                                                              <div class="col-md-1">PlandayID</div>  
                                                              <div class="col-md-1">Title</div>  
                                                              <div class="col-md-3">Description</div>
                                                                <div class="col-md-2">Image</div>  
                                                                <div class="col-md-2">Videos</div>
                                                              <div class="col-md-2">Action</div>  
                                                            </div>
                                                            <!-- header -->
                                                            <!-- body -->
                                                                 @foreach($planDay->exercise as $planDayExer)
                                                                 <div class="row" style="padding: 1%; background-color: #B0BEC5">
                                                                          <div class="col-md-1"> <?php echo $planDayExer['ExerciseID']; ?></div>
                                                                          <div class="col-md-1"><?php echo $planDayExer['plandayID']; ?></div>
                                                                          <div class="col-md-1"><?php echo $planDayExer['title']; ?></div>
                                                                          <div class="col-md-3"> <?php echo $planDayExer['description']; ?></div>
                                                                          <div class="col-md-2">
                                                                              <img src="uploads/{{$planDayExer['image']}}" width="50px">
                                                                          </div>
                                                                          <div class="col-md-2">
                                                                               <button style="color:eeeeee ;background-color:#eeeeee class="btn btn-xs btn-info" data-toggle="collapse" data-target="#plandaysExerVideo{{ $planDayExer['id']}}">
                                                                                <span class="fa fa-angle-down"></span>
                                                                            </button>
                                                                          </div>
                                                         </div>

              <!-- ex_videos -->
               <div class="container-fluid" style="">
                    <div id="plandaysExerVideo{{$planDayExer['id']}}" class="collapse">
                        <br>
                     <!-- header EEEEEE -->
                        <div class="row" style="padding: 10px; background-color: #EEEEEE; margin-top: -10px">
                          <div class="col-md-1">Id</div>
                          <div class="col-md-2">English title</div>
                          <div class="col-md-3">English Description</div>
                          <div class="col-md-3">Arabic Description</div>
                            <div class="col-md-2">Video</div>
                          <div class="col-md-1">Action</div>
                        </div>

                    <!-- header -->
                    
                    <!-- body -->
                        @foreach($planDayExer->ex_videos as $planDayExerVideo)
                            <div class="row" style="padding: 1%; background-color: #CFD8DC">

                                   <div class="col-md-1"> <?php echo $planDayExerVideo['id']; ?></div>  
                                  <div class="col-md-2"><?php echo $planDayExerVideo['title_en']; ?></div>  
                                  <div class="col-md-3"><?php echo $planDayExerVideo['description_en']; ?></div>  
                                  <div class="col-md-3"> <?php echo $planDayExerVideo['description_ar']; ?></div>  
                                  <div class="col-md-2">
                                      <img src="uploads/{{$planDayExerVideo['thumb']}}" width="50px">
                                  </div>  
                             </div>
                             <br>
                        @endforeach           
                    <!-- body -->
                </div>
            </div>        
              <!-- ex_videos -->
              

                                                                        @endforeach
                                                            <!-- body -->
                                                            <br>
                                                        </div>
                                                    </div>
                                                 <!-- Plan days Exercises -->
                                              @endforeach
                                            </div>
                                        </div> 
                                    </div>
                                    <br>
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Videos Modal -->
    <div id="planDaysModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Plan Related Days</h4>
                    <div class="pull-right modal-title">
                        <div id="success-messgae" class="alert alert-success alert-dismissible">

                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table id="daysTable" class="table table-striped table-bordered" cellspacing="0" width="100%">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
        function getPlanDays(id) {
            localStorage.setItem("planID", id);
            $.ajax({
                type: "GET",
                url: '/getPlanDays/'+id,
                data: {},
                success: function( msg ) {
                    $("#planDaysModal").modal('show');
                var tt = localStorage.getItem('successs');
                if (tt == null){
                    var temp = document.getElementById("success-messgae");
                    temp.innerHTML = " ";
                    localStorage.removeItem('successs');
                }

                $('#daysTable').DataTable( {
                    data: msg,
                    columns: [
                        { title: "ID" },
                        { title: "Day ID" },
                        { title: "Action" }
                    ],

                    destroy: true,
                } );
                var a;
                a = document.getElementById("success-messgae");
                setTimeout(function () {
                    a.innerHTML = " ";
                }, 3000);
            }
        });
        }

        function deletePlandays(id) {
            if(confirm('Are you sure !')) {
                $("#videoModal").modal('hide');
                $.ajax({
                    type: "GET",
                    url: '/deletePlandays/'+id.id,
                    data: {},
                    success: function( msg ) {
                        var planID = localStorage.getItem("planID");
                        // location.reload();
                        getPlanDays(planID);

                        localStorage.setItem('successs',1);
                        var temp = document.getElementById("success-messgae");
                        temp.innerHTML = "<strong>Success</strong> Record removed..";
                    },
                    err: function (err) {
                        console.log(err);
                    }
                });
            }
        }

    </script>
@stop