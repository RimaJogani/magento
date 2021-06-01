<?php

class Rima_Order_Block_Adminhtml_Order_View extends Mage_Adminhtml_Block_Template
{
	protected $order = null;
    public function __construct()
    {
        parent::__construct();
    }
    public function setOrder($order){
        $this->order = $order;
        return $this;
    }

    public function getOrder(){
        if(!$this->order){
            throw new Exception("Order not found");
        }
        return $this->order;
    }
    public function getCountryName()
      {
        
          $countryCollection = Mage::getModel('directory/country_api')->items();
          
          return $countryCollection;
        
      }
}
?>