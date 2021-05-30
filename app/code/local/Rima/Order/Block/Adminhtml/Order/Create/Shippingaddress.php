<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Shippingaddress extends Mage_Adminhtml_Block_Template
{
	
	protected $cart = null;
    
    public function __construct()
      {
          parent::__construct();
      }
      
      public function setCart($cart)
      {
        $this->cart = $cart;
        return $this;
      }

    public function getCart()
    {
        if(!$this->cart){
            throw new Exception("Cart not found");
        }
        return $this->cart;
    }
      public function getShippingAddress()
      {
          
          $address = $this->getCart()->getShippingAddress();
          if($address->getId())
          {
            return $address;
          }
          $customerAddress = $this->getCart()->getCustomer()->getShippingAddress();
          //print_r($customerAddress);die();
          if($customerAddress == null)
          {
            return $address;
          }
         return $customerAddress;
    }

    public function getCountryName()
    {
        $countryCollection = Mage::getModel('directory/country_api')->items();
        return $countryCollection;
    }

}
?>