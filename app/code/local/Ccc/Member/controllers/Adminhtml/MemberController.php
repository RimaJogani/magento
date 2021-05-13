<?php

class Ccc_Member_Adminhtml_MemberController extends Mage_Adminhtml_Controller_Action
{

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('member/member');
    }

    public function indexAction()
    {
        
        $this->loadLayout();
        $this->_setActiveMenu('member');
        $this->_title('member Grid');

        $this->_addContent($this->getLayout()->createBlock('member/adminhtml_member'));
        $this->renderLayout();

    }

    protected function _initMember()
    {
        $this->_title($this->__('member'))
            ->_title($this->__('Manage members'));

        $memberId = (int) $this->getRequest()->getParam('id');
        $member   = Mage::getModel('member/member')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($memberId);

        Mage::register('current_member', $member);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $member;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $memberId = (int) $this->getRequest()->getParam('id');
        $member   = $this->_initMember();

        if ($memberId && !$member->getId()) {
            $this->_getSession()->addError(Mage::helper('member')->__('This member no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($member->getName());

        $this->loadLayout();

        $this->_setActiveMenu('member/member');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();

    }

    public function saveAction()
    {

        try {

            $memberData = $this->getRequest()->getPost('account');

            $member = Mage::getSingleton('member/member');

            if ($memberId = $this->getRequest()->getParam('id')) {

                if (!$member->load($memberId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

            }

            $member->addData($memberData);

            $member->save();

            Mage::getSingleton('core/session')->addSuccess("member data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }

    }

    public function deleteAction()
    {
        try {

            $memberModel = Mage::getModel('member/member');

            if (!($memberId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$memberModel->load($memberId)) {
                throw new Exception('member does not exist');
            }

            if (!$memberModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The member has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}
