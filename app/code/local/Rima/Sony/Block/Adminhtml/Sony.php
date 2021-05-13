<?php

class Rima_Sony_Block_Adminhtml_Sony extends Mage_Adminhtml_Block_widget_Grid_Container 
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_sony';
        $this->_blockGroup = 'sony';
        $this->_headerText = 'Manage Sony';
        $this->_addButtonLabel = 'Add Sony';
        return parent::__construct();
    }
}


?>