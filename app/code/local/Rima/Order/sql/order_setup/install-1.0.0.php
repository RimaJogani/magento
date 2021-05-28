<?php

$installer = $this;
$installer->startSetUp();

//Table Cart
$cartTable = $installer->getConnection()
    ->newTable($installer->getTable('order/cart'))
    ->addColumn('cart_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Cart Id')
    ->addColumn('customer_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Customer Id')
    ->addColumn('quantity',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable' => false
    ),'Quantity')
    ->addColumn('total',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Total')
    ->addColumn('customer_group_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false
    ),'Customer Group Id')
    ->addColumn('customer_firstname',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Customer FirstName')
    ->addColumn('customer_lastname',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Customer LastName')
    ->addColumn('shipping_amount',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Shipping Amount')
    ->addColumn('shipping_method_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Shipping Method Code')
    ->addColumn('payment_method_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Payment Method Code')
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Created At')
    ->addColumn('updated_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Updated At');

   
$installer->getConnection()->createTable($cartTable);

//Table Cart Address
$cartAddressTable = $installer->getConnection()
    ->newTable($installer->getTable('order/cart_address'))
    ->addColumn('address_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Cart Address Id')
    ->addColumn('cart_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Cart Id')
    ->addColumn('customer_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Customer Id')
    ->addColumn('firstname',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'First Name')
    ->addColumn('lastname',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Last Name')
    ->addColumn('save_in_address_book',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false
    ),'Save In Address Book')

    ->addColumn('same_as_billing',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false
    ),'Same As Billing')
    ->addColumn('address_type',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Address Type')
    ->addColumn('street',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Address')
    ->addColumn('city',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'City')
    ->addColumn('region',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'State')
    ->addColumn('country_id',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Country Id')
    ->addColumn('postcode',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable' => false
    ),'Zipcode');
    
$installer->getConnection()->createTable($cartAddressTable);


//cart_item
$cartItemTable = $installer->getConnection()
    ->newTable($installer->getTable('order/cart_item'))
    ->addColumn('item_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Cart Item Id')
    ->addColumn('cart_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
    ),'Cart Id')
    ->addColumn('product_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
    ),'Product Id')
    ->addColumn('sku',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false,
    ),'SKU')
    ->addColumn('name',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false,
    ),'name')
    ->addColumn('quantity',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false
    ),'Quantity')
    ->addColumn('base_price',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Base Price')
    ->addColumn('price',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Price')
    ->addColumn('discount',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Discount')
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Created At')
    ->addColumn('updated_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Updated At');
    
$installer->getConnection()->createTable($cartItemTable);
 
 //Table Order
$orderTable = $installer->getConnection()
    ->newTable($installer->getTable('order/order'))
    ->addColumn('order_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Order Id')
    ->addColumn('customer_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Customer Id')
   
    ->addColumn('discount',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Discount')
    ->addColumn('total',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Total')
    ->addColumn('shipping_amount',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Shipping Amount')
    ->addColumn('shipping_method_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Shipping Method Code')
    ->addColumn('payment_method_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Payment Method Code')
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Created At')
    ->addColumn('updated_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Updated At');

   
$installer->getConnection()->createTable($orderTable);  


//order address
$orderAddressTable = $installer->getConnection()
    ->newTable($installer->getTable('order/order_address'))
    ->addColumn('address_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Order Address Id')
    ->addColumn('order_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Order Id')
    ->addColumn('customer_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Customer Id')
     ->addColumn('customer_firstname',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false,
        
    ),'Customer Firstname')
    ->addColumn('customer_lastname',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false,
        
    ),'Customer Lastname')
    ->addColumn('cart_address_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Cart Address Id')
    ->addColumn('address_type',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Address Type')
    ->addColumn('same_as_billing',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false
    ),'Same As Billing')
    ->addColumn('address',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Address')
    ->addColumn('city',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'City')
    ->addColumn('region',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'State')
    ->addColumn('country_id',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false
    ),'Country Id')
    ->addColumn('postcode',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable' => false
    ),'Zipcode');
    
$installer->getConnection()->createTable($orderAddressTable);
   
 
//order_item
$orderItemTable = $installer->getConnection()
    ->newTable($installer->getTable('order/order_item'))
    ->addColumn('item_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' =>true
    ),'Order Item Id')
    ->addColumn('order_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Cart Id')
    ->addColumn('product_id',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false,
        
    ),'Product Id')
    ->addColumn('quantity',Varien_Db_Ddl_Table::TYPE_SMALLINT,null,array(
        'nullable' => false
    ),'Quantity')
    ->addColumn('sku',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false,
    ),'SKU')
    ->addColumn('name',Varien_Db_Ddl_Table::TYPE_VARCHAR,null,array(
        'nullable' => false,
    ),'Name')
    ->addColumn('base_price',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Base Price')
    ->addColumn('price',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Address Type')
    ->addColumn('discount',Varien_Db_Ddl_Table::TYPE_DECIMAL,null,array(
        'nullable' => false
    ),'Discount')
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Created At')
    ->addColumn('updated_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable' => false
    ),'Updated At');
    
$installer->getConnection()->createTable($orderItemTable);



$installer->endSetup();

?>