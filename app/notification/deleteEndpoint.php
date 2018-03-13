<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define(SNSKEY, 'AKIAIV32IXXTAP4DWVBQ');
define(SNSSECRT, 'x6NdRgEtqgF594yWfiBGAsYxfnWlV/TOax9200v9');
define(AppArnIOS, 'arn:aws:sns:us-west-2:046164549220:app/APNS/UAE-BARQ-iOS');
define(AppArnAndroid, 'arn:aws:sns:us-west-2:046164549220:app/GCM/UAE-BARQ-Android');


require ('aws-autoloader.php');

use Aws\Sns\SnsClient;

$sns = SnsClient::factory(array(
            'credentials' => array(
                'key' => SNSKEY,
                'secret' => SNSSECRT),
            'region' => 'us-west-2',
            'version' => 'latest'
        ));

getEndPointByApp(AppArnIOS);

function getEndPointByApp($appARN, $NextToken = null) {
    global $sns;

    $result = $sns->listEndpointsByPlatformApplication(array(
        // PlatformApplicationArn is required
        'PlatformApplicationArn' => $appARN,
        'NextToken' => $NextToken,
    ));
    $myClassReflection = new ReflectionClass(get_class($result));
    $secret = $myClassReflection->getProperty('data');
    $secret->setAccessible(true);
    
    
}
