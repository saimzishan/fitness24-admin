@extends('common_templates.basic_auth_template')
@section('content')
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <!--<form class="login-form" action="index.html" method="post">-->
    {{Form::open(array('route' => 'post_login','class'=>'login-form'))}}
    <h3 class="form-title">Login to your account</h3>
    <?php
    if (Session::has('message')) {
        echo CommonHelper::generateHtmlAlert(Session::get('message'));
    }
    ?>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <!--<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="username"/>-->
            {{ Form::email("email",Input::old("email"),array("id"=>"email", "class"=>"form-control placeholder-no-fix","placeholder"=>"Email",'required'))}}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required/>
            <!--{{ Form::password("password",Input::old("password"),array("id"=>"password","class"=>"form-control placeholder-no-fix","placeholder"=>"Password","required"))}}-->
        </div>
    </div>
    <div style="border:none !important;" class="form-actions">
        <button type="submit" class="btn green pull-right">
            LOGIN <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
</form>
<!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->
@stop