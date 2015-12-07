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
	/**
	 * Plugin that cloaks all emails in content from spambots via Javascript.
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	mixed	An object with a "text" property or the string to be cloaked.
	 * @param	array	Additional parameters. See {@see plgEmailCloak()}.
	 * @param	int		Optional page number. Unused. Defaults to zero.
	 * @return	boolean	True on success.
	 */
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
        $app  = JFactory::getApplication();
        if ($app->isAdmin()) {return;}
		//$row->text='modified text';
	}

	/**
	 * Genarate a search pattern based on link and text.
	 *
	 * @param	string	The target of an email link.
	 * @param	string	The text enclosed by the link.
	 * @return	string	A regular expression that matches a link containing the parameters.
	 */
	
	/**
	 * Cloak all emails in text from spambots via Javascript.
	 *
	 * @param	string	The string to be cloaked.
	 * @param	array	Additional parameters. Parameter "mode" (integer, default 1)
	 * replaces addresses with "mailto:" links if nonzero.
	 * @return	boolean	True on success.
	 */
	
}
