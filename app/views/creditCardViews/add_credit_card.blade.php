@extends('common_templates.basic_template')
@section('content') 
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Credit Card <small>Add credit card</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">Credit Card</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:;" style="text-decoration: none;">New Credit Card</a>
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
                            <i class="fa fa-globe"></i>Enter Credit Card Information
                        </div>
                    </div>
                    <div class="portlet-body ">
                        {{Form::open(array('route' => 'post_credit_card', 'name'=>'credit_card', 'enctype'=>'multipart/form-data'))}}
                        <div class="form-body">
                            <?php
                            if (Session::has('message')) {
                                echo CommonHelper::generateHtmlAlert(Session::get('message'));
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Credit Card No.</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('credit_card_no',Input::old("credit_card_no"),array('id'=>'credit_card_no','class'=>'form-control','placeholder'=>'Credit Card No.','onkeypress'=>'return isNumber(event)', 'required')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>CVV</label>
                                        <div class="input-group" style="width: 80%">
                                            {{ Form::text('cvv',Input::old("cvc"),array('id'=>'cvc','class'=>'form-control','placeholder'=>'CVV','onkeypress'=>'return isNumber(event)', 'required')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Card Expiry Month</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="expirationMonth" id="expirationMonth" class="form-control">
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Card Expiry Year</label>
                                        <div class="input-group" style="width: 80%">
                                            <select name="expirationYear" id="expirationYear" class="form-control">
                                                <?php
                                                for ($year = 2015; $year < 2015 + 50; $year++) {
                                                    echo '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" class="btn green" value="Save Credit Card">
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
@stop