<?php
namespace App\notification;
use ReflectionClass;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
define('SNSKEY', 'AKIAIKDL2BCEPJIMTHHQ');
define('SNSSECRT', '0cvOONEFht2JQS7DZnFJ0NN9QMRYvWl2SxULvgLI');
define('AppArnIOS', 'arn:aws:sns:us-west-2:046164549220:app/APNS_SANDBOX/Fitness24-IOS');
define('AppArnAndroid', 'arn:aws:sns:us-west-2:046164549220:app/GCM/Fitness24-Android');
require ('aws-autoloader.php');
use Aws\Sns\SnsClient;
// Create a new Amazon SNS client
$sns = SnsClient::factory(array(
            'credentials' => array(
                'key' => SNSKEY,
                'secret' => SNSSECRT),
            'region' => 'us-west-2',
            'version' => 'latest'
        ));
class SNSNoti {
    public static function getArn($array) {
        if (strlen($array) > 64) {
            $appArn = AppArnAndroid;
        } else {
            $appArn = AppArnIOS;
        }

        return $appArn;
    }
    public static function getSns()
    {
        $sns = SnsClient::factory(array(
            'credentials' => array(
                'key' => SNSKEY,
                'secret' => SNSSECRT),
            'region' => 'us-west-2',
            'version' => 'latest',
        ));
        return $sns;
    }
    public static function addEndPoint($array) {
        global $sns, $connection;
        $appArn = SNSNoti::getArn($array);
        $sns = SNSNoti::getSns();
        $result = $sns->createPlatformEndpoint(array(
            'PlatformApplicationArn' => $appArn,
            'Token' => $array));
        $myClassReflection = new ReflectionClass(get_class($result));
        $secret = $myClassReflection->getProperty('data');
        $secret->setAccessible(true);
        $ok = $secret->getValue($result);
        $EndpointArn =$ok['EndpointArn'];              
        return $EndpointArn;
    }

    public static function addEndPointToTopic($array, $arn) {
        global $sns, $connection;
        $sns = SNSNoti::getSns();
        $result = $sns->subscribe(array(
            'TopicArn' => $array,
            'Protocol' => 'application',
            'Endpoint' => $arn
        ));
        //return $result;
###########OSMAN CODE below ####################            
        $myClassReflection = new ReflectionClass(get_class($result));
        $secret = $myClassReflection->getProperty('data');
        $secret->setAccessible(true);
        $ok = $secret->getValue($result);

        $SubArn = $ok['SubscriptionArn'];


        return $SubArn;
    }

    function getEndPointAppList($array, $nextToken = null) {
        global $sns;

        list($appArn, $table) = $this->getArn($array);
        $result = $sns->listEndpointsByPlatformApplication(array(
            'PlatformApplicationArn' => $appArn,
            'NextToken' => $nextToken,
        ));

        return $result;
    }
    public static function pushNoti($array, $messages) {
        global $sns;
        //en_baundle_tonse
        $AppArn = $array;
         $sns = SNSNoti::getSns();
        $message = SNSNoti::generateMsg(['cat' => $array, 'message' => $messages, 'url' => '']);
        $sns->publish(['Message' => $message,
            'TargetArn' => $AppArn,
            'MessageStructure' => 'json']);
    }
    public static function generateMsg($array) {
        $jsonMessage=json_decode($array['message'], true);
        $jsonMessage['message'] = trim(str_replace('"', "'", $jsonMessage['message']));
        $jsonMessage['message'] = json_encode(substr($jsonMessage['message'], 0, 75));
        $jsonMessage['message'] = substr($jsonMessage['message'], 1);
        $jsonMessage['message'] = substr($jsonMessage['message'], 0, -1);
        $jsonMessage['message'] = trim(str_replace(array('\n', '\r'), ' ', $jsonMessage['message']));
        $message = '{ 
        "default":"'.$jsonMessage['message'].'", "APNS_SANDBOX":"{\"aps\":{\"alert\": \"' . $jsonMessage['message'] . '\",';
        if (!empty($array['url'])) {
            $message.='\"url\":\"' . $array['url'] . '\",';
        }
        $message.='\"badge\":1,';
        if ($array['cat'] == 'GENERAL') {
            $message.='\"CAT\":\"GENERAL\",';
        } else {
            $message.='\"CAT\":\"' . $array['cat'] . '\",';
        }
         if(array_key_exists('video_id', $jsonMessage) && array_key_exists('video_type', $jsonMessage) )
        {
            
                $message.='\"sound\":\"' . SNSNoti::genarateSound($array['cat']) . '\",\"video_id\": \"' . $jsonMessage['video_id'] . '\",\"video_type\": \"' . $jsonMessage['video_type'] . '\",\"type\": \"' . $jsonMessage['type'] . '\"}}","GCM":"{\"data\":{\"message\":\"'  . $jsonMessage['message'] . '\",\"video_id\": \"' . $jsonMessage['video_id'] . '\",\"video_type\": \"' . $jsonMessage['video_type'] . '\",\"type\": \"' . $jsonMessage['type'] . '\",';    
        }
        else
        {
            $message.='\"sound\":\"' . SNSNoti::genarateSound($array['cat']) . '\",\"type\": \"' . $jsonMessage['type'] . '\"}}","GCM":"{\"data\":{\"message\":\"'  . $jsonMessage['message'] . '\",\"type\": \"' . $jsonMessage['type'] . '\",';
        }
        if (!empty($array['url'])) {
            $message.='\"url\":\"' . $array['url'] . '\",';
        }
        $message.='\"CAT\":\"' . $array['cat'] . '\"}}"'
                . '}';
        //echo $message;
        return $message;
    }
    public static function genarateSound($cat) {

        $sound = 'default';
        
        return $sound;
    }
    public static function deleteEndPointApp($array, $nextToken = null) {
        global $sns;

        $sns->unsubscribe(array(
            'SubscriptionArn' => $array['subarn']
        ));
    }
}
// $notiObject = new SNSNoti();

// if (isset($_POST['method']) && !empty($_POST['method'])) {
//     if (method_exists($notiObject, $_POST['method'])) {
//         $result = $notiObject->$_POST['method'](['token' => $_POST['token'],
//             'cat' => $_POST['cat'],
//             'endarn' => $_POST['endarn'],
//             'message' => $_POST['message'],
//             'url' => $_POST['url'],
//             'subarn' => $_POST['subarn'],
//             'device_id' => $_POST['device_id'],
//             'cat_id' => $_POST['cat_id'],
//             'sub_id' => $_POST['sub_id']]);
//         echo $result;
//     } else {
//         die("Error: method not exist");
//     }
// } else {
//     die("Error: method name not sent");
// }