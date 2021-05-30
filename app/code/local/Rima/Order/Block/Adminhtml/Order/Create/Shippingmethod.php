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
    public function setCart($cart){
        $this->cart = $cart;
        return $this;
    }

    public function getCart(){
        if(!$this->cart){
            throw new Exception("Cart not found");
        }
        return $this->cart;
    }
    
}
?>