<?php
class Rima_Order_Model_Cart_Item extends Mage_Core_Model_Abstract
{
	protected $cart = null;
    protected function _construct()
    {
        $this->_init('order/cart_item');
        
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