<?php
defined('_JEXEC') or die();
 
class JElementPayments extends JElement
{
 
	function fetchElement($name, $value, &$node, $control_name)
	{	
		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		
		
		$query = 'SELECT a.payment_method_id as id, a.payment_method_name AS text '
		. ' FROM #__vm_payment_method AS a'
		. ' WHERE a.payment_enabled = "Y"'
		
		;
		$options = array();
		$k = new stdClass();
		$k->id = 1;
		$k->text = "Все способы";
		
		$db->setQuery( $query );
		$options = $db->loadObjectList( );
		//print_r($options);
		array_unshift($options,$k);
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'text', $value, $control_name.$name );
		
	}
}
?>