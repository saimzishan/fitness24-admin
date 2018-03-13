
<link href="<?php echo url(); ?>/assets/cropper-master/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo url(); ?>/assets/cropper-master/dist/cropper.css" rel="stylesheet">
<link href="<?php echo url(); ?>/assets/cropper-master/demo/css/main.css" rel="stylesheet">

<div class="cropShadow">
    <div class="CalcMid" style=" margin: 48px 0 0 0;">
        <h3 class="head"> Crop User Image </h3>
        <div class="img-container">  
            <img src="<?php echo $url; ?>" alt="Picture">                   
        </div>
        <button class="btn btn-success" data-method="zoom" data-option="0.1" type="button" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
                <span class="zoom" >Zoom In +</span>
            </span>
        </button>
        <button class="btn btn-success" data-method="zoom" data-option="-0.1" type="button" >
            <span class="docs-tooltip" data-toggle="tooltip" >
                <span class="zoom" >Zoom Out -</span>
            </span>
        </button>   
        <button class="btn btn-success" data-method="getData" data-option="" data-target="#putData" type="button">
            <span class="docs-tooltip" data-toggle="tooltip">
                Crop Image
            </span>
        </button>
        <button class="btn btn-danger"  onclick="del('<?php echo $name; ?>')" type="button">
            <span class="docs-tooltip" data-toggle="">
                Close
            </span>
        </button>
        <br>
    </div>
</div>

<script src="<?php echo url(); ?>/assets/cropper-master/assets/js/jquery.min.js"></script>
<script src="<?php echo url(); ?>/assets/cropper-master/assets/js/bootstrap.min.js"></script>
<script src="<?php echo url(); ?>/assets/cropper-master/dist/cropper.js"></script>
<script src="<?php echo url(); ?>/assets/cropper-master/demo/js/mainUser.js"></script>

<style>
    .img-container {
        float:left; width:100%;
    }
    .btn-success{
        margin-right: 4px;
    }
    .zoom{
        font-size: 15px!important;
    }
    .cropShadow {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
        float: left;
        height: 100%;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 2147483647;
    }

    .head {
        color: white;
        font-weight: bold;
        margin-left: 20px;
        font-size: 30px;
    }
</style>