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
                    Challanges <small>Add Challange</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Challange
                            <i class="fa fa-angle-right"></i> </a>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Challange</a>
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
                            <i class="fa fa-globe"></i>Create New Challange
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'postChallenges', 'name'=>'postFaq', 'enctype'=>'multipart/form-data', 'id'=> 'ajax-contact'))}}
                        <div class="form-body">
                            @if (isset($faq))
                                <input type="hidden" readonly name="id" id="planID" value="{{$faq->id}}">
                            @else
                                <input type="hidden" readonly name="id" id="planID" value="-1">
                            @endif
                             <div class="col-md-12">
                             
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Challenge Name</label>
                                            <div class="input-group" style="width: 100%">
                                             <select name="challengeId" id="challengeName" style="width: 80%; height: 31px;"  required>
                                                 @foreach($cNames['name'] as $ke => $row)
                                                      @if($cNames['default'] === $ke)
                                                        <option selected value="{{$ke}}">{{$row}}</option>
                                                      @else  
                                                        <option value="{{$ke}}">{{$row}}</option>
                                                      @endif  
                                                 @endforeach   
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                @if(!isset($faq) )
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No of Levels</label>
                                            <div class="input-group" style="width: 80%">
                                                <input type="number" name="No_Of_Levels" id="No_Of_Levels" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <input type="hidden" id="No_Of_Levels" class="No_Of_Levels" value="{{$faq->No_Of_Levels}}">
                                @endif
                                <div class="col-md-12">
                                    <div id="newHtml" style="width: 100%; max-height: 200px; overflow: auto;">
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="margiv-top-10">
                            <input type="submit" id="SubmitForm" class="btn green" value="Save">
                        </div>
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
            $('#exerciseTable').DataTable();
        } );
        var tempArray = [];
        var mainArray = [];
        // $("#No_Of_Levels").blur(function(event) {
        //     event.preventDefault();
        //     var val = document.getElementById("No_Of_Levels").value;
        //     if(val > 0) {
        //         getNumOfLevel();
        //     } else {
        //         message = document.getElementById("newHtml");
        //         message.innerHTML = ' ' ;
        //         // alert('Please choice number between 1 to 52');
        //     }
        // });
        function getNumOfLevel() {
            mainArray = [];
            var message = document.getElementById("No_Of_Levels").value;
            var chlId = document.getElementById("challengeName").value;
            if (chlId == 0) {
                alert('Please select any Challange before');
                 message = document.getElementById("newHtml");
                    message.innerHTML = ' ' ;
                return;
            }
            $.ajax({
                type: "GET",
                url: '/renderNewHtml/' + message +'/' + chlId,
                data: {},
                success: function( msg ) {
                    message = document.getElementById("newHtml");
                    message.innerHTML = msg ;
                }
            });
        }
        $("#SubmitForm").click(function(){
            var form = document.getElementById("ajax-contact");
              var chlId = document.getElementById("challengeName").value;
                if (chlId == 0) { alert('Please select any Challange before');
                    message = document.getElementById("newHtml");
                    message.innerHTML = ' ' ;
                    return;
                }
            form.submit();
        } );
    </script>
@stop