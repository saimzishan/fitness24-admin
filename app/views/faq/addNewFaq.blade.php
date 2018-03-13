@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    FAQ <small>Add FAQ</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">FAQ
                            <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New FAQ</a>
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
                            <i class="fa fa-globe"></i>Create New FAQ
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'postFaq', 'name'=>'postFaq', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return validateForm()'))}}
                        <div class="form-body">
                            <?php
                                 if (isset($faq)){
                                    ?>
                                    <input type="hidden" readonly name="id" value="{{$faq->id}}">
                                    <?php
                                }
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <div class="input-group" style="width: 100%">
                                            <select name="category_id" style="width: 80%" id="category_id" required>
                                                <?php foreach ($categories as $key => $value) { ?>
                                                @if(isset($faq))
                                                    @if ($faq->catID === $value['id'] )
                                                        <option selected value="{{$value['id']}}">{{$value['title']}}</option>
                                                     @else
                                                        <option value="{{$value['id']}}">{{$value['title']}}</option>
                                                        @endif
                                                @else
                                                   <option value="{{$value['id']}}">{{$value['title']}}</option>
                                                @endif
                                                    <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Question</label>
                                            <div class="input-group" style="width: 80%">
                                                <?php if(isset($faq)) { ?>
                                                {{ Form::textarea('question',$faq->Question,Input::old("question"),array('id'=>'question','class'=>'form-control','placeholder'=>'Question','required', 'rows' => 2)) }}
                                                <?php } else { ?>
                                                {{ Form::textarea('question',Input::old("question"),array('id'=>'question','class'=>'form-control','placeholder'=>'Question','required')) }}
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Arabic Question</label>
                                            <div class="input-group" style="width: 80%">
                                                <?php if(isset($faq)) { ?>
                                                {{ Form::textarea('arabicQuestion',$faq->arabicQuestion,Input::old("arabicQuestion"),array('id'=>'arabicQuestion','class'=>'form-control','placeholder'=>'Arabic Question')) }}
                                                <?php } else { ?>
                                                {{ Form::textarea('arabicQuestion',Input::old("arabicQuestion"),array('id'=>'arabicQuestion','class'=>'form-control','placeholder'=>'Arabic Question')) }}
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Answer</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::textarea('ans',$faq->Answer,Input::old("ans"),array('id'=>'ans','class'=>'form-control','placeholder'=>'Answer','required')) }}
                                            @else
                                                {{ Form::textarea('ans',Input::old("ans"),array('id'=>'ans','class'=>'form-control','placeholder'=>'Answer','required')) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Answer</label>
                                        <div class="input-group" style="width: 80%">
                                            @if(isset($faq) )
                                                {{ Form::textarea('arabicAnswer',$faq->arabicAnswer,Input::old("arabicAnswer"),array('id'=>'arabicAnswer','class'=>'form-control','placeholder'=>'Arabic Answer')) }}
                                            @else
                                                {{ Form::textarea('arabicAnswer',Input::old("arabicAnswer"),array('id'=>'arabicAnswer','class'=>'form-control','placeholder'=>'Arabic Answer')) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Save">
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
        $('#expiry_date').datepicker({
            dateFormat: 'yy-mm-dd',
            onClose: function (selectedDate) {
                // Set The min date for valid to
                $("#expiry_date").datepicker("option", "minDate", selectedDate);
            }
        });


        var route_url = '<?php echo route("select_city") ?>';
        $(document).on('change', "#users-state", function () {

            var state = $(this).attr('value');
            $.ajax({
                type: "POST",
                data: {state: state},
                url: route_url,
                success: function (data) {
                    $("#city").html('');
                    $("#city").html(data);
                }
            });
        });


        var route_url1 = '<?php echo route("select_email") ?>';
        $(document).on('change', "#send_to", function () {
            var user_id = $(this).attr('value');
            $.ajax({
                type: "POST",
                data: {user_id: user_id},
                url: route_url1,
                success: function (data) {
                    $("#email").html('');
                    $("#city").html('');
                    $("#email").html(data);
                }
            });
        });


    });

    function validateForm() {
        var x = document.forms["post_promo_code"]["send_to"].value;
        if (x == 0) {
//            apprise("Profile Image must be Selected");
            $.alert({
                title: 'No user!',
                content: 'Please select a User',
                confirmButton: 'Ok',
                confirmButtonClass: 'btn btn-success',
                columnClass: 'col-md-4 col-md-offset-4',
                animation: 'zoom'
            });
            return false;
        }
    }
</script>
@stop