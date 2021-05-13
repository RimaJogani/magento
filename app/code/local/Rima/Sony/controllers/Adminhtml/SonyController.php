<?php

class Rima_Sony_Adminhtml_SonyController extends Mage_Adminhtml_Controller_Action 
{
    
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title('Sony Grid');
        $this->_setActiveMenu('sony');
        $this->_addContent($this->getLayout()->createBlock('sony/adminhtml_sony'));
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        try
        {
            $id = (int) $this->getRequest()->getParam('id');
            $sony = Mage::getModel('sony/sony')->load($id);
            if($id && !$sony->getId())
            {
                throw new Exception('id not available', 1);
            }
            
            Mage::register('sony_data',$sony);
            $this->loadLayout();
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('sony/adminhtml_sony_edit'))
                ->_addLeft($this->getLayout()->createBlock('sony/adminhtml_sony_edit_tabs'));
            $this->renderlayout();
        }
        catch(Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
       

    }
    public function saveAction()
    {
        try
        {
            if(!$this->getRequest()->isPost())
            {
                throw new Exception("invalid Request", 1);
            }
            $id = (int) $this->getRequest()->getParam('id');
            $sony = Mage::getModel('sony/sony')->load($id);
            if($id && !$sony->getId())
            {
                throw new Exception('id not available', 1);
            }
            $sonyData = $this->getRequest()->getPost('sony');
            $sony->setData($sonyData);
            if($id)
            {
                $sony->setId($id);
            }
            if(!$sony->save())
            {
                throw new Exception("Dtabase Insertion error", 1);
            }
            Mage::getSingleton('adminhtml/session')->addSuccess("successfully insert");

        }
        catch(Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        try
        {
            $id = (int) $this->getRequest()->getParam('id');
            $sony = Mage::getModel('sony/sony')->load($id);
            if($id && !$sony->getId())
            {
                throw new Exception('id not available', 1);
            }
            if(!$sony->delete())
            {
                throw new Exception("DataBase Error", 1);
                
            }
            Mage::getSingleton('adminhtml/session')->addSuccess("successfully delete");

        }
        catch(Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
        
    }
}

?>


