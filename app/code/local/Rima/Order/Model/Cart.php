<?php
class Rima_Order_Model_Cart extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('order/cart');
        
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
	
}

	
?>
