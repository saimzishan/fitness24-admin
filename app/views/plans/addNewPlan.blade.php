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
        <!-- BEGIN PAGE HEADER-->
         <?php
            if (Session::has('message')) {
                echo CommonHelper::generateHtmlAlert(Session::get('message'));
            }
            ?>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Plans <small>Add Plan</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Plans
                            <i class="fa fa-angle-right"></i> </a>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Plans</a>
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
                            <i class="fa fa-globe"></i>Create New Plans
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array( 'name'=>'', 'enctype'=>'multipart/form-data', 'id'=> 'ajax-contact'))}}
                        <div class="form-body">
                            @if (isset($faq))
                                <input type="hidden" readonly name="id" id="planID" value="{{$faq->id}}">
                            @else
                                <input type="hidden" readonly name="id" id="planID" value="-1">
                            @endif
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <div class="input-group" style="width: 100%">
                                                @if(isset($faq) )
                                                    <select disabled name="gender" style="width: 80% "id="gender"  required>
                                                @else
                                                    <select name="gender" style="width: 80% "id="gender" required>
                                                @endif
                                                    <option value="0">--Select--</option>
                                                    @if(isset($faq))
                                                        @if($faq->gender == 1)
                                                            <option selected value="1">Male</option>
                                                        @else
                                                            <option selected value="2">Female</option>
                                                        @endif
                                                    @else
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Level</label>
                                            <div class="input-group" style="width: 100%">
                                                @if(isset($faq))
                                                    <select name="level" disabled style="width: 80%" id="level" required>
                                                 @else
                                                    <select name="level" style="width: 80%" id="level" required>
                                                 @endif
                                                        <option value="0">--Select--</option>
                                                    @if(isset($faq))
                                                        @if($faq->level == 1)
                                                            <option selected value="1">Beginner</option>
                                                        @else
                                                            <option selected value="2">Advance</option>
                                                        @endif
                                                    @else
                                                        <option value="1">Beginner</option>
                                                        <option value="2">Advance</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!isset($faq) )
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No of Weeks</label>
                                                <div class="input-group" style="width: 80%">
                                                    <input type="number" name="number_of_weeks" id="number_of_weeks" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" id="number_of_weeks" class="number_of_weeks" value="{{$faq->number_of_weeks}}">
                                    @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::textarea('description',$faq->description,array('id'=>'description','class'=>'form-control','placeholder'=>'Description')) }}
                                            @else
                                               <textarea id="description" class="form-control" name="description" rows="2"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Description</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::textarea('arabicDescription',$faq->arabicDescription,array('id'=>'arabicDescription','class'=>'form-control','placeholder'=>'Arabic Description')) }}
                                            @else
                                                <textarea id="arabicDescription" class="form-control" name="arabicDescription" rows="2"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="newHtml" style="width: 100%; max-height: 200px; overflow: auto;">
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="margiv-top-10">
                            <input type="button"id="SubmitForm" class="btn green" value="Save">
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select Exercise</h4>
                </div>
                <div class="modal-body">
                    <?php $temp = 0;?>
                    <table id="exerciseTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="hidden">
                               id
                            </th>
                            <th>Select/Un-Select</th>
                            <th>Title</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($ex as $row)
                                <tr>
                                    <td class="hidden"><input type="number" name="dayID" value="{{$row->id}}"></td>
                                    <td>
                                        <input type="checkbox" name="{{$row->id}}" id="assignexercise{{$row->id}}" onchange="assignExercise(this)" value="{{$row->title}}">
                                        {{$row->title}}
                                    </td>
                                    <td>  {{$row->description}}  </td>
                                    <td>
                                        <img src="{{CommonHelper::$driver['s3_uploads'] . 'Images/'.$row->image}}" width="80"/>
                                    </td>
                                </tr>
                                <?php $temp++;?>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="falseCheckbox(<?php echo $temp?>)">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancelBtn(<?php echo $temp?>)">Cancel</button>
                </div>
            </div>

        </div>
    </div>
</div>
    <script>
        $(document).ready(function() {
            $('#exerciseTable').DataTable();
        } );
        var tempArray = [];
        var mainArray = [];
        $("#number_of_weeks").blur(function(event) {
            event.preventDefault();
            var val = document.getElementById("number_of_weeks").value;
            if(val > 0 && val < 52) {
                getNumOfWeek();
            } else {
                message = document.getElementById("newHtml");
                message.innerHTML = ' ' ;
                // alert('Please choice number between 1 to 52');
            }
        });
        function getNumOfWeek() {
            mainArray = [];
            var message = document.getElementById("number_of_weeks").value;
            // message = message * 7 ;

            $.ajax({
                type: "GET",
                url: '/renderHtml/'+message,
                data: {},
                success: function( msg ) {
                    message = document.getElementById("newHtml");
                    message.innerHTML = msg ;
                }
            });
        }
        function assignExercise(event){
            var temp = localStorage.getItem("setID");
            if (event.checked) {
                tempArray.push({exercizeId: event.name ,DayId: temp, value: event.value});
            } else {
                for ( var i = 0; i < tempArray.length; i++ ) {
                    if (tempArray[i].exercizeId === event.name) {
                        // console.log(tempArray[i]);
                        for(var j = 0; j < mainArray.length;  j++) {
                            if( (tempArray[i].DayId === mainArray[j].DayId ) && (tempArray[i].exercizeId === mainArray[j].exercizeId) ) {
                               //  document.getElementById('name'+temp).innerHTML = '';
                                mainArray.splice(j,1);
                            }
                        }
                        tempArray.splice(i, 1);
                    }
                }
            }
        }
        function pickId(event){
            // console.log(event.id);
            if (typeof(Storage) !== "undefined") {
                // Store
                localStorage.setItem("setID", event.id);
                // alert(event.id);
            }
            for (var i = 0; i < mainArray.length; i++) {
                // console.log(mainArray[i] );
                var temp = document.getElementById('assignexercise'+ mainArray[i].exercizeId );
                if (event.id === mainArray[i].DayId) {
                    $('#assignexercise'+mainArray[i].exercizeId).parent().addClass("checked");
                    tempArray.push({exercizeId: mainArray[i].exercizeId ,DayId: mainArray[i].DayId, value: mainArray[i].value});
                }
            }
            // console.log(tempArray);
        }


        function cancelBtn(end) {
            // console.log(tempArray);
             tempArray.forEach(function(entry) {
                $('#assignexercise'+entry.exercizeId).parent().removeClass("checked");
            });
        }
        function falseCheckbox(end) {

           tempArray.forEach(function(entry) {
                $('#assignexercise'+entry.exercizeId).parent().removeClass("checked");
            });

            for (var j = 0; j < tempArray.length; j++) {
                var c = -1;
                for (var i = 0; i < mainArray.length; i++ ) {
                    if( (tempArray[j].DayId === mainArray[i].DayId ) && (tempArray[j].exercizeId === mainArray[i].exercizeId) ) {
                        c = 0;
                    }
                }
                if (c === -1) {
                    mainArray.push({exercizeId: tempArray[j].exercizeId ,DayId: tempArray[j].DayId, value: tempArray[j].value });
                }
            }

            var localVar = localStorage.getItem("setID");
            document.getElementById('name'+localVar).innerHTML = ' ';
            for (var i = 0; i< tempArray.length; i++) {
                document.getElementById('name'+localVar).innerHTML += tempArray[i].value + ',<br>';
            }
            // console.log(mainArray);
            tempArray = [];
        }
        function myFunction(item) {
            $('#'+item).css('border-color', '');
        }
        $("#SubmitForm").click(function(){
            var gender = document.getElementById("gender").value;
            var level = document.getElementById("level").value;
            var number_of_weeks = document.getElementById("number_of_weeks").value;
            var description = document.getElementById("description").value;
            var arabicDescription = document.getElementById("arabicDescription").value;

            if(gender == 0) {
                $('#gender').css('border-color', 'red');
            } else if(level == 0 ) {
                $('#level').css('border-color', 'red');
            } else {
                var id =  document.getElementById("planID").value;
                if(id != -1) {
                    // update Plan
                    mainData = [];
                    var body = JSON.stringify({gender:gender, level: level,arabicDescription: arabicDescription,
                        number_of_weeks: number_of_weeks, description: description, mainData: mainArray
                    })
                    $.ajax({
                        type: "POST",
                        url: '/postPlan/'+id,
                        data: {body: body},
                        dataType: 'json',
                        success: function (msg) {
                            if(msg == 0) {
                                alert('Plan Already Exist');
                            } else {
                                 // console.log(msg);   
                                window.location = '/listAllPlans';
                            }

                        },
                        error: function (data) {
                            console.log(errors);
                        }


                    });
                } else {
                    // ad new plan
                    var body = JSON.stringify({gender:gender, level: level,arabicDescription: arabicDescription,
                        number_of_weeks: number_of_weeks, description: description, mainData: mainArray
                    })

                    $.ajax({
                        type: "POST",
                        url: 'postPlan',
                        data: {body: body},
                        dataType: 'json',
                        success: function (msg) {
                            if(msg == 0) {
                                alert('Plan Already Exist');
                            } else {
                                 window.location = 'listAllPlans';
                            }

                        },
                        error: function (data) {
                            console.log(errors);
                            // Render the errors with js ...
                        }
                    });
                }

            }
        } );
    </script>
@stop