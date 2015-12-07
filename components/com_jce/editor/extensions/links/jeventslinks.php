<?php
/**
 * @copyright    Copyright (C) 2012 Vox Interactif. All rights reserved.
 * @author		 Vox Interactif
 * @license      GNU/GPL v.3 or later
 * 
 * JEventsLinks is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Based on joomlalinks found in JCE's core code. Modified by Marie-Josée
 * Paquet to bring compatibility between JEvents and JCE and to support them.
 */
 
// Initialize 
defined('_WF_EXT') or die('RESTRICTED');

class WFLinkBrowser_JEventslinks extends JObject
{
	
	var $_option 	= array();
	
	var $_adapters 	= array();
	
	/**
	* Constructor activating the default information of the class
	*
	* @access	protected
	*/
	function __construct($options = array()){
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
				
		$path = dirname( __FILE__ ) .DS. 'JEventsLinks';
		
		// Get all files
		$files = JFolder::files( $path, '\.(php)$' );
		
		if ( !empty( $files ) ) {
			foreach( $files as $file ) {
				require_once( $path .DS. $file );
				$classname = 'JEventsLinks';
				$this->_adapters[] = new $classname;
			}
		}
	}
	
	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser =JContentEditor::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance(){
		static $instance;

		if ( !is_object( $instance ) ){
			$instance = new WFLinkBrowser_JEventslinks();
		}
		return $instance;
	}
	
	function display()
	{
		// Load css
		$document = WFDocument::getInstance();
		$document->addStyleSheet(array('jeventslinks'), 'extensions/links/jeventslinks/css');
	}
	
	function isEnabled() 
	{
		$wf = WFEditorPlugin::getInstance();
		return $wf->checkAccess($wf->getName() . '.links.jeventslinks', 1);
	}
	
	function getOption()
	{
		foreach( $this->_adapters as $adapter ){
			$this->_option[]= $adapter->getOption();
		}
		return $this->_option;
	}
	
	function getList()
	{
		$list = '';
		
		foreach( $this->_adapters as $adapter ){
			$list .= $adapter->getList();
		}
		return $list;	
	}
	
		function getLinks( $args )
    {
        foreach( $this->_adapters as $adapter ){
            if( $adapter->getOption() == $args->option ){
                return $adapter->getLinks( $args );
            }
        }
    }
}	
?>