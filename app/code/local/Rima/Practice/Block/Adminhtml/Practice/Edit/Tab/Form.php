<?php


class Rima_Practice_Block_Adminhtml_Practice_Edit_Tab_Form extends Mage_Adminhtml_Block_widget_Form 
{
    public function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldSet = $form->addFieldSet('practice_form',array(
            'legend' => Mage::helper('practice')->__('Practice Information')
        ));
        $fieldSet->addfield('first_name','text',array(
            'label' => Mage::helper('practice')->__('FirstName'),
            'class' =>'required-entry',
            'required' =>true,
            'name' => 'practice[first_name]'
        ));
        $fieldSet->addfield('last_name','text',array(
            'label' => Mage::helper('practice')->__('LastName'),
            'class' =>'required-entry',
            'required' =>true,
            'name' => 'practice[last_name]'
        ));

        if(Mage::getSingleton('adminhtml/session')->getPracticeData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getPracticeData());
            Mage::getSingleton('adminhtml/session')->setPracticeData(null);
        }
        else if( Mage::registry('practice_data'))
        {
            $form->setValues( Mage::registry('practice_data')->getData());
        
        }
        return parent::_prepareForm();
    }
}


?>