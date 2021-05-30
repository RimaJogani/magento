<?php

class Rima_Order_Block_Adminhtml_Order_Create extends Mage_Adminhtml_Block_Template
{
	protected $cart = null;
    public function __construct()
    {
        parent::__construct();
    }

    public function getHeaderText()
    {
    	return $this->_headerText = 'Create New Order';
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
