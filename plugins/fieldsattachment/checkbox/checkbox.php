<?php
/**
 * @version		$Id: fieldsattachement.php 15 2011-09-02 18:37:15Z cristian $
 * @package		fieldsattach
 * @subpackage		Components
 * @copyright		Copyright (C) 2011 - 2020 Open Source Cristian Grañó, Inc. All rights reserved.
 * @author		Cristian Grañó
 * @link		http://joomlacode.org/gf/project/fieldsattach_1_6/
 * @license		License GNU General Public License version 2 or later
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

// require helper file

global $sitepath;
$sitepath = JPATH_ROOT ;  
JLoader::register('fieldattach',  $sitepath.DS.'components/com_fieldsattach/helpers/fieldattach.php');
JLoader::register('fieldsattachHelper',   $sitepath.DS.'administrator/components/com_fieldsattach/helpers/fieldsattach.php');
include_once $sitepath.'/administrator/components/com_fieldsattach/helpers/extrafield.php';

class plgfieldsattachment_checkbox extends extrafield
{
    protected $name;
     
         
	static function construct1( )
	{
        parent::getLanguage(plgfieldsattachment_checkbox::getName());
	}

    static public function getName()
    {  

          return "checkbox";
             // return  $this->name;
    }
	   

    static function renderInput($articleid, $fieldsid, $value, $extras=null )
    {
        $required="";

        global $sitepath; 
        JLoader::register('fieldattach',  $sitepath.DS.'components/com_fieldsattach/helpers/fieldattach.php');
      
        $boolrequired = fieldattach::isRequired($fieldsid);
        if($boolrequired) $required="required";

        $str='<input'.($value==''?'':' checked="checked"').' name="field_'.$fieldsid.'" class="customfields '.$required.'" type="checkbox"/>';
        return $str;

    }

    static function getHTML($articleid, $fieldsid, $category = false, $write=false)
    {
        global $globalreturn;
        //$str  = fieldattach::getSelect($articleid, $fieldsid);
        
          //$valor = fieldattach::getValue( $articleid,  $fieldsid, $category  );
          //$title = fieldattach::getName( $articleid,  $fieldsid , $category );
          //$published = plgfieldsattachment_select::getPublished( $fieldsid  );

          if(method_exists ( 'fieldattach' , 'getFieldValues' ))
          {
            $jsonValues       = fieldattach::getFieldValues( $articleid,  $fieldsid , $category   );
            $jsonValuesArray  = json_decode($jsonValues); 


            $valor      = html_entity_decode($jsonValuesArray->value);
            $title      = $jsonValuesArray->title;
            $published  = $jsonValuesArray->published;
            $showTitle  = $jsonValuesArray->showtitle;

          }
          else
          {
            $valor = fieldattach::getValue( $articleid,  $fieldsid, $category  );
            $title = fieldattach::getName( $articleid,  $fieldsid , $category );
            $published = plgfieldsattachment_checkbox::getPublished( $fieldsid  );
            $showTitle  = fieldattach::getShowTitle(   $fieldid  );

          } 

          $html="";
            
          if(!empty($valor) && $published)
          {
              //$isNull= plgfieldsattachment_select::isNull( $fieldsid , $valor, $category );
              $valorselects = fieldattach::getValueSelect( $fieldsid , $valor );
              //echo "<br />ISNULL:".$isNull."---<br/>";
              //if(!$isNull){
              if(!empty($valorselects)){
                    
                    
                    $html = plgfieldsattachment_checkbox::getTemplate($fieldsid, "select");
          
                    /*
                        Templating Laouyt *****************************

                        [TITLE] - Title of field
                        [FIELD_ID] - Field id 
                        [VALUE] - Value of input
                        [ARTICLE_ID] - Article id

                    */
		
		 

                    if($showTitle) $html = str_replace("[TITLE]", $title, $html); 
                    else $html = str_replace("[TITLE]", "", $html); 

                    $html = str_replace("[VALUE]", stripslashes($valorselects), $html);
                    $html = str_replace("[FIELD_ID]", $fieldsid, $html);
                    $html = str_replace("[ARTICLE_ID]", $articleid, $html);

              }else{
                  $html="";
              }
          }
       
       //WRITE THE RESULT
       if($write)
       {
            echo $html;
       }else{
            $globalreturn = $html;
            return $html; 
       }
    }
     


    function action( $articleid, $fieldsid, $fieldsvalueid)
    {
        require_once(JPATH_SITE.'/functions.php');
        if (!isset($_REQUEST['field_'.$fieldsid])) {
            SQLExec("UPDATE #__fieldsattach_values SET `value`='' WHERE fieldsid=$fieldsid AND articleid=$articleid");
        }
    }
        
    /**
	 * Return the value of selectfield
	 *
	 * @param	$id	 id of article
         *              $fieldsids  id of field
	 *
	 * @return	value to field.
	 * @since	1.6
	 */
	//public function getValueSelect($articleid, $fieldsids, $category = false )
    static public function isNull( $fieldsids, $valor,  $category = false )
	
	{
            //$valor = fieldattach::getValue($articleid, $fieldsids, $category );
            $valortmp = explode(",", $valor);
            
	    $db = JFactory::getDBO(  );

	    $query = 'SELECT  a.extras  FROM #__fieldsattach  as a WHERE a.id = '.$fieldsids;
 
            echo "<br/>  qqq".$query."<br/>";
            $db->setQuery( $query );
	    $extras = $db->loadResult();  
            $retorno = false;
            if(!empty($extras)) {
                   
                   $lineas = explode(chr(13),  $extras); 
                     foreach($lineas as $linea){  
                        $linea = explode("|",  $linea);
                        $value = $linea[0];
                        //if(count($linea)>1){$value = $linea[1];} 
                        
                        if($valor == $value)
                        {
                            if(count($linea)==1) {$retorno = true;break;}
                            
                        }
                            //break;
                    }
                }
            
            
           // echo "VALOR: ".count($tmp)."<br/>";
	    return $retorno;
	}
        
	public function searchinput($fieldsid, $value, $extras)
	{
		return plgfieldsattachment_checkbox::renderInput(-1, $fieldsid, $value, $extras);
		  
		  
	}
        
         

        
       

}
