  <?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Billingaddress extends Mage_Adminhtml_Block_Template
{
	protected $cart = null;
	public function __construct()
    {
        // $this->_controller = 'adminhtml_order_create_billingaddress';
        // $this->_blockGroup = 'order';
        parent::__construct();
    }
    public function getBillingAddress()
    {
    	$customerId = $this->getRequest()->getParam('id');

      //echo "<pre>";
    	
      $cart = $this->getCart();
      if($cart)
      {
        $cartId = $cart->getId();
      }
	  	  $cartBillingAddress = Mage::getModel('order/cart_address');
      	$cartBillingCollection = $cartBillingAddress->getCollection();
      	$select = $cartBillingCollection->getSelect()
        ->reset(Zend_Db_Select::FROM)
        ->reset(Zend_Db_Select::COLUMNS)
        ->from('cart_address')
        ->where('cart_id = ?', $cartId)
        ->where('address_type = ?', 'billing');
        
        $cartBillingAddress = $cartBillingCollection->fetchItem($select);
        
	  	if($cartBillingAddress)
	  	{
	  	 	return $cartBillingAddress;
	  	}
	  	else if($customerId)
	  	{	
    		$customer = Mage::getModel('customer/customer')->load($customerId);
	  		$cutomerBillingAddress = $customer->getDefaultBillingAddress();
        //print_r($cutomerBillingAddress->getData());die();
	  	 	return $cutomerBillingAddress;
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
        
        return $cartData;
    }

    public function getCountryName()
    {
      
        $countryCollection = Mage::getModel('directory/country_api')->items();
        
        return $countryCollection;
      
    }

    
}
?>