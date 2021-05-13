<?php

class Rima_practice_Block_Adminhtml_Practice_Edit_Tabs extends Mage_Adminhtml_Block_widget_Tabs 
{
    public function __construct()
    {
       parent::__construct();
       $this->setId('practice_id');
       $this->setDestElementId('edit_form');
       $this->setTitle(Mage::helper('practice')->__('Practice Information'));

    }
    public function _beforeToHtml()
    {
        $this->addTab('form_section',array(
            'label'=> Mage::helper('practice')->__('Practice Data'),
            'title'=> Mage::helper('practice')->__('Practice Data'),
            'content' =>$this->getLayout()->createBlock('practice/adminhtml_practice_edit_tab_form')->toHtml()

        ));
        return parent::_beforeToHtml();
    }
}



?>