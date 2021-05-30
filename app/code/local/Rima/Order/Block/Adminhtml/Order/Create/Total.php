<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Total extends Mage_Adminhtml_Block_Template
{
    protected $cart = null;
	
	public function __construct()
	{
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
	
	public  function getBaseTotal()
    {
        $cart = $this->getCart();
        $items = $cart->getItems();
        $total = 0;
        
        if($items)
        {
            foreach ($items->getData() as $item) 
            {
               $total  += $item['base_price'];
            }
          $cart->total = $total;
          $cart->save();
        }
      	
        return $total;
    }   
    public  function getShippingCharges()
    {
        $cart = $this->getCart();
        if($cart)
        {   
            return $cart->shipping_amount;
        }
        return 0;
    }

    public function getGrantTotal()
    {
        return $this->getBaseTotal() + $this->getShippingCharges();

    }
}
?>