<?php

class Rima_Order_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {

        $this->_controller = 'adminhtml_customer';
        $this->_headerText = Mage::helper('order')->__('Customer');
        $this->_blockGroup = 'order';
        parent::__construct();
        $this->_removeButton("add");
        
    }
    
    

}
