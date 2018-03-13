@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Exception Occured...
                </h3>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
            <div class='alert alert-danger'><strong>Exception: </strong>
                <?php
                if ($exceptionMessage) {
                    echo $exceptionMessage;
                } else {
//                    echo MessageHelper::$error['generalError'];
                }
                ?></div>            
        </div>
    </div>
</script>
@stop
