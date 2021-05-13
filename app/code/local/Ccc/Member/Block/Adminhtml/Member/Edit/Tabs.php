<?php

class Ccc_Member_Block_Adminhtml_Member_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{


    public function __construct()
    {
      parent::__construct();
      $this->setId('tab_id');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('member')->__('member Information'));
    }
    public function getMember()
    {
        return Mage::registry('current_member');
    }

    protected function _beforeToHtml()
    {

        $memberAttributes = Mage::getResourceModel('member/member_attribute_collection');

        if (!$this->getMember()->getId()) {
            foreach ($memberAttributes as $attribute) {
                $default = $attribute->getDefaultValue();
                if ($default != '') {
                    $this->getMember()->setData($attribute->getAttributeCode(), $default);
                }
            }
        }

        $attributeSetId = $this->getMember()->getResource()->getEntityType()->getDefaultAttributeSetId();



        // $attributeSetId = 21;
        
        $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->setAttributeSetFilter($attributeSetId)
            ->setSortOrder()
            ->load();

        $defaultGroupId = 0;
        foreach ($groupCollection as $group) {
            if ($defaultGroupId == 0 or $group->getIsDefault()) {
                $defaultGroupId = $group->getId();
            }

        }	


        foreach ($groupCollection as $group) {
            $attributes = array();
            foreach ($memberAttributes as $attribute) {
                if ($this->getMember()->checkInGroup($attribute->getId(),$attributeSetId, $group->getId())) {
                    $attributes[] = $attribute;
                }
            }

            if (!$attributes) {
                continue;
            }

            $active = $defaultGroupId == $group->getId();
            $block = $this->getLayout()->createBlock('member/adminhtml_member_edit_tab_attributes')
                ->setGroup($group)
                ->setAttributes($attributes)
                ->setAddHiddenFields($active)
                ->toHtml();
            $this->addTab('group_' . $group->getId(), array(
                'label'     => Mage::helper('member')->__($group->getAttributeGroupName()),
                'content'   => $block,
                'active'    => $active
            ));
        }
      return parent::_beforeToHtml();
    }
}
