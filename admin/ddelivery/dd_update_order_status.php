<?php
	include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','application', 'bootstrap.php')));
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','application', 'classes', 'DDelivery', 'DDeliveryUI.php')));
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','ddelivery', 'IntegratorShop.php')));
    
    use DDelivery\DDeliveryUI;
    //global $d;
    //throw new Exception('$d: '.print_r($d),1);

    try{
        //JFactory::getApplication()->enqueueMessage(print_r($d,1));
  		$IntegratorShop = new IntegratorShop();
		$ddeliveryUI = new \Ddelivery\DDeliveryUI($IntegratorShop, true);
		$shopOrderID = (int)$d['order_id'];
        $status = $d['order_status'];
        $order = $ddeliveryUI->getOrderByCmsID($shopOrderID);
        $order->goodsDescription = substr($order->goodsDescription,0,199);
        $ddeliveryUI->saveFullOrder($order);
        //JFactory::getApplication()->enqueueMessage('<pre>'.print_r($order,1).'</pre>');
        $ddeliveryUI->onCmsChangeStatus($shopOrderID, $status);
        
        //JFactory::getApplication()->enqueueMessage('isStatusToSendOrder: ' .$IntegratorShop->isStatusToSendOrder($status) . ' shopOrderId: '.$shopOrderID . ' status: '. $status . ' order: <pre>'. print_r($ddeliveryUI->getOrderByCmsID($shopOrderID),1).'</pre>');
	}

	catch( \DDelivery\DDeliveryException $e  )
	{
		echo $e->getMessage();
	}
?>