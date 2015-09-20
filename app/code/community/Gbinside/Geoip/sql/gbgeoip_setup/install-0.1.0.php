<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('gbgeoip/cache'))
    ->addColumn(
        'id',
        Varien_Db_Ddl_Table::TYPE_BIGINT,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        )
    )
    ->addColumn(
        'ip',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        25,
        array(
            'nullable' => false,
        )
    )
    ->addColumn(
        'country_code',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false,
        )
    )
    ->addColumn(
        'country_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'region_code',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'city',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'zipcode',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'latitude',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'longitude',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'metro_code',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'area_code',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(
            'nullable' => false,
        ),
        'Created At'
    )

    ->addIndex(
        $installer->getIdxName(
            'gbgeoip/cache',
            array('ip'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('ip'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )

    ->setComment('Geoip Cache Table');


$installer->getConnection()->createTable($table);
$installer->endSetup();