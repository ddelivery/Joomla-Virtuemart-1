<?php 
$uri = JFactory::getURI();
$uri->setVar('option','com_config');
$uri->setVar('controller','component');
$uri->setVar('component','com_ddelivery');
?>
<iframe src="<?php echo $uri->toString(); ?>" style="width: 100%; height:100%; border: 0px; min-height: 600px;" height="100%">
</iframe>
<div class="clear"></div>