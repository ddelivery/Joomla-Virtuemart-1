<?php
defined('_JEXEC') or die();
 
class JElementCheckbox extends JElement
{
 
	function fetchElement($name, $value, &$node, $control_name)
	{	
		//print_r($name);
		//print_r($node);
		//print_r($value);
		//print_r($control_name);
		$checked = ( $node->attributes('checked')? 'checked="'.$node->attributes('checked').'"' : '' );
		if ($value > 0) $checked = " checked ";
		//$value = 1;
    	return '<input type="checkbox" name="' . $control_name . '[' . $name . ']" id="' . $control_name . '[' . $name . ']"' .
                     'value="' . $node->attributes('value') . '"' . $checked . ' />';
	}
}
?>