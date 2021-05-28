<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Paymentmethod extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	
	public function __construct()
    {
        $this->_controller = 'adminhtml_order_create_paymentmethod';
        $this->_blockGroup = 'order';
        parent::__construct();
    }
    
}
?>