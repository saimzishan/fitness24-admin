<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set("Asia/Dubai");
header('Content-Type: text/html; charset=UTF-8');

$connect = mysqli_connect('mybar.com', 'mybarqco_HLS', '0502011480', 'mybarqco_appntf');
$mainCat = parsingCat($argv[1]);
$url = "http://www.uaebarq.ae/pn/bndl/services/" . $mainCat . "/" . $argv[1] . ".xml";
$lastFeed = callXML($url);

if ($lastFeed != '') {
    $LatestFeedStored = getLatestStor($argv[1], $lastFeed);
    checkPageCashed($url, $lastFeed, $LatestFeedStored, $argv[1]);
}

function parsingCat($cat) {
    return $cat[0];
}

function callXML($url) {
    $xml = simplexml_load_file($url)or die('connot read xml');
    $lastFeed = $xml->channel->item[0]->id;
    return $lastFeed;
}

function getLatestStor($cat, $lastFeed) {
    global $connect;

    $result = mysqli_query($connect, "SELECT news_id AS maxid FROM rss_monitor WHERE cat='$cat'");

    $array = array();
    while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $array[] = $row;
    }

    if ($array[0]['maxid'] != '') {
        return $array[0]['maxid'];
    } else {
        mysqli_query($connect, "INSERT INTO rss_monitor (news_id, cat) VALUES($lastFeed, $cat)");

        return 'new';
    }
}

function checkPageCashed($url, $lastFeed, $LatestFeedStored, $cat) {
    global $connect;

    if ($LatestFeedStored == 'new') {
        callCURL($lastFeed);
        die();
    } else {
        while (true) {
            if ($lastFeed > $LatestFeedStored) {
                mysqli_query($connect, "UPDATE rss_monitor SET news_id='$lastFeed' WHERE cat='$cat'");
                callCURL($lastFeed);
                die();
            } else {
                callXML($url);
                sleep(1);
            }
        }
    }
}

function callCURL($lastFeed) {
    global $connect;
    
    $result=  mysqli_query($connect, "SELECT cont FROM rss WHERE id='$lastFeed'");
    $array = array();
    while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $array[] = $row;
    }
    
    $cat_bndl = $argv[1];
    $cont_bndl = $array[0]['cont'];
    $url_bndl_ok = '';

    switch ($cat_bndl) {
        case "A1":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "??? ????: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            $urlA1 = "http://www.uaebarq.ae/pn/bndl/services/newsapp/refresh.php";
            $chA1 = curl_init();
            curl_setopt($chA1, CURLOPT_URL, $urlA1);
            curl_setopt($chA1, CURLOPT_RETURNTRANSFER, TRUE);
            $contentA1 = curl_exec($chA1);

            break;
        case "G1":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "??? ??????: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            $urlG1 = "http://www.uaebarq.ae/pn/bndl/services/newsapp/refresh.php";
            $chG1 = curl_init();
            curl_setopt($chG1, CURLOPT_URL, $urlG1);
            curl_setopt($chG1, CURLOPT_RETURNTRANSFER, TRUE);
            $contentG1 = curl_exec($chG1);

            break;
        case "G2":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "??? ???: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            $urlG2 = "http://www.uaebarq.ae/pn/bndl/services/newsapp/refresh.php";
            $chG2 = curl_init();
            curl_setopt($chG2, CURLOPT_URL, $urlG2);
            curl_setopt($chG2, CURLOPT_RETURNTRANSFER, TRUE);
            $contentG2 = curl_exec($chG2);

            break;
        case "G3":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "??? ???????: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            $urlG3 = "http://www.uaebarq.ae/pn/bndl/services/newsapp/refresh.php";
            $chG3 = curl_init();
            curl_setopt($chG3, CURLOPT_URL, $urlG3);
            curl_setopt($chG3, CURLOPT_RETURNTRANSFER, TRUE);
            $contentG3 = curl_exec($chG3);

            break;
        case "C1":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "?????: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            $urlC1 = "http://www.uaebarq.ae/pn/bndl/services/newsapp/refresh.php";
            $chC1 = curl_init();
            curl_setopt($chC1, CURLOPT_URL, $urlC1);
            curl_setopt($chC1, CURLOPT_RETURNTRANSFER, TRUE);
            $contentC1 = curl_exec($chC1);

            break;
        case "D1":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "?? ????????: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            $urlD1 = "http://www.uaebarq.ae/pn/bndl/services/newsapp/refresh.php";
            $chD1 = curl_init();
            curl_setopt($chD1, CURLOPT_URL, $urlD1);
            curl_setopt($chD1, CURLOPT_RETURNTRANSFER, TRUE);
            $contentD1 = curl_exec($chD1);

            break;
        
        
        case "test":
            $url = 'http://www.uaebarq.ae/pn/bndl/push/SP.php';
            $title = $cont_bndl;
            $title = "??????: " . $cont_bndl;
            $url2 = $url_bndl_ok;
            $cat_bndl = $cat_bndl;
            $fields = array(
                'msg' => $title,
                'url' => $url2,
                'servs' => $cat_bndl,
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            sleep(1);
            $result = curl_exec($ch);
            curl_close($ch);
            
            break;
        
        default:
            break;
    }
}
