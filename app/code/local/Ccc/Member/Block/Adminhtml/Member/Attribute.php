<?php

class Ccc_Member_Block_Adminhtml_Member_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
    	$this->_blockGroup = 'member';
        $this->_controller = 'adminhtml_member_attribute';
        $this->_headerText = Mage::helper('member')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('member')->__('Add New Attribute');
        parent::__construct();
    }

}
