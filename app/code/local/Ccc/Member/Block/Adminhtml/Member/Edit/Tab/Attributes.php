<?php

class Ccc_Member_Block_Adminhtml_Member_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Widget_Form
{

    public function getMember()
    {
        return Mage::registry('current_member');
    }


    protected function _prepareLayout()
    {
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        parent::_prepareLayout();
           
    }

    protected function _prepareForm()
    {

        $group = $this->getGroup();

        $attributes = $this->getAttributes();

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $form->setDataObject($this->getMember());
        $form->setHtmlIdPrefix('group_' . $group->getId());
        $form->setFieldNameSuffix('account');
        $fieldset = $form->addFieldset('fieldset_group_' . $group->getId(), array(
            'legend'    => Mage::helper('member')->__($group->getAttributeGroupName()),
            'class'     => 'fieldset',
        ));


        $this->_setFieldset($attributes, $fieldset);

        $form->addValues($this->getMember()->getData());

        return parent::_prepareForm();
    }


}
