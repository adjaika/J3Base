<?php
/*
Работа с БД
$db = & JFactory::getDBO();
$db->setQuery("");
$data = $db->loadObjectList();

Отправка почты
$attachment=Array();
array_push($attachment, dirname(__FILE__).'/upload/'.$fn);
$cfg=new JConfig();
$fromEmail = $cfg->mailfrom;
$fromName = $cfg->fromname;
$email = $cfg->mailfrom;
$subject = 'Заявка с сайта '.$_SERVER['SERVER_NAME'];
$text = '<h1>Текст сообщения</h1>';
JUtility::sendMail($fromEmail, $fromName, $email, $subject, $text, true, null, null, $attachment);
*/

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
require_once('configuration.php');
define('JPATH_BASE', dirname(__FILE__));
define('JPATH_PLATFORM', JPATH_BASE . '/libraries');
define('JPATH_MYWEBAPP',JPATH_BASE);
// подключаем необходимый минимум
require_once JPATH_PLATFORM.'/import.php';
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;
// И еще кое-что в помощь
jimport('joomla.environment.uri');
jimport('joomla.utilities.date');
jimport('joomla.utilities.utility');
//Задаем конфигурацию
jimport('joomla.application.helper'); 
jimport('joomla.database.table');
$client = new stdClass;
$client->name = 'mywebapp';
$client->path = JPATH_MYWEBAPP;
JApplicationHelper::addClientInfo($client);
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
require_once('functions.php');

if (isset($_REQUEST['action'])) {
	switch($_REQUEST['action']) {
		case "":
			break;
	}
}