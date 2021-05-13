<?php

class Rima_Sony_Block_Adminhtml_Sony_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs 
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sony_id');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sony')->__('Sony Information')); 
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section',array(
            'label'=> Mage::helper('sony')->__('Sony Data'),
            'title'=> Mage::helper('sony')->__('Sony Data'),
            'content' =>$this->getLayout()->createBlock('sony/adminhtml_sony_edit_tab_form')->toHtml()

        ));
        
        return parent::_beforeToHtml();
    }
}


?>