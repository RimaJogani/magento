<?php

class Rima_Sony_Block_Adminhtml_Sony_Edit extends Mage_Adminhtml_Block_Widget_Form_Container 
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'sony_id';
        $this->_blockGroup = 'sony';
        $this->_controller = 'adminhtml_sony';
        $this->_updateButton('save','label',Mage::helper('sony')->__("Save Pratice"));
        $this->_updateButton('delete','label',Mage::helper('sony')->__("Detele"));
    }
    public function getHeaderText()
    {
        if(Mage::registry('sony_data') && Mage::registry('sony_data')->getId())
        {
            return Mage::helper('sony')->__('Edit Sony');
        }
        else
        {
             return Mage::helper('sony')->__('Add Sony');
 
        } 
    }
}


?>