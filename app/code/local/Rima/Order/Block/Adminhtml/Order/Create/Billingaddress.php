  <?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Billingaddress extends Mage_Adminhtml_Block_Template
{
  	protected $cart = null;
    
  	public function __construct()
      {
          parent::__construct();
      }
      public function getCountryName()
      {
        
          $countryCollection = Mage::getModel('directory/country_api')->items();
          
          return $countryCollection;
        
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
      public function getBillingAddress()
      {
          
          $address = $this->getCart()->getBillingAddress();
          if($address->getId())
          {
            return $address;
          }
          $customerAddress = $this->getCart()->getCustomer()->getBillingAddress();
          //print_r($customerAddress);die();
          if($customerAddress == null)
          {
            return $address;
          }
         return $customerAddress;
    }

    
}
?>