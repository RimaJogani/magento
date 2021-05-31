<?php

/**
 * 
 */
class Rima_Order_Block_Adminhtml_Order_Create_Account extends Mage_Adminhtml_Block_Template
{
	
	public function __construct()
    {
        parent::__construct();
    	
    }
    public function getCustomer()
    {	
    	$id = $this->getRequest()->getParam('id');
    	if(!$id)
    	{
    		throw new Exception("Id Invalid", 1);
    	}
    	$customer = Mage::getModel('customer/customer')->load($id);

    	return $customer;
    }
}
?>