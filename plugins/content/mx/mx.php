<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Email cloack plugin class.
 *
 * @package		Joomla.Plugin
 * @subpackage	Content.emailcloak
 */
class plgContentmx extends JPlugin
{
	static function shortcode_simple_shortcode($params) { // Простой пример реализации шорткода, в переменной params передаются параметры шорткода в виде объекта
		ob_start();
		echo 'simple shortcode';
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}

	function shortcode($shortcode) { // Обработка строки, похожей на шорткод.
		if (!preg_match('|^\[(\S+?)\s+?(\S?.*?)\]$|',$shortcode[1],$matches)) {
			preg_match('|^\[(\S+?)\]$|',$shortcode[1],$matches);
		}
		$function='shortcode_'.$matches[1];
		$paramsResultA=new stdClass();
		if(is_callable(array($this,$function))) {
			if (count($matches)>2) {
				$params = $matches[2];
				$params = str_replace('&nbsp;', ' ', $params);
				while (strpos($params, '  ') !== false) {
					$params = str_replace('  ', ' ', $params);
				}
				$params = str_replace(array('= ', ' ='), '=', $params);
				$paramsA = explode(' ', $params);
				foreach($paramsA as $item) {
					$itemA=explode('=',$item);
					if (count($itemA)<2) {continue;}
					$itemA[1]=preg_replace('|^"|','',$itemA[1]);
					$itemA[1]=preg_replace('|"$|','',$itemA[1]);
					$paramsResultA->$itemA[0]=$itemA[1];
				}
			}
			return self::$function($paramsResultA);
		} else {
			return $shortcode[0];
		}
	}

	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
        $app  = JFactory::getApplication();
        if ($app->isAdmin()) {return;}
		$row->text=preg_replace_callback('|(\[[^\]]+?\])|',array($this,'shortcode'),$row->text); // Поиск шорткодов в тексте
	}
}
