<?php
$installer = $this;
$installer->startSetUp();
$table = $installer->getConnection()
    ->newTable($installer->getTable('sony/sony'))
    ->addColumn('sony_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Sony Id')
    ->addColumn('first_name',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'First Name')
    ->addColumn('last_name',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Last Name');
$installer->getConnection()->createTable($table);
$installer->endSetup();

?>