<?php

class Rima_Practice_Block_Adminhtml_Practice_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceGrid');
        $this->setDefaultSort('practice_id');
        $this->setDefaultDir('Asc');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
        $this->setVarNameFilter('practice_filter');

     }
     protected function _prepareCollection()
     {
        $collection = Mage::getModel('practice/practice')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
     }
     protected function _prepareColumns()
     {
         $this->addColumn('practice_id',array(
            'header' => Mage::helper('practice')->__('id'),
            'width' => '20px',
            'index' => 'practice_id'

         ));
         $this->addColumn('first_name',array(
            'header' => Mage::helper('practice')->__('First Name'),
            'width' => '50px',
            'index' => 'first_name'

         ));
         $this->addColumn('last_name',array(
            'header' => Mage::helper('practice')->__('Last Name'),
            'width' => '50px',
            'index' => 'last_name'

         ));
         $this->addColumn('action',
         array(
             'header'   => Mage::helper('practice')->__('Action'),
             'width'    => '50px',
             'type'     => 'action',
             'getter'   => 'getId',
             'actions'  => array(
                 array(
                     'caption' => Mage::helper('practice')->__('Delete'),
                     'url'     => array(
                         'base' => '*/*/delete'),
                     'field' => 'id'
                     ),
                  array(
                     'caption' => Mage::helper('practice')->__('Edit'),
                     'url'     => array(
                           'base' => '*/*/edit'),
                     'field' => 'id'
                  )
               )
         ));

         parent::_prepareColumns();
         return $this;
     }
     public function getGridUrl()
     {
        return $this->getUrl('*/*/index',array('_current' => true));
     }
     public function getRowUrl($row)
     {
         return $this->getUrl('*/*/edit',array(
            'id' => $row->getId(),
            '_current' => true
         ));
     }
}
?>