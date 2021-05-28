<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Shippingmethod extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	
	public function __construct()
    {

        $this->_controller = 'adminhtml_order_create_shippingmethod';
        $this->_blockGroup = 'order';
        parent::__construct();
    }
    
}
?>