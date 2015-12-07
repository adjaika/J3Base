<?php
/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2013 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_WF_EXT') or die('RESTRICTED');
?>
<table border="0" cellpadding="3" cellspacing="0">
    <tr>
        <td><label for="rokbox_caption" class="hastip" title="<?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_CAPTION_DESC'); ?>"><?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_CAPTION'); ?></label></td>
        <td><input id="rokbox_caption" type="text" class="text" value="" /></td>
    </tr>
    <tr>
        <td><label for="rokbox_album" class="hastip" title="<?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_ALBUM_DESC'); ?>"><?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_ALBUM'); ?></label></td>
        <td><input id="rokbox_album" type="text" value="" /></td>
    </tr>
    <tr>
        <td><label for="width" class="hastip" title="<?php echo WFText::_('WF_LABEL_DIMENSIONS_DESC'); ?>"><?php echo WFText::_('WF_LABEL_DIMENSIONS'); ?></label></td>
        <td>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <input type="text" id="rokbox_width" value="" /> <select id="rokbox_width_unit"><option value="">px</option><option value="%">%</option></select> x <input type="text" id="rokbox_height" value="" /> <select id="rokbox_height_unit"><option value="">px</option><option value="%">%</option></select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><label for="rokbox_element" class="hastip" title="<?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_ELEMENT_DESC'); ?>"><?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_ELEMENT'); ?></label></td>
        <td><input id="rokbox_element" type="text" class="text" value="" /></td>
    </tr>
    <tr>
        <td><label for="rokbox_generate_thumbnail" class="hastip" title="<?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_THUMBNAIL_DESC'); ?>"><?php echo WFText::_('WF_POPUPS_ROKBOX_OPTION_THUMBNAIL'); ?></label></td>
        <td><input id="rokbox_generate_thumbnail" type="checkbox" /></td>
    </tr>	
</table>