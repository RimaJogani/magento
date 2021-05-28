<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Paymentmethod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	public function __construct()
    {
        parent::__construct();
    }

    public function getPayemntMethodTitle()
    {
    	$methods = Mage::getModel('payment/config');
    	$activemethod = $methods->getActiveMethods();
    	unset($activemethod['paypal_billing_agreement']);
    	unset($activemethod['checkmo']);
    	unset($activemethod['free']);
    	return $activemethod;
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
    
}
?>