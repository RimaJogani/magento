<?php

class Rima_Order_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
    }


    protected function _prepareCollection()
    {
        $collection = Mage::getModel('order/order')->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
        
    }

    protected function _prepareColumns()
    {

        $this->addColumn('order_id', array(
            'header'=> Mage::helper('order')->__('Order #'),
            'type'=>'number',
            'index' => 'order_id',
        ));
        
        $this->addColumn('firstname', array(
            'header' => Mage::helper('order')->__('First Name'),
            'index' => 'firstname',
        ));

        $this->addColumn('lastname', array(
            'header' => Mage::helper('order')->__('Last Name'),
            'index' => 'lastname',
        ));
        
        $this->addColumn('total', array(
            'header' => Mage::helper('order')->__('Total'),
            'index' => 'total',
        ));
         $this->addColumn('shipping_amount', array(
            'header' => Mage::helper('order')->__('Shipping Amount'),
            'index' => 'shipping_amount',
        ));
         $this->addColumn('payment_method_code', array(
            'header' => Mage::helper('order')->__('Payment Method Code'),
            'index' => 'payment_method_code',
        ));
        $this->addColumn('created at', array(
            'header' => Mage::helper('order')->__('Created At'),
            'index' => 'created_at',
        ));

        
        return parent::_prepareColumns();
    }


}
