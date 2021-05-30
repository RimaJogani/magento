<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Cartitem extends Mage_Adminhtml_Block_Template
{
	
	public function __construct()
    {	
    	// $this->_blockGroup = 'order';
     //    $this->_controller = 'adminhtml_order_create_cartitem';
        parent::__construct();
    }
  //   public function cartData()
  //   {
  //   	//echo "<pre>";
  //   	$customerId = $this->getRequest()->getParam('id');
  //   	$cart = Mage::getModel('order/cart');

  //     $cartCollection = $cart->getCollection();
  //     $select = $cartCollection->getSelect()
  //       ->reset(Zend_Db_Select::FROM)
  //       ->reset(Zend_Db_Select::COLUMNS)
  //       ->from('cart')
  //       ->where('customer_id = ?', $customerId);

  //     $cartData = $cartCollection->fetchItem($select);
  //     if($cartData)
  //     {
  //       $cartId = $cartData->getId();
  //     }
    	

  //   	$cartItem = Mage::getModel('order/cart_item');
  //   	$cartItemollection = $cartItem->getCollection();
  //   	$cartItemollection->getSelect()
  //   		->reset(Zend_Db_Select::FROM)
  //   		->reset(Zend_Db_Select::COLUMNS)
  //   		->from('cart_item')
  //   		->where('cart_id = ?', $cartId);
		// //echo $cartItemollection->getSelect();
  //   return $cartItemollection;	
  //   }
}
?>