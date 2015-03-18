<?php
defined('_JEXEC') or die();
 
class JElementStatus extends JElement
{
 
	function fetchElement($name, $value, &$node, $control_name)
	{	
		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		
		
		$query = 'SELECT a.order_status_code as id, a.order_status_name AS text '
		. ' FROM #__vm_order_status AS a';
		
		$options = array();
		/*
		$k = new stdClass();
		$k->id = 1;
		$k->text = "Все способы";
		*/
		$db->setQuery( $query );
		$options = $db->loadObjectList( );
		echo $db->getErrorMsg();
		//print_r($options);
		//array_unshift($options,$k);
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'text', $value, $control_name.$name );
		
	}
}
?>