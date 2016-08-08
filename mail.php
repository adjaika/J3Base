<?
require_once('configuration.php');
$config=new JConfig();
$to=$config->mailfrom;
$toName=$config->fromname;
$from=($toName?$toName.' ':'').'<'.$to.'>';
$subject=$_REQUEST['subject'].' ('.$_SERVER['HTTP_HOST'].')';
$subject='=?utf-8?B?'.base64_encode($subject).'?=';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: '.$from. "\r\n";
$message=$_REQUEST['message'];
mail($to, $subject, $message, $headers);
?>