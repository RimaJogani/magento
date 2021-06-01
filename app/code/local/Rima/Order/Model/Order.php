<?php
class Rima_Order_Model_Order extends Mage_Core_Model_Abstract
{
	protected $customer = null;
	protected $items = null;
	protected $billingAddress = null;
	protected $shippingAddress = null;
    protected function _construct()
    {
        $this->_init('order/order');
        
    }
    public function setCustomer(Rima_Order_Model_Customer $customer)
    {
		$this->customer = $customer;
		return $this;
	}

	public function getCustomer()
	{	
		
		if($this->customer){
			return $this->customer;
		}
		if(!$this->getOrderId()){
			return false;
		}
		$customer =  Mage::getModel('customer/customer')->load($this->getCustomerId());
		if($customer)
		{
			$this->setCustomer($customer);
		}
		return $customer;		
	}
	
	public function setBillingAddress(Rima_Order_Model_Cart_Address $billingAddress)
	{
		$this->billingAddress = $billingAddress;
		return $this;
	}

	public function getBillingAddress()
	{
		if($this->billingAddress){
			return $this->billingAddress;
		}
		if(!$this->orderId){
			return false;
		}
		$address =  Mage::getModel('order/order_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('order_id', ['eq' => $this->orderId])
			->addFieldToFilter('address_type', ['eq' => Rima_Order_Model_Order_Address::ADDRESS_TYPE_BILLING]);
		$address = $addressCollection->getFirstItem();
		
		return $address;		
	}
	public function setItems(Rima_Order_Model_Resource_Order_Item_Collection $items)
	{
		$this->items=$items;
		return $this;
	}

	public function getItems()
	{
		if($this->items)
		{
			return $this->items;
		}
		if(!$this->orderId)
		{
			return false;
		}
		$item = Mage::getModel('order/order_item');
		$itemCollections = $item->getCollection()
			->addFieldToFilter('order_id', ['eq' => $this->getOrderId()]);
        if($itemCollections)
        {
        	$this->setItems($itemCollections);
        }
		return $this->items;
		
	}

	public function setShippingAddress(Rima_Order_Model_Order_Address $shippingAddress){
		$this->shippingAddress = $shippingAddress;
		return $this;
	}

	public function getShippingAddress(){
		if($this->shippingAddress){
			return $this->shippingAddress;
		}
		if(!$this->orderId){
			return false;
		}
		$address =  Mage::getModel('order/order_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('order_id', ['eq' => $this->orderId])
			->addFieldToFilter('address_type', ['eq' => Rima_Order_Model_Order_Address::ADDRESS_TYPE_SHIPPING]);
		$address = $addressCollection->getFirstItem();
		return $address;		
	}
}


?>