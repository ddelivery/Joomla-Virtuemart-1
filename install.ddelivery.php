<?php
defined('_JEXEC') or die('Restricted access');

if (!defined('DS')) define('DS',DIRECTORY_SEPARATOR); 
if (!defined('JPATH_ADMINISTRATOR')) define('JPATH_ADMINISTRATOR',realpath(__DIR__.'/../administrator')); 
 function copy_r( $path, $dest )
    {
        if( is_dir($path) )
        {
            @mkdir( $dest );
            $objects = scandir($path);
            if( sizeof($objects) > 0 )
            {
                foreach( $objects as $file )
                {
                    if( $file == "." || $file == ".." )
                        continue;
                    if( is_dir( $path.DIRECTORY_SEPARATOR.$file ) )
                    {
                        copy_r( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
                    }
                    else
                    {
                        //JFactory::getApplication()->enqueueMessage("$path.DS.$file, $dest.DS.$file");
                        copy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
                    }
                }
            }
            return true;
        }
        elseif( is_file($path) )
        {
            return copy($path, $dest);
        }
        else
        {
            return false;
        }
    }
    //chmod(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS,0664);
    $vm_shipping_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS;
    if (!is_writable($vm_shipping_path))
        JFactory::getApplication()->enqueueMessage('Директория '. $vm_shipping_path. ' не доступна для записи.');
    if (!copy(__DIR__.DS.'shipping'.DS.'ddelivery.php',$vm_shipping_path.'ddelivery.php'))
        JFactory::getApplication()->enqueueMessage('Файл модуля доставки ddelivery.php в папку '. $vm_shipping_path. ' не скопирован.');
    if (!copy(__DIR__.DS.'shipping'.DS.'ddelivery.cfg.php',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS.'ddelivery.cfg.php'))
        JFactory::getApplication()->enqueueMessage('Файл модуля доставки ddelivery.cfg.php в папку '. $vm_shipping_path. ' не скопирован.');
    if (!copy(__DIR__.DS.'shipping'.DS.'ddelivery.ini',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'shipping'.DS.'ddelivery.ini'))
        JFactory::getApplication()->enqueueMessage('Файл модуля доставки ddelivery.ini в папку '. $vm_shipping_path. ' не скопирован.');
    
    
    $ps_order_fname = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_order.php';
    $ps_checkout_fname = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_checkout.php';
    //chmod($ps_order_fname,0664);
    $ps_order = file_get_contents($ps_order_fname);
    if (strpos($ps_order,'dd_update_order_status.php')===false){
       if (!copy($ps_order_fname,JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_order.backup.php'))
        JFactory::getApplication()->enqueueMessage('Не удалось скопировать файл '. $ps_order_fname);
       $ps_order = preg_replace('/function order_status_update\(&\$d\)\s*{/',"function order_status_update(&\$d) {\n\t\tinclude_once('".JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ddelivery'.DS.'ddelivery'.DS."dd_update_order_status.php');",$ps_order);
       }
    file_put_contents($ps_order_fname,$ps_order);
    
    $ps_checkout = file_get_contents($ps_checkout_fname);
    if (strpos($ps_checkout,'dd_checkout_finish.php')===false){
       if (!copy($ps_checkout_fname,JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_checkout.backup.php'))
        JFactory::getApplication()->enqueueMessage('Не удалось скопировать файл '. $ps_checkout_fname);
       $ps_checkout = preg_replace('/\$d\["order_id"\] = \$order_id = \$db->last_insert_id\(\);/',"\$d[\"order_id\"] = \$order_id = \$db->last_insert_id();\n\t\tinclude_once('".JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ddelivery'.DS.'ddelivery'.DS."dd_checkout_finish.php');",$ps_checkout);
       }
    file_put_contents($ps_checkout_fname,$ps_checkout);
    
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','application', 'bootstrap.php')));
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','application', 'classes', 'DDelivery', 'DDeliveryUI.php')));
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','ddelivery', 'IntegratorShop.php')));
    
    use DDelivery\DDeliveryUI;
    
    try{
        $db = JFactory::getDBO();
  		$IntegratorShop = new IntegratorShop();
		$ddeliveryUI = new \Ddelivery\DDeliveryUI($IntegratorShop, true);
		$ddeliveryUI->createTables();
        /**
 * $tempLine = '';
 *                 $lines = file(__DIR__.'/ps_dd_cities.sql');
 *                 foreach ($lines as $line)
 *                 {
 *                     if (substr($line, 0, 2) == '--' || $line == '')
 *                         continue;

 *                     $tempLine .= $line;
 *                     if (substr(trim($line), -1, 1) == ';')
 *                     {
 *                         $db->setQuery($tempLine);
 *                         $db->query();
 *                         $tempLine = '';
 *                     }
 *                 }
 */
	}
	catch( \DDelivery\DDeliveryException $e  )
	{
		echo $e->getMessage();
	}