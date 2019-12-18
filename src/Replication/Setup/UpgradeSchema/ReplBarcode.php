<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Replication\Setup\UpgradeSchema;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class ReplBarcode
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table_name = $setup->getTable( 'ls_replication_repl_barcode' ); 
        if(!$setup->tableExists($table_name)) {
        	$table = $setup->getConnection()->newTable( $table_name );
        	$table->addColumn('repl_barcode_id', Table::TYPE_INTEGER, 11, [ 'identity' => TRUE, 'primary' => TRUE, 'unsigned' => TRUE, 'nullable' => FALSE, 'auto_increment'=> TRUE ]);
        	$table->addColumn('scope', Table::TYPE_TEXT, 8);
        	$table->addColumn('scope_id', Table::TYPE_INTEGER, 11);
        	$table->addColumn('processed', Table::TYPE_BOOLEAN, 1, [ 'default' => 0 ], 'Flag to check if data is already copied into Magento. 0 means needs to be copied into Magento tables & 1 means already copied');
        	$table->addColumn('is_updated', Table::TYPE_BOOLEAN, 1, [ 'default' => 0 ], 'Flag to check if data is already updated from Omni into Magento. 0 means already updated & 1 means needs to be updated into Magento tables');
        	$table->addColumn('is_failed', Table::TYPE_BOOLEAN, 1, [ 'default' => 0 ], 'Flag to check if data is already added from Flat into Magento successfully or not. 0 means already added successfully & 1 means failed to add successfully into Magento tables');
        	$table->addColumn('Blocked' , Table::TYPE_INTEGER, 11);
        	$table->addColumn('Description' , Table::TYPE_TEXT, '');
        	$table->addColumn('nav_id' , Table::TYPE_TEXT, '');
        	$table->addColumn('IsDeleted' , Table::TYPE_BOOLEAN, 1);
        	$table->addColumn('ItemId' , Table::TYPE_TEXT, '');
        	$table->addColumn('UnitOfMeasure' , Table::TYPE_TEXT, '');
        	$table->addColumn('VariantId' , Table::TYPE_TEXT, '');
        	$table->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT ], 'Created At');
        	$table->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE ], 'Updated At');
        	$setup->getConnection()->createTable( $table );
        } else {
        	$connection = $setup->getConnection();
        	if ($connection->tableColumnExists($table_name, 'Blocked' ) === false) {
        		$connection->addColumn($table_name, 'Blocked', ['length' => 11,'default' => null,'type' => Table::TYPE_INTEGER, 'comment' => 'Blocked']);
        	} else {
        		$connection->modifyColumn($table_name, 'Blocked', ['length' => 11,'default' => null,'type' => Table::TYPE_INTEGER, 'comment' => 'Blocked']);
        	}
        	if ($connection->tableColumnExists($table_name, 'Description' ) === false) {
        		$connection->addColumn($table_name, 'Description', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'Description']);
        	} else {
        		$connection->modifyColumn($table_name, 'Description', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'Description']);
        	}
        	if ($connection->tableColumnExists($table_name, 'nav_id' ) === false) {
        		$connection->addColumn($table_name, 'nav_id', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'Nav_id']);
        	} else {
        		$connection->modifyColumn($table_name, 'nav_id', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'Nav_id']);
        	}
        	if ($connection->tableColumnExists($table_name, 'IsDeleted' ) === false) {
        		$connection->addColumn($table_name, 'IsDeleted', ['length' => 1,'default' => 0,'type' => Table::TYPE_BOOLEAN, 'comment' => 'IsDeleted']);
        	} else {
        		$connection->modifyColumn($table_name, 'IsDeleted', ['length' => 1,'default' => 0,'type' => Table::TYPE_BOOLEAN, 'comment' => 'IsDeleted']);
        	}
        	if ($connection->tableColumnExists($table_name, 'ItemId' ) === false) {
        		$connection->addColumn($table_name, 'ItemId', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'ItemId']);
        	} else {
        		$connection->modifyColumn($table_name, 'ItemId', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'ItemId']);
        	}
        	if ($connection->tableColumnExists($table_name, 'UnitOfMeasure' ) === false) {
        		$connection->addColumn($table_name, 'UnitOfMeasure', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'UnitOfMeasure']);
        	} else {
        		$connection->modifyColumn($table_name, 'UnitOfMeasure', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'UnitOfMeasure']);
        	}
        	if ($connection->tableColumnExists($table_name, 'VariantId' ) === false) {
        		$connection->addColumn($table_name, 'VariantId', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'VariantId']);
        	} else {
        		$connection->modifyColumn($table_name, 'VariantId', ['length' => '','default' => null,'type' => Table::TYPE_TEXT, 'comment' => 'VariantId']);
        	}
        	if ($connection->tableColumnExists($table_name, 'is_failed' ) === false) {
        		$connection->addColumn($table_name, 'is_failed', ['length' => 1,'default' => 0,'type' => Table::TYPE_BOOLEAN, 'comment' => 'Is_failed']);
        	} else {
        		$connection->modifyColumn($table_name, 'is_failed', ['length' => 1,'default' => 0,'type' => Table::TYPE_BOOLEAN, 'comment' => 'Is_failed']);
        	}
        }
    }


}

