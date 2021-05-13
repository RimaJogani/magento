<?php

class Rima_Practice_Block_Adminhtml_Practice extends Mage_Adminhtml_Block_widget_Grid_Container 
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_practice';
        $this->_blockGroup = 'practice';
        $this->_headerText = 'Manage Practice';
        $this->_addButtonLabel = 'Add Practice';
        return parent::__construct();

    }
}


?>