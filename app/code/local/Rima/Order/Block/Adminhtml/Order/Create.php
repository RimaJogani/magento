<?php

class Rima_Order_Block_Adminhtml_Order_Create extends Mage_Adminhtml_Block_Template
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getHeaderText()
    {
    	return $this->_headerText = 'Create New Order';
    }

}
