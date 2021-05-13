<?php
class Ccc_Member_Block_Adminhtml_Member extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'member';
        $this->_controller = 'adminhtml_member';
        $this->_headerText = $this->__('manage member');
        parent::__construct();

    }
}
