<?php
// No direct access to this file
//defined('_JEXEC') or die('Restricted access');
if (!defined('DS')) define('DS','/'); 
if (!defined('JPATH_ADMINISTRATOR')) define('JPATH_ADMINISTRATOR',realpath(__DIR__.'/../administrator')); 
//echo JPATH_ADMINISTRATOR.'<br />';
unlink(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_order.php');
rename(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_order.backup.php',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_order.php');

unlink(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_checkout.php');
rename(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_checkout.backup.php',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_checkout.php');

unlink(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS.'ddelivery.php');
unlink(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS.'ddelivery.ini');
unlink(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS.'ddelivery.cfg.php');

/*
$db = JFactory::getDbo();
$pref = 'ps_dd_';
$db->setQuery("drop table IF EXISTS {$pref}orders");
$db->query();
$db->setQuery("drop table IF EXISTS {$pref}chache");
$db->query();
$db->setQuery("drop table IF EXISTS ddelivery_module_ps_dd_cities");
$db->query();*/