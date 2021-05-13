<?php

class Ccc_Member_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_Member';

    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('member/attribute');
    }
}