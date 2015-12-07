<?php
/**
 * @copyright    Copyright (C) 2012 Vox Interactif. All rights reserved.
 * @author		 Vox Interactif
 * @license      GNU/GPL v.3 or later
 * 
 * SobiProLinks is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Based on joomlalinks found in JCE's core code. Modified by Marie-Josée
 * Paquet to bring compatibility between Sigsiu.net's SobiPro and JCE and to support them.
 */

defined('_WF_EXT') or die('RESTRICTED');

/**
 * This class fetches SobiPro's categories and items
 */
class SobiProLinks extends JObject
{
	var $_option = 'com_sobipro';
	
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
				$instance = new SobiProLinks();
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
			if ($advlink->checkAccess('SobiProlinks.sobiPro', '1')) 
			{
				$list = '<li id="index.php?option=com_sobipro"><div class="tree-row"><div class="tree-image"></div><span class="folder content nolink"><a href="javascript:;">' . JText::_('SobiPro Content') . '</a></span></div></li>';
			}
			return $list;	
		}
						

	// Function getRootSections
	// $parent: parent category
	// return: object array of root sections
	
	function getRootSections()
		{
		
		$db	=& JFactory::getDBO();

			$query="SELECT #__sobipro_relations.id,  #__sobipro_object.name FROM #__sobipro_relations INNER JOIN #__sobipro_object ON  #__sobipro_relations.id =  #__sobipro_object.id"; 
			
			$query .= " WHERE #__sobipro_object.approved= 1 AND #__sobipro_relations.oType='section' ORDER BY #__sobipro_relations.id";
						
			$db->setQuery($query);
			
			return $db->loadObjectList();
		}
	
	// Function getCategories
	// $parent: parent category
	// return: object array of categories which are descendants of $parent (only from the level below the parent, not deeper)
	
	function getCategories($parent)
		{
		
		$db	=& JFactory::getDBO();

		$query="SELECT #__sobipro_relations.id,  #__sobipro_object.name FROM #__sobipro_relations INNER JOIN #__sobipro_object ON  #__sobipro_relations.id =  #__sobipro_object.id"; 
			
		$query .= " WHERE #__sobipro_relations.pid=".$parent." AND #__sobipro_relations.oType='category' ORDER BY #__sobipro_relations.id";
						
		$db->setQuery($query);
		
		return $db->loadObjectList();
		
		}
	
	// Function getEntries
	// $parent: parent category
	// return: object array of entries which are descendants of $parent
	
	function getEntries($parent = 0)
		{ 
		
			// Since the fields all have unique IDs, I relied on the position 1 to get the field data(baseData) since it's usually there that users will put the field title/name.

			$db		=& JFactory::getDBO();

			$query="SELECT #__sobipro_object.id, #__sobipro_field_data.baseData FROM #__sobipro_field_data,  #__sobipro_object,  #__sobipro_relations, #__sobipro_field WHERE  #__sobipro_relations.pid =".$parent." AND #__sobipro_relations.id = #__sobipro_object.id AND #__sobipro_object.id =  #__sobipro_field_data.sid AND #__sobipro_field_data.fid = #__sobipro_field.fid AND #__sobipro_object.approved= 1 AND #__sobipro_field.position=1";
				
			$query .= " ORDER BY #__sobipro_object.id";

			$db->setQuery($query);
				
			return $db->loadObjectList();
		}

  function getLinks ($args) 
	{
  
		 //$args gets the values in the URL. 
		 // For example, let's say the link of the parent item is index.php?option=com_sobipro&sid=2
		 // $args will have a sid within its array with the value 2
	        
        $items = array();
                 
        $SobiProTask = isset($args->SobiProTask) ? $args->SobiProTask : '';
        
        $catid = isset($args->sid) ? $args->sid : '';
        
        switch ($sobi2Task) 
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
	                            
	                           'id'		=> 'index.php?option=com_sobipro&sid='.$category->id,
	                           
	        			       'name'		=>	$category->name,
	                           
	        			       'class'		=>	'folder content'
	                            
	                        );
	                        
	                    }
                    }
                                
                    // show entries for this category
                    
                    $entries = self::getEntries($catid); 
                    
                    if (!is_null($entries)) 
					{
                    	
	                    foreach ($entries as $entry)
						{
	                        
	                        $items[] = array
							(
	                            
	                           'id'			=> 'index.php?option=com_sobipro&sid='.$entry->id,
	                           
						       'name'		=>	$entry->baseData,
	                           
						       'class'		=>	'file'
	                            
	                        );                        
	                        
	                    }
                    
                    }

                        
                }  
			else 
				{
				
				// Go get the root sections
                    
                    $sections = self::getRootSections();
                    
                    if ($sections) 
					{
						foreach ($sections as $section) 
						{
							
							$items[] = array
							(
									
								   'id'		=> 'index.php?option=com_sobipro&sid='.$section->id,
								   
								   'name'		=>	$section->name,
								   
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