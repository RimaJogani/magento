<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Total extends Mage_Adminhtml_Block_Template
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function getCart()
    {

      $customerId = $this->getRequest()->getParam('id');
      $cart = Mage::getModel('order/cart');
      $cartCollection = $cart->getCollection();
        $select = $cartCollection->getSelect()
        ->reset(Zend_Db_Select::FROM)
        ->reset(Zend_Db_Select::COLUMNS)
        ->from('cart')
        ->where('customer_id = ?', $customerId);
        $cartData = $cartCollection->fetchItem($select);
        
        return $cartData;
    }
	public  function getBaseTotal()
    {

        $cart = $this->getCart();
        if($cart)
        {
       		$cartId = $cart->getId();
        }
       	$cartItem = Mage::getModel('order/cart_item');
      	$cartItemCollection = $cart->getCollection();
        $cartItemCollection->getSelect()
        ->reset(Zend_Db_Select::FROM)
        ->reset(Zend_Db_Select::COLUMNS)
        ->from('cart_item')
        ->where('cart_id = ?', $cartId);
        //$cartItemData = $cartCollection->fetchItem($select);
        
        $total = 0;
        //print_r($cartItemCollection->getData());
        if($cartItemCollection)
        {

            foreach ($cartItemCollection->getData() as $item) 
            {
            	//print_r($item->base_price);
               $total  += $item['base_price'];
            }
          $cart->total = $total;
          $cart->save();
          //print_r($cart);
        }
      	
        return $total;


    }   
    public  function getShippingCharges()
    {
        $cart = $this->getCart();
        //print_r($cart);die();
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