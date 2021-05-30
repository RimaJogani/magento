<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Paymentmethod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	public function __construct()
    {
        parent::__construct();
    }

    public function getPayemntMethodTitle()
    {
    	$methods = Mage::getModel('payment/config');
    	$activemethod = $methods->getActiveMethods();
    	unset($activemethod['paypal_billing_agreement']);
    	unset($activemethod['checkmo']);
    	unset($activemethod['free']);
    	return $activemethod;
    }

}
?>