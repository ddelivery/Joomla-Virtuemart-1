<?php
defined('JPATH_BASE') or die();
 
class JElementMulti extends JElement
{
  var  $_name = 'Multi';
 
  function fetchElement($name, $value, &$node, $control_name)
  {
    $ctrl = $control_name . '[' . $name . ']';
    $attribs = '';
 
    if ($v = $node->attributes('class')) {
      $attribs .= ' class="'.$v.'"';
    } else {
      $attribs .= ' class="inputbox"';
    }
 
    if ($v = $node->attributes('size')) {
      $attribs .= ' size="'.$v.'"';
    }
 
    if ($m = $node->attributes('multiple')) {
      $attribs .= ' multiple="multiple"';
      $ctrl .= '[]';
    }
  
    $options = array ();
    $db			=& JFactory::getDBO();
    $query = 'SELECT a.payment_method_id as value, a.payment_method_name AS text '
		. ' FROM #__vm_payment_method AS a'
		. ' WHERE a.payment_enabled = "Y"'
		
		;
	$db->setQuery( $query );
	$op = $db->loadObjectList( );
    foreach ($op as $option)
    {
      $val  = $option->value;
      $text  = $option->text;
      $options[] = JHTML::_('select.option', $val, JText::_($text));
    }
 	$attribs .= ' size="'.count($op).'"';
 	$attribs .= ' multiple="multiple"';
    $ctrl .= '[]';
		
		
    return JHTML::_('select.genericlist',  $options, $ctrl, trim($attribs), 'value', 'text', $value, $control_name.$name);
  }
}