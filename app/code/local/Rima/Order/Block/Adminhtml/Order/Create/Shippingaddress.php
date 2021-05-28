<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Shippingaddress extends Mage_Adminhtml_Block_Template
{
	
	public function __construct()
    {
        // $this->_controller = 'adminhtml_order_create_shippingaddress';
        // $this->_blockGroup = 'order';
        parent::__construct();
    }
     public function getShippingAddress()
    {
      $customerId = $this->getRequest()->getParam('id');

      //echo "<pre>";
      
      $cart = $this->getCart();
      if($cart)
      {
        $cartId = $cart->getId();
      }
        $cartShippingAddress = Mage::getModel('order/cart_address');
        $cartShippingCollection = $cartShippingAddress->getCollection();
        $select = $cartShippingCollection->getSelect()
        ->reset(Zend_Db_Select::FROM)
        ->reset(Zend_Db_Select::COLUMNS)
        ->from('cart_address')
        ->where('cart_id = ?', $cartId)
        ->where('address_type = ?', 'shipping');
        
        $cartShippingAddress = $cartShippingCollection->fetchItem($select);
        
      if($cartShippingAddress)
      {
        return $cartShippingAddress;
      }
      else if($customerId)
      { 
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $cutomerShippingAddress = $customer->getDefaultShippingAddress();
        //print_r($cutomerShippingAddress->getData());die();
        return $cutomerShippingAddress;
      }
      else
      {
          return Mage::getModel('order/cart_address');
      }
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
        // if($cartData)
        // {
        //   $cartId = $cartData->getId();
        // }
        return $cartData;
    }

    public function getCountryName()
    {
        $countryCollection = Mage::getModel('directory/country_api')->items();
        return $countryCollection;
    }

}
?>