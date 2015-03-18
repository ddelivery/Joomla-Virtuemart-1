<?php
	include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','application', 'bootstrap.php')));
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','application', 'classes', 'DDelivery', 'DDeliveryUI.php')));
    include_once(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR,'components','com_ddelivery','ddelivery', 'IntegratorShop.php')));
    
    use DDelivery\DDeliveryUI;

    try{
        
  		$IntegratorShop = new IntegratorShop();
        $ddeliveryUI = new DDeliveryUI($IntegratorShop, true);
		$status = $d['new_order_status'];
        $payment = (int)$d['payment_method_id'];
        $id = (int)$_SESSION['DIGITAL_DELIVERY']['ORDER_ID'];
        $ddeliveryUI->onCmsOrderFinish($id,$d['order_id'], $status, $payment);
	}

	catch( \DDelivery\DDeliveryException $e  )
	{
		echo $e->getMessage();
	}
?>