@extends('common_templates.basic_template')
@section('content')
   
<div class="page-content-wrapper">
    <div class="page-content">
         <?php
            if (Session::has('message')) {
                echo CommonHelper::generateHtmlAlert(Session::get('message'));
            }
            ?>
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Exercise <small>Add Exercise</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Exercise
                            <i class="fa fa-angle-right"></i> </a>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Exercise</a>
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
                            <i class="fa fa-globe"></i>Create New Exercise
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'postExercise', 'name'=>'postExercise', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                                 if (isset($faq)){
                                    ?>
                                    <input type="hidden" readonly name="id" id="exerciseID" value="{{$faq->id}}">
                                    <?php
                                }
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <div class="input-group" style="width: 80%">
                                                <?php if(isset($faq)) { ?>
                                                {{ Form::text('title',$faq->title,array('id'=>'title','class'=>'form-control','placeholder'=>'Title','required', 'rows' => 2)) }}
                                                <?php } else { ?>
                                                {{ Form::text('title',Input::old("title"),array('id'=>'title','class'=>'form-control','placeholder'=>'Title','required', 'rows' => 2)) }}
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <div class="input-group" style="width: 80%">
                                                <?php if(isset($faq)) { ?>
                                                {{ Form::textarea('description',$faq->description,array('id'=>'description','class'=>'form-control','placeholder'=>'Description', 'rows' => 2)) }}
                                                <?php } else { ?>
                                                {{ Form::textarea('description',Input::old("description"),array('id'=>'description','class'=>'form-control','placeholder'=>'Description', 'rows' => 2)) }}
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Title</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::text('arabicTitle',$faq->arabicTitle,array('id'=>'arabicTitle','class'=>'form-control','placeholder'=>'Arabic Title','required')) }}
                                            @else
                                                {{ Form::text('arabicTitle',Input::old("arabicTitle"),array('id'=>'arabicTitle','class'=>'form-control','placeholder'=>'Arabic Title','required')) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Description</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::textarea('arabicDescription',$faq->arabicDescription,array('id'=>'arabicDescription','class'=>'form-control','placeholder'=>'Arabic Description','rows' => 2 )) }}
                                            @else
                                                {{ Form::textarea('arabicDescription',Input::old("arabicDescription"),array('id'=>'arabicDescription','class'=>'form-control','placeholder'=>'Arabic Description', 'rows' => 2 )) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Duration</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::text('duration',$faq->duration,array('id'=>'duration','class'=>'form-control','placeholder'=>'Duration')) }}
                                            @else
                                                {{ Form::text('duration',Input::old("duration"),array('id'=>'duration','class'=>'form-control','placeholder'=>'Duration',)) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Workout Time</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::text('workoutTime',$faq->workout_time,array('id'=>'workoutTime','class'=>'form-control','placeholder'=>'Workout Time')) }}
                                            @else
                                                {{ Form::text('workoutTime',Input::old("workoutTime"),array('id'=>'workoutTime','class'=>'form-control','placeholder'=>'Duration',)) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if(!isset($faq) )
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upload Image</label>
                                            <div class="input-group" style="width: 80%">
                                                <label class="btn btn-default btn-block">
                                                     <input type="file" id="files" name="file">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(!isset($faq) )
                                    <div class="col-md-12">
                                    <label>Select Video(s)</label>
                                    <table id="videoTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="hidden">id</th>
                                            <th>Select/Un-Select</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($videos as $row)
                                                <tr>
                                                    <td class="hidden">
                                                        {{$row->id}}
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="videoCheckbox" id="{{$row->id}}">
                                                    </td>
                                                    <td>
                                                       {{$row->title_en}}
                                                    </td>
                                                    <td>
                                                        <img src="{{CommonHelper::$driver['s3_uploads'] . 'Images/'.$row->thumb}}" width="80"/>
                                                    </td>
                                                </tr>
                                             @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                @endif
                            </div>
                            <div class="margiv-top-10">
                                @if(!isset($faq) )
                                    <input type="button" id="SubmitForm" class="btn green" value="Save">
                                @else
                                    <input type="button" id="updateForm" class="btn green" value="Update">
                                @endif
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
    $(document).ready(function() {
        $('#videoTable').DataTable();
    } );

    var fileTag = document.getElementById("files");
    var fileData = null;
    fileTag.addEventListener("change", function() {
        changeImage(this);
    });
    function changeImage(input) {
        var reader;

        if (input.files && input.files[0]) {
            reader = new FileReader();

            reader.onload = function(e) {
               // preview.setAttribute('src', e.target.result);
                fileData = e.target.result;
                //console.log(fileData);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }



    document.getElementById("title").onfocus = function() {myFunction('title')};
    document.getElementById("description").onfocus = function() {myFunction('description')};
    document.getElementById("duration").onfocus = function() {myFunction('duration')};
    document.getElementById("workoutTime").onfocus = function() {myFunction('workoutTime')};

    function myFunction(item) {
        $('#'+item).css('border-color', '');
    }

    $("#SubmitForm").click(function() {

        // console.log(checkedValue);
        var title = document.getElementById("title").value;
        var description = document.getElementById("description").value;
        var arabicTitle = document.getElementById("arabicTitle").value;
        var arabicDescription = document.getElementById("arabicDescription").value;
        var duration = document.getElementById("duration").value;
        var workoutTime = document.getElementById("workoutTime").value;
        var file = fileData;
        //  alert(description);
        if(!title) {
            $('#title').css('border-color', 'red');
        } else if(!workoutTime ) {
            $('#workoutTime').css('border-color', 'red');
        }else if(!duration ) {
            $('#duration').css('border-color', 'red');
        } else {
            var checkedValue = [];
            var inputElements = document.getElementsByClassName('videoCheckbox');
            for (var i = 0; i< inputElements.length; ++i) {
                if (inputElements[i].checked) {
                    checkedValue.push(inputElements[i].id);
                }
            }

            var body = JSON.stringify({title:title, description: description,arabicTitle: arabicTitle,
                file: file,arabicDescription: arabicDescription, duration: duration, workoutTime: workoutTime,  exerciseIDs: checkedValue
            })
            $.ajax({
                type: "POST",
                url: 'postExercise',
                data: {body: body},
                dataType: 'json',
                success: function( msg ) {
                   // console.log(msg);
                    window.location = "listAllExercise"
                },
                error: function(data){
                    console.log(errors);
                    // Render the errors with js ...
                }
            });
        }
    } );


    // on update updateForm

    $("#updateForm").click(function() {
        var title = document.getElementById("title").value;
        var description = document.getElementById("description").value;
        var arabicTitle = document.getElementById("arabicTitle").value;
        var arabicDescription = document.getElementById("arabicDescription").value;
        var duration = document.getElementById("duration").value;
        var workoutTime = document.getElementById("workoutTime").value;
        var file = '';
        var exerciseID = document.getElementById("exerciseID").value;
        //  alert(description);
        if(!title) {
            $('#title').css('border-color', 'red');
        } else if(!workoutTime ) {
            $('#workoutTime').css('border-color', 'red');
        }else if(!duration ) {
            $('#duration').css('border-color', 'red');
        } else {
            var checkedValue = [];
            var inputElements = document.getElementsByClassName('videoCheckbox');
            for (var i = 0; i< inputElements.length; ++i) {
                if (inputElements[i].checked) {
                    checkedValue.push(inputElements[i].id);
                }
            }

            var body = JSON.stringify({title:title, description: description,arabicTitle: arabicTitle,
                file: file,arabicDescription: arabicDescription, duration: duration, workoutTime: workoutTime,  exerciseIDs: checkedValue
            })
            $.ajax({
                type: "POST",
                url: '/postExercise/'+exerciseID,
                data: {body: body},
                dataType: 'json',
                success: function( msg ) {
                    window.location = "/listAllExercise/";
                },
                error: function(data){
                    console.log(errors);
                    // Render the errors with js ...
                }
            });
        }
    } );

</script>
@stop