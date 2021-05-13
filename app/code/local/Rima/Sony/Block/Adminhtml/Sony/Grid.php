<?php

class Rima_Sony_Block_Adminhtml_Sony_Grid extends Mage_Adminhtml_Block_widget_Grid 
{
    public function __construct()
    {
        
        parent::__construct();
        $this->setId('sonyGrid');
        $this->setDefaultSort('sony_id');
        $this->setDefaultDir('Asc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sony/sony')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    protected function _prepareColumns()
    {
        
        $this->addColumn('sony_id',array(
            'header' => Mage::helper('sony')->__('id'),
            'width' => '20px',
            'index' => 'sony_id'

         ));
         $this->addColumn('first_name',array(
            'header' => Mage::helper('sony')->__('First Name'),
            'width' => '50px',
            'index' => 'first_name'

         ));
         $this->addColumn('last_name',array(
            'header' => Mage::helper('sony')->__('Last Name'),
            'width' => '50px',
            'index' => 'last_name'

         ));

         parent::_prepareColumns();
         return $this;
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid',array('_current' => true));
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit',array(
            'id' => $row->getId()
         ));
    }

}


?>