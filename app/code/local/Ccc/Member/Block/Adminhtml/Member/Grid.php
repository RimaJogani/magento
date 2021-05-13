<?php

class Ccc_Member_Block_Adminhtml_Member_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('memberGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
        $this->setVarNameFilter('member_filter');

    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        $store = $this->_getStore();

        $collection = Mage::getModel('member/member')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('phoneNo');

        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection->joinAttribute(
            'firstname',
            'member/firstname',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $collection->joinAttribute(
            'lastname',
            'member/lastname',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'email',
            'member/email',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
       

        $collection->joinAttribute(
            'id',
            'member/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => 'Id',
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('firstname',
            array(
                'header' => Mage::helper('member')->__('First Name'),
                'width'  => '50px',
                'index'  => 'firstname',
            ));

        $this->addColumn('lastname',
            array(
                'header' => Mage::helper('member')->__('Last Name'),
                'width'  => '50px',
                'index'  => 'lastname',
            ));

        $this->addColumn('email',
            array(
                'header' => Mage::helper('member')->__('Email'),
                'width'  => '50px',
                'index'  => 'email',
            ));

       
        $this->addColumn('action',
            array(
                'header'   => Mage::helper('member')->__('Action'),
                'width'    => '50px',
                'type'     => 'action',
                'getter'   => 'getId',
                'actions'  => array(
                    array(
                        'caption' => Mage::helper('member')->__('Delete'),
                        'url'     => array(
                            'base' => '*/*/delete',
                        ),
                        'field'   => 'id',
                    ),
                ),
                'filter'   => false,
                'sortable' => false,
            ));

        parent::_prepareColumns();
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/index', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'store' => $this->getRequest()->getParam('store'),
            'id'    => $row->getId())
        );
    }
}
