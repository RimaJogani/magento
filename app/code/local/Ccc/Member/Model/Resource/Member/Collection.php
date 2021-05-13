<?php
/**
 * 
 */
class Ccc_Member_Model_Resource_Member_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('member');
		parent::__construct();
		
	}
}

?>