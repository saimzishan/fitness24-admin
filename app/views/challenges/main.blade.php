@extends('common_templates.basic_template')
@section('content')
<style type="text/css">
     #loading {
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
        text-align: center;
    }

    #loading-image {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 100;
    }
    .modal-dialog {
            width: 75%;
            margin: 2% auto;
        }
</style>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
<div id="loading" >
    <img id="loading-image" src="http://cdn.nirmaltv.com/images/generatorphp-thumb.gif" alt="Loading..." />
</div> -->

<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Challenges <small>All Challenges List</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">Challenges</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration:none">All Challenges</a>
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
                            <i class="icon-users"></i>All Challenges
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if (Session::has('message')) {
                            echo CommonHelper::generateHtmlAlert(Session::get('message'));
                        }
                        ?>

                          <div class="table-toolbar">
                            <a style="text-decoration:none" href="<?php echo route("newChallenges"); ?>">
                              <div class="btn-group">
                                  <button id="sample_editable_1_new" class="btn green">
                                      Add New Challange <i class="fa fa-plus"></i>
                                  </button>
                              </div>
                            </a>
                          </div>
                            <div class="container">  
                                 <div class="row well">
                                      <div class="col-md-1">ID</div>  
                                      <div class="col-md-2">Name</div>  
                                      <div class="col-md-2">No Of Levels</div>  
                                      <div class="col-md-2">Created at</div>  
                                      <div class="col-md-2">Levels</div>  
                                      <div class="col-md-1">Action</div>  
                                    
                                </div>
                                @foreach($plansWithdays as $ke => $codes)
                                    <div class="row" style="padding: 10px; background-color: #B0BEC5">
                                      <div class="col-md-1"> <?php echo $codes['id']; ?></div>  
                                      <div class="col-md-2"><?php echo $codes['Name']; ?></div>  
                                      <div class="col-md-2"><?php echo $codes['No_Of_Levels'];?></div>  
                                      <div class="col-md-2"> <?php echo $codes['created_at']; ?></div>  
                                      <div class="col-md-2">
                                           <button style="color:eeeeee ;background-color:#eeeeee class="btn btn-xs btn-info" data-toggle="collapse" data-target="#videoColaps{{ $codes['id']}}">
                                                <span class="fa fa-angle-down"></span>
                                            </button>
                                      </div>
                                      <div class="col-md-1">
                                        <a type="btn btn-info" onclick="showUpdateChallengesModel({{$codes['id']}}, {{$codes['No_Of_Levels']}} )">
                                          <i class="fa fa-edit"></i>
                                        </a>|
                                        <a onclick="return confirm('Are you sure you want to delete this challeng Level?');" href="<?php echo route("deleteChallenge", array('id' => $codes['id'])); ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> </a>
                                      </div>
                                      <div class="col-md-2" style="font-weight: 600 !important;"> Challeng {{$ke + 1}} </div>
                                              
                                                </div> 
                                    <div class="container-fluid">
                                      <div id="videoColaps{{$codes['id']}}" class="collapse">  
                                         <div class="row well">
                                              <div class="col-md-1">ID</div>  
                                              <div class="col-md-1">challenge</div>  
                                              <div class="col-md-1">level</div>  
                                              <div class="col-md-1">Days</div>  
                                              <div class="col-md-2">Created at</div>    
                                              <div class="col-md-1">Days</div>
                                              <div class="col-md-1">Action</div>
                                            </div>
                                            @foreach($codes->Levels as $key => $row)
                                             <div class="row" style="padding: 10px; background-color: #CFD8DC; margin-top: 10px">
                                                 <div class="col-md-1"> <?php echo $row['id']; ?></div>  
                                                  <div class="col-md-2" hidden="true"><?php echo $row['challengeID'];  ?></div>  
                                                  <div class="col-md-1"><?php echo $codes['Name'];  ?></div>  
                                                  <div class="col-md-1"><?php echo $row['level'];?></div>  
                                                  <div class="col-md-1"> <?php echo $row['No_Of_Days']; ?></div>
                                                  <div class="col-md-2"> <?php echo $row['created_at']; ?></div> 
                                                  <div class="col-md-1"> 
                                                        <button style="color:eeeeee ;background-color:#eeeeee class="btn btn-xs btn-info" data-toggle="collapse" data-target="#Challengelevelday{{ $row['id']}}">
                                                            <span class="fa fa-angle-down"></span>
                                                        </button>
                                                    </div> 
                                                <div class="col-md-2">
                                                  <a  onclick="openModel({{$row['id']}}, {{$row['challengeID']}})" class="btn btn-xs btn-info"><i class="fa fa-plus-square"></i> </a> |
                                                
                                                  <a onclick="return confirm('Are you sure you want to delete this challeng?');" href="<?php echo route("deleteChallengeLevel", array('id' => $row['id'])); ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> </a>
                                                </div>
                                                <div class="col-md-2" style="font-weight: 600 !important;"> Challeng {{$ke + 1}} / Level {{$key+1}}</div>
                                              </div>

                                               <div class="container-fluid" style="">
                                                 
                                                 <div id="Challengelevelday{{$row['id']}}" class="collapse">
                                                  
                                                     <!-- header EEEEEE -->
                                                    <div class="row well">
                                                      <div class="col-md-1">Id</div>  
                                                      <div class="col-md-1">Level ID</div>  
                                                      <div class="col-md-1">DaySeq</div>  
                                                      <div class="col-md-1">Sets</div>
                                                        <div class="col-md-2">Repetition</div>  
                                                        <div class="col-md-2">created_at</div>
                                                        <div class="col-md-2">Action</div>
                                                    </div>
                                                   @foreach($row->Challengelevelday as $k => $r)
                                                    <div class="row" style="padding: 1%; background-color: #B0BEC5">
                                                      <div class="col-md-1"> <?php echo $r['id']; ?></div>  
                                                      <div class="col-md-1"><?php echo $r['challengeLevelID']; ?></div>  
                                                      <div class="col-md-1"><?php echo $r['DaySeq'];?></div>  
                                                      <div class="col-md-1"> <?php echo $r['No_of_Sets']; ?></div>
                                                      <div class="col-md-2"> <?php echo $r['Repetition']; ?></div>
                                                      <div class="col-md-2"> <?php echo $r['created_at']; ?></div>
                                                      
                                                         <div class="col-md-2"><button onclick="daySetModal({{$r['id']}}, {{$row['id']}}, {{$codes['id']}})" class="btn btn-xs btn-info"><i class="fa fa-plus-square"></i></button> |
                                                           <a type="btn btn-info" onclick="openChallengesDaysModel({{$r['id']}},{{ $r['No_of_Sets']}} ,{{ $r['Repetition']}},{{$row['id']}}, {{$codes['id']}})">
                                                            <i class="fa fa-edit"></i>
                                                          </a>|
                                                         <a onclick="return confirm('Are you sure you want to delete this challeng Level Day?');" href="<?php echo route("deleteChallengeLevelDays", array('id' => $r['id'])); ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> </a>
                                                         </div>
                                                          <div class="col-md-2" style="font-weight: 600 !important;">Level {{$key+1}} / Day {{$k+1}}</div>

                                                      
                                                    </div>
                                                    <br>
                                                   @endforeach
                                                 </div>
                                                </div>
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                    <br>
                                @endforeach   
                            </div>
                        <!-- <table id="example" class="display" width="100%"></table> -->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
         <!-- Related Videos Modal -->
    <div id="levelModal" class="modal fade" role="dialog">
         <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Add Days</h4>
        </div>
        <div class="modal-body">
         <form method="post" action="{{route('postChallengesTolavel')}}" id='ajax-contact'>
          <input type="hidden" name="challgId" id ='challgId'>
          <input type="hidden" name="" value="{{csrf_token()}}">
            <div class="form-group">
                <label>Number of Day</label>
                <div class="input-group" style="width: 50%">
                  <input type="number" min="1" name="No_Of_Days" id="No_Of_Days" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Sets</label>
                <div class="input-group" style="width: 50%">
                  <input type="number" min="1" name="No_of_Sets" id="No_of_Sets" class="form-control">
                </div>
            </div>
         </form>  
        </div>
        <div class="modal-footer">
            <input type="submit" id="SubmitForm" class="btn green" value="Save">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>

    </div> 

     <div id="daySetModal" class="modal fade" role="dialog">
         <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Add Repetition</h4>
        </div>
        <div class="modal-body">
         <form method="post" action="{{route('postSetsTolavelday')}}" id='ajax-contacts'>
          <input type="hidden" name="dayID" id ='dayID'>
          <input type="hidden" name="" value="{{csrf_token()}}">
            <div class="form-group">
                <label>Number Repetition</label>
                <div class="input-group" style="width: 50%">
                  <input type="number" min="1" name="Repetition" id="Repetition" class="form-control">
                </div>
            </div>
         </form>  
        </div>
        <div class="modal-footer">
            <input type="submit" id="Repetitions" class="btn green" value="Save">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>

    </div>

    <!-- update Challenges Model -->
      <div id="updateChallengesModel" class="modal fade" role="dialog">
         <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Updating no of levels</h4>
        </div>
        <div class="modal-body">
         <form method="post" action="{{route('updateChallenge')}}" id='ajax-contactss'>
          <input type="hidden" name="challengeID" id ='challengeID'>
          <input type="hidden" name="" value="{{csrf_token()}}">
            <div class="form-group">
                <label>Number of levels</label>
                <div class="input-group" style="width: 50%">
                  <input type="number" name="No_Of_Levels" id="No_Of_LevelsOld" min="1" class="form-control">
                </div>
            </div>
         </form>  
        </div>
        <div class="modal-footer">
            <input type="submit" id="No_Of_Levelsss" class="btn green" value="Save">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>

    </div>
    <!-- update Challenges Model -->
      <!-- update Challenges days Model -->
      <div id="updateChallengesDays" class="modal fade" role="dialog">
         <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Updating</h4>
        </div>
        <div class="modal-body">
         <form method="post" action="{{route('updateChallengeLevelDays')}}" id='updateChallengesdays'>
          <input type="hidden" name="id" id ='challengeDayID'>
          <input type="hidden" name="" value="{{csrf_token()}}">
            <div class="form-group">
                <label>Number of Sets</label>
                <div class="input-group" style="width: 50%">
                  <input type="number" name="No_of_Sets" id="No_of_SetsOld" min="1" class="form-control">
                </div>
            </div>
              <div class="form-group">
                  <label>Number of Repetition</label>
                  <div class="input-group" style="width: 50%">
                    <input type="number" name="Repetition" id="RepetitionOld" min="1" class="form-control">
                  </div>
              </div>
         </form>  
        </div>
        <div class="modal-footer">
            <input type="submit" id="updateDayNRep" class="btn green" value="Save">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>

    </div>
    <!-- update Challenges Model -->


    </div>

<script>
  function openModel(id, pId) {
        localStorage.setItem('videoColaps' ,pId);
   document.getElementById("challgId").value = id;
    $('#levelModal').modal('show')
  }
  function daySetModal(id, p1id , p2id) {
     localStorage.setItem('videoColaps' ,p2id);
        localStorage.setItem('Challengelevelday' ,p1id);
   document.getElementById("dayID").value = id;
    $('#daySetModal').modal('show')
  }

   function openChallengesDaysModel(id, oldS, oldR, p1id , p2id) {
   document.getElementById("challengeDayID").value = id;

   document.getElementById("No_of_SetsOld").value = oldS;
   document.getElementById("RepetitionOld").value = oldR;

    localStorage.setItem('videoColaps' ,p2id);
        localStorage.setItem('Challengelevelday' ,p1id);
    $('#updateChallengesDays').modal('show')
  }

  let globelVar = -1;
   function showUpdateChallengesModel(id, oldVal) {
   document.getElementById("challengeID").value = id;
   document.getElementById("No_Of_LevelsOld").value = oldVal;
   globelVar = oldVal;
    localStorage.setItem('videoColaps' ,id);
    $('#updateChallengesModel').modal('show')
    }
   

         $("#SubmitForm").click(function() {
            var form = document.getElementById("ajax-contact");
             
            form.submit();
        } );
         $("#Repetitions").click(function(){
            var form = document.getElementById("ajax-contacts");
             
            form.submit();
        } );
          $("#updateDayNRep").click(function(){
            var form = document.getElementById("updateChallengesdays");
             
            form.submit();
        } );
          // <!-- update Challenges submit -->
    $("#No_Of_Levelsss").click(function(){
            var form = $("#ajax-contactss").serializeArray();
             var forms = document.getElementById("ajax-contactss");
            if(globelVar > form[1].value ) {
              alert('The value of level should be greterthen old ('+globelVar+') value');
              return;
            }
            forms.submit();
        } );


    $(document).ready(function () {
      if(localStorage.getItem('videoColaps') ) {
        $('#videoColaps'+localStorage.getItem('videoColaps')).addClass('in');
        localStorage.removeItem('videoColaps');
      }
      if(localStorage.getItem('Challengelevelday')) {
          $('#Challengelevelday'+localStorage.getItem('Challengelevelday')).addClass('in');
        localStorage.removeItem('Challengelevelday');
      }
       // $('#videoColaps1').addClass('in'); 
       // $('#Challengelevelday1').addClass('in'); 
        var table = $('#sample_1');
        // begin first table
        table.dataTable({
            "columns": [{
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": false
                }],
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "pagingType": "bootstrap_full_number",
            "language": {
                "lengthMenu": "_MENU_ records",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{// set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });
        // showAllChallenge();
    });
   // http://c6843538.ngrok.io/showAllChallenge

   
</script>
@stop