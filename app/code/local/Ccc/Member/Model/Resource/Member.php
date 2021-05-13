<?php
/**
 * 
 */
class Ccc_Member_Model_Resource_Member extends Mage_Eav_Model_Entity_Abstract
{

	const ENTITY = 'member';
	
	public function __construct()
	{

		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');

	   parent::__construct();
    }

}

?>