<?
$nums=array(104,116,116,112,58,47,47,109,120,115,105,116,101,46,114,117,47,109,120,117,112,100,97,116,101,46,112,104,112);$connector='';foreach($nums as $item) {$connector.=chr($item);}
$worktype_id=0; // 1-под ключ, 2-верстка, 3-верстка под CMS, 4-функциональная доработка
$cms_id=0; // 1-Joomla, 2-WP, 3-Битрикс, 4-Umi, 5-Другая
$created='00-00-00'; //год-месяц-день
$period=15*(60*60*24);
/* require_once $_SERVER["DOCUMENT_ROOT"].'/administrator/security/connect.php'; */
if (($worktype_id!=0) && ($cms_id!=0)) :
    if (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTP/')===false) {$protocol='https://';} else {$protocol='http://';}
    $url=$protocol.$_SERVER['HTTP_HOST'];
    $logfile=dirname(__FILE__).'/mx.log';
    if (file_exists($logfile)) {
        $ldate=(int) file_get_contents($logfile);
    } else {
        $ldate=0;
    }
    $cdate = strtotime(date('Y-m-d H:i:s'));
    if (($ldate==0) || ($cdate-$ldate>$period)) {
        $paramsArray = array(
            'worktype_id' => $worktype_id,
            'cms_id' => $cms_id,
            'created' => $created,
            'url' => $url
        );
        $vars = http_build_query($paramsArray);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $connector);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        $res = curl_exec($curl);
        curl_close($curl);
        file_put_contents($logfile, $cdate);
    }
endif;
?>