<?php
defined('_JEXEC') or die();
 
class JElementProductfield extends JElement
{
 
	function fetchElement($name, $value, &$node, $control_name)
	{	
		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		$js = "alert('hello ozk')";
		//$doc->addScriptDeclaration($js);
		
		$query = "SHOW COLUMNS  
					FROM #__vm_product";
		$db->setQuery( $query );
		$options = $db->loadObjectList( );
		
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'Field', 'Field', $value, $control_name.$name );
		
	}
}
?>