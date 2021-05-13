<?php

class Rima_Sony_Model_Resource_Sony extends Mage_Core_Model_Resource_Db_Abstract 
{
    protected function _construct()
    {
        $this->_init('sony/sony','sony_id');
    }
}



?>