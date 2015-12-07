<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
require_once $_SERVER["DOCUMENT_ROOT"].'/administrator/security/connect.php';
require_once($_SERVER["DOCUMENT_ROOT"].'/functions.php');
$params = $app->getTemplate(true)->params;

$doc->addScript('templates/' . $this->template . '/js/functions.js');
$doc->addScript('templates/' . $this->template . '/js/template.js');
$doc->addStyleSheet('templates/' . $this->template . '/css/template.css');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <META Name=Author Lang="ru" content="Куликов Сергей Владимирович, студия MX, разработка сайтов под ключ, дизайн, верстка, программирование, http://mxsite.ru">
	<jdoc:include type="head" />
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl; ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>

<body>

    <jdoc:include type="modules" name="mx_menu" style="none" />
    <jdoc:include type="message" /> <!--В этой позиции выводятся системные сообщения -->
    <jdoc:include type="component" />

	<jdoc:include type="modules" name="debug" style="none" /> <!--В этой позиции выводится информация для отладки -->
</body>
</html>
