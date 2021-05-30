<?php
class Rima_Order_Model_Cart_Address extends Mage_Core_Model_Abstract
{
	protected $cart = null;
	protected $billingAddress = null;
	protected $shippingAddress = null;

	Const ADDRESS_TYPE_BILLING = 'billing';
	Const ADDRESS_TYPE_SHIPPING = 'shipping';

    protected function _construct()
    {
        $this->_init('order/cart_address');
        
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

    public function setBillingAddress(Rima_Order_Model_Cart_Address $address)
	{
		$this->billingAddress = $address;
		return $this;
	}
	public function getBillingAddress()
	{
		
		if(!$this->addressId)
		{
			return false;
		}

		$address = \Mage::getModel('order/cart_address');
		$cartBillingCollection = $address->getCollection();
      	$select = $cartBillingCollection->getSelect()
        ->reset(Zend_Db_Select::FROM)
        ->reset(Zend_Db_Select::COLUMNS)
        ->from('cart_address')
        ->where('address_id = ?', $this->address_id)
        ->where('address_type = ?', 'billing');
        
        $cartBillingAddress = $cartBillingCollection->fetchItem($select);
		$this->setBillingAddress($cartBillingAddress);
		return $this->address;


	}

	public function setShippingAddress(Rima_Order_Model_Cart_Address $address)
	{
		$this->shippingAddress = $address;
		return $this;
	}
	public function getShippingAddress()
	{
		
		if(!$this->addressId)
		{
			return false;
		}

		$address = \Mage::getModel('order/cart_address');
		$cartShippingCollection = $address->getCollection();
      	$select = $cartShippingCollection->getSelect()
        ->reset(Zend_Db_Select::FROM)
        ->reset(Zend_Db_Select::COLUMNS)
        ->from('cart_address')
        ->where('address_id = ?', $this->address_id)
        ->where('address_type = ?', 'shipping');
        
        $cartShippingCollection = $cartShippingCollection->fetchItem($select);
		$this->setBillingAddress($cartShippingCollection);
		return $this->address;


	}

}


?>