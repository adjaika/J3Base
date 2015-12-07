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

defined('_WF_EXT') or die('RESTRICTED');

/**
 * This class fetches SobiPro's categories and items
 */
class JEventsLinks extends JObject
{
	var $_option = 'com_jevents';
	
	/**
	* Constructor activating the default information of the class
	*
	* @access	protected
	*/
	function __construct($options = array())
		{
		
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
	function &getInstance()
		{
			static $instance;

			if ( !is_object( $instance ) )
			{
				$instance = new JEventsLinks();
			}
			return $instance;
		}
		
	public function getOption()
		{
			return $this->_option;
		}
	
	public function getList()
		{
			$advlink = WFEditorPlugin::getInstance();
			$list = '';
			if ($advlink->checkAccess('JEventslinks.JEvents', '1')) 
			{
				$list = '<li id="index.php?option=com_jevents"><div class="tree-row"><div class="tree-image"></div><span class="folder content nolink"><a href="javascript:;">' . JText::_('JEvents Content') . '</a></span></div></li>';
			}
			return $list;	
		}
						

	// Function getRootCategories
	// $parent: parent category
	// return: object array of root sections
	
	function getRootCategories()
		{
		
			$db	=& JFactory::getDBO();

			$query="SELECT id, title FROM #__categories"; 
			
			$query .= " WHERE parent_id = 1 AND extension = 'com_jevents' ORDER BY id";
						
			$db->setQuery($query);
			
			return $db->loadObjectList();
		}
	
	// Function getCategories
	// $parent: parent category
	// return: object array of categories which are descendants of $parent (only from the level below the parent, not deeper)
	
	function getCategories($parent)
		{
		
			$db	=& JFactory::getDBO();

			$query="SELECT id, title FROM #__categories"; 
			
			$query .= " WHERE parent_id = ".$parent." AND extension = 'com_jevents' ORDER BY id";
						
			$db->setQuery($query);
			
			return $db->loadObjectList();
		}
	
	// Function getEvents
	// $parent: parent category
	// return: object array of entries which are descendants of $parent
	
	function getEvents($parent = 0)
		{ 
		
			// Since the fields all have unique IDs, I relied on the position 1 to get the field data(baseData) since it's usually there that users will put the field title/name.

			$db		=& JFactory::getDBO();
			
			$query="SELECT #__jevents_vevdetail.evdet_id, #__jevents_vevdetail.summary, #__jevents_repetition.rp_id FROM #__jevents_vevdetail,  #__jevents_vevent,  #__categories, #__jevents_repetition WHERE #__categories.id =".$parent." AND #__categories.id = #__jevents_vevent.catid AND #__jevents_vevent.ev_id  =  #__jevents_vevdetail.evdet_id AND #__jevents_vevdetail.evdet_id  =  #__jevents_repetition.eventdetail_id";
				
			$query .= " ORDER BY #__jevents_vevdetail.evdet_id";

			$db->setQuery($query);
				
			return $db->loadObjectList();
		}

  function getLinks ($args) 
	{
  
		 //$args gets the values in the URL. 
		 // For example, let's say the link of the parent item is index.php?option=com_sobipro&sid=2
		 // $args will have a sid within its array with the value 2
		
			
        $items = array();
                 
        $JEventsTask = isset($args->JEventsTask) ? $args->JEventsTask : '';
        
        $catid = isset($args->category_fv) ? $args->category_fv : '';
        
        switch ($JEventsTask) 
		{
            case '': 
			{
			
			//if there's a sid (parent id) found in the URL of the parent, go get the children. Else, go get the root sections
                               
               if ($catid <> '') 
			   {

                    // show sub categories of this category
                    
                    $categories = self::getCategories($catid);
                    
                    if (!is_null($categories)) 
					{
	                    foreach ($categories as $category) 
						{
	                        
	                        $items[] = array
							(
						
	                            
	                           'id'		=> 'index.php?option=com_jevents&task=cat.listevents&category_fv='.$category->id,
	                           
	        			       'name'		=>	$category->title,
	                           
	        			       'class'		=>	'folder content'
	                            
	                        );
	                        
	                    }
                    }
                                
                    // show entries for this category
                    
                    $events = self::getEvents($catid); 
                    
                    if (!is_null($events)) 
					{
                    	
	                    foreach ($events as $event)
						{
	                        
	                        $items[] = array
							(
	                            
	                           'id'			=> 'index.php?option=com_jevents&task=icalrepeat.detail&evid='.$event->rp_id.'&Itemid=1',
	                           
						       'name'		=>	$event->summary,
	                           
						       'class'		=>	'file'
	                            
	                        );                        
	                        
	                    }
                    
                    }

                        
                }  
			else 
				{
				
				// Go get the root categories
                    
                    $rootCats = self::getRootCategories();
                    
                    if ($rootCats) 
					{
						foreach ($rootCats as $rootCat) 
						{
							
							$items[] = array
							(
									
								   'id'		=> 'index.php?option=com_jevents&task=cat.listevents&category_fv='.$rootCat->id,
								   
								   'name'		=>	$rootCat->title,
								   
								   'class'		=>	'folder content'
									
							);
						}
                            
                    }
                    
                                     
                }
                
            } 
			break;
            
        }
							
		return $items;        
            
    }

	
}

?>