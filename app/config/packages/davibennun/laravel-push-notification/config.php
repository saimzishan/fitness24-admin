<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'development',
        'certificate' =>app_path().'/iosFile/certificate.pem',
        'passPhrase'  =>'push',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'AIzaSyA2g40eNE0NJGJagE0Z1zSpEO_Hso8oAi4',
        'service'     =>'gcm'
    )

);