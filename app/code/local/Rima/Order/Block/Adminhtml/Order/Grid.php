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
//            //$query = $collection->getSelect()

//            $collection->getSelect()->join( array('order_address'=> 'order_address'),
// 'order_address.order_id = main_table.order_id',
// array('order_address.customer_firstname','order_address.customer_lastname')->WHERE('order_address.address_type =?''billing');
//             // ->join([ 'order_address'=>'order_address'],
//             //     'order_address.order_id = main_table.order_id',
//             //     ['order_address.customer_firstname','order_address.customer_lastname'])
//             //  ->where('order_address.address_type = ? ','billing');
          
//           echo $collection->getSelect();
//           die();  
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

    // public function getRowUrl($row)
    // {
    //     if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
    //         return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
    //     }
    //     return false;
    // }

    

    // public function _prepareCollection(){
    //     $model =  Mage::getModel('order/order_address')->getCollection();
    //     $model = Mage::getModel('order/order')->getCollection();
    //     $model->addFieldToSelect('first_name');
    //     $model->getselect()
    //         // ->reset(Zend_Db_Select::COLUMNS)
    //         ->columns(['first_name' => 'COA.first_name'])
    //         ->from('ccc_order_address as COA')
    //         ->where('COA.order_id = ?', 'main_table.order_id');
    //     echo $model->getselect();
    //     die();
    //     $this->setCollection($model);
    //     return parent::_prepareCollection();
    // }

    

}
