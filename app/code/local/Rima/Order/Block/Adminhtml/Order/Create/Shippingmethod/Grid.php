<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Shippingmethod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	public function __construct()
    {
        parent::__construct();
    }
    public function getShippingMethodTitle()
    {
    	$methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
    	return $methods;
    }

}
?>