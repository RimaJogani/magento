<?php


class Rima_Sony_Block_Adminhtml_Sony_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form  
{
    public function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldSet = $form->addFieldSet('sony_form',array(
            'legend' => Mage::helper('sony')->__('Sony Information')
        ));
        $fieldSet->addfield('first_name','text',array(
            'label' => Mage::helper('sony')->__('FirstName'),
            'class' =>'required-entry',
            'required' =>true,
            'name' => 'sony[first_name]'
        ));
        $fieldSet->addfield('last_name','text',array(
            'label' => Mage::helper('sony')->__('LastName'),
            'class' =>'required-entry',
            'required' =>true,
            'name' => 'sony[last_name]'
        ));

        if(Mage::getSingleton('adminhtml/session')->getSonyData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSonyData());
            Mage::getSingleton('adminhtml/session')->setsonyData(null);
        }
        else if( Mage::registry('sony_data'))
        {
            $form->setValues( Mage::registry('sony_data')->getData());
        
        }
        return parent::_prepareForm();
    }
}


?>