<?php

$installer = $this;

$installer->startSetup();

$installer->addEntityType(Ccc_Member_Model_Resource_Member::ENTITY, [
    'entity_model'                => 'member/member',
    'attribute_model'             => 'member/resource_eav_attribute',
    'table'                       => 'member/member',
    'increment_per_store'         => '0',
    'additional_attribute_table'  => 'member/eav_attribute',
    'entity_attribute_collection' => 'member/member_attribute_collection',
]);

$installer->createEntityTables('member');
$installer->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('member', 'Default');

$installer->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'member'");



$installer->endSetup();

?>