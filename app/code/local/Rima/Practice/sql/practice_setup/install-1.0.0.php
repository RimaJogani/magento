<?php
//echo "<pre>";
$installer = $this;
$installer->startSetUp();
//echo $installer->getTable('practice/practice');
$table = $installer->getConnection()
    ->newTable($installer->getTable('practice/practice'))
    ->addColumn('practice_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Practice Id')
    ->addColumn('first_name',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'First Name')
    ->addColumn('last_name',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Last Name');
//print_r($table);   
$installer->getConnection()->createTable($table);
$installer->endSetup();

?>