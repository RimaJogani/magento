<?php

class Ccc_Member_Block_Adminhtml_Member_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'member';
        $this->_controller = 'adminhtml_member';
        parent::__construct();
    }
}
