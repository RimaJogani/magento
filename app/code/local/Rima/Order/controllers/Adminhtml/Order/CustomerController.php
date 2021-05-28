<?php

class Rima_Order_Adminhtml_Order_CustomerController extends Mage_Adminhtml_Controller_Action
{
   
    public function indexAction()
    {
        $this->loadLayout();

        $this->_setActiveMenu('order')
            ->renderLayout();
    }


    
    

    
}
