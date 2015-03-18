<?php
defined('_JEXEC') or die();
 
class JElementFiomerge extends JElement
{
 
	function fetchElement($name, $value, &$node, $control_name)
	{	
		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		$js = "alert('hello ozk')";
		//$doc->addScriptDeclaration($js);
		
		$query = 'SELECT a.fieldid as id, a.name AS text '
		. ' FROM #__vm_userfield AS a'
		. ' WHERE a.published = 1'
		. ' AND a.name <> "password" AND a.name <> "password2"'
		. ' ORDER BY  a.name'
		;
		$db->setQuery( $query );
		$options = $db->loadObjectList( );
		//echo $db->getErrorMsg();
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'text', 'text', $value, $control_name.$name );
		
	}
}
?>