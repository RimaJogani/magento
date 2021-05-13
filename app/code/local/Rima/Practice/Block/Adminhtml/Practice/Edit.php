<?php


class Rima_Practice_Block_Adminhtml_Practice_Edit extends Mage_Adminhtml_Block_widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'practice_id';
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_practice';
        $this->_updateButton('save','label',Mage::helper('practice')->__("Save Practice"));
        $this->_updateButton('delete','label',Mage::helper('practice')->__("Detele"));

    }
    public function getHeaderText()
    {
       if(Mage::registry('practice_data') && Mage::registry('practice_data')->getId())
       {
           return Mage::helper('practice')->__('Edit Practice');
       }
       else
       {
            return Mage::helper('practice')->__('Add Practice');

       }
    }
}


?>