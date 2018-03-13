<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Application Debug Mode
      |--------------------------------------------------------------------------
      |
      | When your application is in debug mode, detailed error messages with
      | stack traces will be shown on every error that occurs within your
      | application. If disabled, a simple generic error page is shown.
      |
     */ 

//	's3_url' => 'https://s3.amazonaws.com/gravel-web/',
    //'storage' => '../Admin/local/app/storage/',
    'storage' => storage_path() . '/',
    // 'storage_url' => storage_path().'/',
    //'storage_url' => 'http://52.88.190.40/gravel-web/',
    'storage_url' => 'http://localhost/gravel/gravel-web/app/storage/',
);
