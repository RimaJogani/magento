<?php

class Rima_Order_Model_Resource_Cart_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract 
{
    protected function _construct()
    {
        $this->_init('order/cart');
        
    }
}



?>


