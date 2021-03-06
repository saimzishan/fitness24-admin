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
                        Exercise <small>All Exercise List</small>
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">

                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo route("home"); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="" style="text-decoration:none">Exercise</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="" style="text-decoration:none">All Exercise</a>
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
                                <i class="icon-users"></i>All EXCERCISE
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                             <div id="success-mesg" class="alert alert-success alert-dismissible">
                                <strong>Succes:</strong> Update successfully
                              </div>
                            <div class="table-toolbar">
                                <a style="text-decoration:none" href="<?php echo route("newExercise"); ?>">
                                    <div class="btn-group">
                                        <button id="sample_editable_1_new" class="btn green">
                                            Add New Exercise <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <div class="container">  
                                 <div class="row well">
                                      <div class="col-md-1">ID</div>  
                                      <div class="col-md-1">Title</div>  
                                      <div class="col-md-2">Arabic Title</div>  
                                      <div class="col-md-2">Description</div>  
                                      <div class="col-md-2">Arabic Description</div>  
                                      <div class="col-md-2">Image</div>  
                                      <div class="col-md-1">Videos</div>  
                                      <div class="col-md-1">Action</div>  
                                </div>
                                @foreach($exercise as $codes)
                                    <div class="row" style="padding: 10px; background-color: #B0BEC5">
                                      <div class="col-md-1"> <?php echo $codes['id']; ?></div>  
                                      <div class="col-md-1"><?php echo $codes['title']; ?></div>  
                                      <div class="col-md-2"><?php echo $codes['arabicTitle'];?></div>  
                                      <div class="col-md-2"> <?php echo $codes['Ex_Description']; ?></div>  
                                      <div class="col-md-2"> <?php echo $codes['arabicDescription']; ?></div>  
                                      <div class="col-md-2">  
                                       <img src="uploads/{{$codes['image']}}" width="50px"> 
                                      </div>
                                      <div class="col-md-1">
                                         <button style="color:eeeeee ;background-color:#eeeeee class="btn btn-xs btn-info" data-toggle="collapse" data-target="#videoColaps{{ $codes['id']}}">
                                                <span class="fa fa-angle-down"></span>
                                            </button>
                                      </div>
                                      <div class="col-md-1">
                                           <a style="text-decoration:none" href="<?php echo route("newExercise", array('id' => $codes['id'])); ?>" title="Edit">
                                                    <div class="fa fa-edit"></div>
                                                </a>
                                            <a style="text-decoration:none; color: #ff0000" href="<?php echo route("deleteExercise", array('id' => $codes['id'])); ?>" title="Delete">
                                                    <div class="fa fa-trash-o"></div>
                                                </a>
                                                <a  href="<?php echo route("getAllVideos", array('id' => $codes['id'])); ?>" title="Add viedo">
                                                 
                                                  <i class="fa fa-plus-square"></i>
                                                   
                                                </a>
                                      </div>
                                    </div>
                                    <div class="container-fluid">
                                      <div id="videoColaps{{$codes['id']}}" class="collapse">  
                                         <div class="row well">
                                              <div class="col-md-1">ID</div>  
                                              <div class="col-md-1">Title</div>  
                                              <div class="col-md-1">Arabic Title</div>  
                                              <div class="col-md-2">Description</div>  
                                              <div class="col-md-2">Arabic Description</div>  
                                              <div class="col-md-1">Image</div>  
                                              <div class="col-md-3">Videos</div>  
                                              <div class="col-md-1">Action</div>
                                        </div>
                                        @foreach($codes->excerciseVideo as $row)   
                                            <div class="row" style="padding: 10px; background-color: #CFD8DC; margin-top: 10px">
                                                 <div class="col-md-1"> <?php echo $row['evId']; ?></div>  
                                                  <div class="col-md-1"><?php echo $row['title_en']; ?></div>  
                                                  <div class="col-md-1"><?php echo $row['title_ar'];?></div>  
                                                  <div class="col-md-2"> <?php echo $row['description_en']; ?></div>
                                                  <div class="col-md-2"> <?php echo $row['description_ar']; ?></div> 
                                                  <div class="col-md-1"> 
                                                         <img src="uploads/{{$row['thumb']}}" width="50px"> 
                                                    </div> 
                                                  <div class="col-md-3">
                                                      <video width="200" controls>
                                                        <source src="uploads/{{$row['url']}}" type="video/mp4">
                                                      </video>
                                                  </div> 
                                                  <div class="col-md-1">
                                                        <button type="button" class="btn btn-default" onclick="deleteVideoById({{$row['evId']}})" style="text-decoration:none; color: #ff0000" title="Remove">
                                                    <div class="fa fa-trash-o"></div>
                                                    </button>
                                                  </div>
                                            </div>
                                        @endforeach      
                                    </div>
                                   </div>     
                                    <br>
                                @endforeach
                         </div>   

                               <!--  <tr>
                                    <td>
                                        <?php echo $codes['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $codes['title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $codes['arabicTitle']; ?>
                                    </td>
                                    <td>
                                        <?php echo $codes['description']; ?>
                                    </td>
                                    <td>
                                        <?php echo $codes['arabicDescription']; ?>
                                    </td>
                                    <td>
                                       <img src="uploads/{{$codes['image']}}" width="50px">
                                    </td>
                                    <td >
                                        <?php echo $codes['workout_time']; ?>
                                    </td>
                                    <td>
                                       <button type="button" class="btn btn-sm btn-info" id="relatedVideos" onclick="relatedVideos(<?php echo $codes['id'];?>)" data-backdrop="static" data-keyboard="false" >Related Videos</button>
                                    </td>
                                    <td>
                                        <a style="text-decoration:none" href="<?php echo route("newExercise", array('id' => $codes['id'])); ?>" title="Edit">
                                            <div class="fa fa-edit"></div>
                                        </a>


                                        <a style="text-decoration:none; color: #ff0000" href="<?php echo route("deleteExercise", array('id' => $codes['id'])); ?>" title="Delete">
                                            <div class="fa fa-trash-o"></div>
                                        </a>
                                    </td>
                                </tr> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Videos Modal -->
    <div id="videoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Related Videos</h4>
                    <div class="pull-right modal-title">
                        <div id="success-messgae" class="alert alert-success alert-dismissible">

                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table id="videoTable" class="table table-striped table-bordered" cellspacing="0" width="100%">

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
     if (localStorage.getItem('message') == '1' ) {
                                 setTimeout(function () {
                                var element = document.getElementById("success-mesg");
                                element.style.visibility = 'hidden';
                              }, 2000)
                                  localStorage.setItem('message', '');
                              } else {
                                 setTimeout(function () {
                                var element = document.getElementById("success-mesg");
                                element.style.visibility = 'hidden';
                              }, 0)
                              }

    function relatedVideos(excerciseID){
        localStorage.setItem("excerciseID", excerciseID);
        $.ajax({
            type: "GET",
            url: '/relatedVideos/'+excerciseID,
            data: {},
            success: function( msg ) {
                $("#videoModal").modal('show');
                var tt = localStorage.getItem('successs');
                if (tt == null){
                    var temp = document.getElementById("success-messgae");
                    temp.innerHTML = " ";
                    localStorage.removeItem('successs');
                }

               $('#videoTable').DataTable( {
                    data: msg,
                    columns: [
                        { title: "ID" },
                        { title: "Title" },
                        { title: "Arabic Title" },
                        { title: "Description" },
                        { title: "Arebic Description" },
                        { title: "Image" },
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

   function removeExerciseVideo(id) {
       if(confirm('Are you sure !')) {
           $("#videoModal").modal('hide');
           $.ajax({
               type: "GET",
               url: '/removeExerciseVideo/'+id.id,
               data: {},
               success: function( msg ) {
                   var excerciseID = localStorage.getItem("excerciseID");
                   // location.reload();
                   relatedVideos(excerciseID);

                   localStorage.setItem('successs','1');
                   var temp = document.getElementById("success-messgae");
                   temp.innerHTML = "<strong>Success</strong> Record removed..";
               },
               err: function (err) {
                    console.log(err);
               }
           });
       }
   }

   function deleteVideoById(videoId) {
      if(confirm('Are you sure !')) {
           $("#videoModal").modal('hide');
           $.ajax({
               type: "GET",
               url: '/removeExerciseVideo/'+videoId,
               data: {},
               success: function( msg ) {
                  if(msg == -1) {
                    elert('Some thig went wrong..!');
                  } else {
                     var element = document.getElementById("success-mesg");
                     element.style.visibility = 'show';
                      setTimeout(function () {
                        closeMesg();
                      }, 1000);
                  }
               },
               err: function (err) {
                    console.log(err);
               }
           });
       }
   }
   function closeMesg() {
          var a;
          setTimeout(function () {
             location.reload();
            }, 2000);
        }
</script>

@stop