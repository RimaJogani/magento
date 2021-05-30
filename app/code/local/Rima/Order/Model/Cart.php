<?php
class Rima_Order_Model_Cart extends Mage_Core_Model_Abstract
{
	protected $customer = null;
	protected $items = null;
	protected $billingAddress = null;
	protected $shippingAddress = null;
    protected function _construct()
    {
        $this->_init('order/cart');
        
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
		if(!$this->cartId){
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
		if(!$this->cartId){
			return false;
		}
		$address =  Mage::getModel('order/cart_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('cart_id', ['eq' => $this->cartId])
			->addFieldToFilter('address_type', ['eq' => Rima_Order_Model_Cart_Address::ADDRESS_TYPE_BILLING]);
		$address = $addressCollection->getFirstItem();
		
		return $address;		
	}


    public function addItemToCart($product,$quantity,$addMode = false)
	{
		$cartId = $this->cart_id;
		//print_r($product->getId());die();
		$cartItem = Mage::getModel('order/cart_item');
		$cartItemCollection = $cartItem->getCollection();
		$select = $cartItemCollection->getSelect()
			->reset(Zend_Db_Select::FROM)
			->reset(Zend_Db_Select::COLUMNS)
			->from('cart_item')
			->where('product_id = ?',$product->entity_id)
			->where('cart_id = ?',$cartId);
		//echo $select;	
		$cartItem = $cartItemCollection->fetchItem($select);
		//print_r($cartItem);
		if($cartItem)
		{	
			$cartItem->quantity = $quantity + $cartItem->quantity;
			$cartItem->base_price = $cartItem->quantity * $cartItem->price;
			$cartItem->save();
			return true;
		}
		
		$cartItem = \Mage::getModel('order/cart_item');
		$cartItem->cartId = $cartId;
		$cartItem->product_id = $product->entity_id;
		$cartItem->sku = $product->sku;
		$cartItem->name = $product->name;
		$cartItem->price = $product->price;
		$cartItem->quantity = $quantity;
		//$cartItem->discount = $product->productDiscount * $quantity ;
		$cartItem->base_price = $quantity * $product->price ;

		$cartItem->created_at = date('Y-m-d H:i:s');
		//print_r($cartItem);die();
		$cartItem->save();
	}

	public function setItems(Rima_Order_Model_Resource_Cart_Item_Collection $items)
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
		if(!$this->cartId)
		{
			return false;
		}
		$item = Mage::getModel('order/cart_item');
		$itemCollections = $item->getCollection()
			->addFieldToFilter('cart_id', ['eq' => $this->getCartId()]);
      	//print_r($itemCollections);
        if($itemCollections)
        {
        	$this->setItems($itemCollections);
        }
		return $this->items;
		
	}

	public function setShippingAddress(Rima_Order_Model_Cart_Address $shippingAddress){
		$this->shippingAddress = $shippingAddress;
		return $this;
	}

	public function getShippingAddress(){
		if($this->shippingAddress){
			return $this->shippingAddress;
		}
		if(!$this->cartId){
			return false;
		}
		$address =  Mage::getModel('order/cart_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('cart_id', ['eq' => $this->cartId])
			->addFieldToFilter('address_type', ['eq' => Rima_Order_Model_Cart_Address::ADDRESS_TYPE_SHIPPING]);
		$address = $addressCollection->getFirstItem();
		return $address;		
	}
	
}

	
?>
