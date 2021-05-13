<?php

class Rima_Practice_Adminhtml_PracticeController extends Mage_AdminHtml_Controller_Action 
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title('Practice Grid');
        $this->_setActiveMenu('practice');
       
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_practice'));
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
            $practice = Mage::getModel('practice/practice')->load($id);
            if($id && !$practice->getId())
            {
                throw new Exception('id not available', 1);
            }
            
            Mage::register('practice_data',$practice);
            $this->loadLayout();
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_practice_edit'))
                ->_addLeft($this->getLayout()->createBlock('practice/adminhtml_practice_edit_tabs'));
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
            $practice = Mage::getModel('practice/practice')->load($id);
            if($id && !$practice->getId())
            {
                throw new Exception('id not available', 1);
            }
            $practiceData = $this->getRequest()->getPost('practice');
            $practice->setData($practiceData);
            if($id)
            {
                $practice->setId($id);
            }
            if(!$practice->save())
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
            $practice = Mage::getModel('practice/practice')->load($id);
            if($id && !$practice->getId())
            {
                throw new Exception('id not available', 1);
            }
            if(!$practice->delete())
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