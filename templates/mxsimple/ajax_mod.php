<?
// index.php?tmpl=ajax_mod&mod_pos=posName
?>
<?php defined('_JEXEC') or die;
$mod_pos = JRequest::getVar('mod_pos'); // получаем имя подгружаемой позиции.
?>
<jdoc:include type="modules" name="<?php echo $mod_pos;?>" /> <!--и выводим её.-->