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

class ReplPrice
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table_name = $setup->getTable( 'ls_replication_repl_price' ); 
        if(!$setup->tableExists($table_name)) {
        	$table = $setup->getConnection()->newTable( $table_name );
        	$table->addColumn('repl_price_id', Table::TYPE_INTEGER, NULL, 
        	                    [ 'identity' => TRUE, 'primary' => TRUE,
        	                      'unsigned' => TRUE, 'nullable' => FALSE, 'auto_increment'=> TRUE ]);
        	$table->addColumn('scope', Table::TYPE_TEXT, 8);
        	$table->addColumn('scope_id', Table::TYPE_INTEGER, 11);
        	$table->addColumn('processed', Table::TYPE_BOOLEAN, null, [ 'default' => 0 ], 'Flag to check if data is already copied into Magento. 0 means needs to be copied into Magento tables & 1 means already copied');
        	$table->addColumn('is_updated', Table::TYPE_BOOLEAN, null, [ 'default' => 0 ], 'Flag to check if data is already updated from Omni into Magento. 0 means already updated & 1 means needs to be updated into Magento tables');
        	$table->addColumn('CurrencyCode' , Table::TYPE_TEXT, '');
        	$table->addColumn('CustomerDiscountGroup' , Table::TYPE_TEXT, '');
        	$table->addColumn('EndingDate' , Table::TYPE_TEXT, '');
        	$table->addColumn('IsDeleted' , Table::TYPE_BOOLEAN, '');
        	$table->addColumn('ItemId' , Table::TYPE_TEXT, '');
        	$table->addColumn('LoyaltySchemeCode' , Table::TYPE_TEXT, '');
        	$table->addColumn('MinimumQuantity' , Table::TYPE_FLOAT, '');
        	$table->addColumn('ModifyDate' , Table::TYPE_TEXT, '');
        	$table->addColumn('PriceInclVat' , Table::TYPE_BOOLEAN, '');
        	$table->addColumn('Priority' , Table::TYPE_INTEGER, '');
        	$table->addColumn('QtyPerUnitOfMeasure' , Table::TYPE_FLOAT, '');
        	$table->addColumn('SaleCode' , Table::TYPE_TEXT, '');
        	$table->addColumn('SaleType' , Table::TYPE_INTEGER, '');
        	$table->addColumn('StartingDate' , Table::TYPE_TEXT, '');
        	$table->addColumn('StoreId' , Table::TYPE_TEXT, '');
        	$table->addColumn('UnitOfMeasure' , Table::TYPE_TEXT, '');
        	$table->addColumn('UnitPrice' , Table::TYPE_FLOAT, '');
        	$table->addColumn('UnitPriceInclVat' , Table::TYPE_FLOAT, '');
        	$table->addColumn('VATPostGroup' , Table::TYPE_TEXT, '');
        	$table->addColumn('VariantId' , Table::TYPE_TEXT, '');
        	$table->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT ], 'Created At');
        	$table->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE ], 'Updated At');
        	$setup->getConnection()->createTable( $table );
        } else {
        	$connection = $setup->getConnection();
        	if ($connection->tableColumnExists($table_name, 'CurrencyCode' ) === false) {
        		$connection->addColumn($table_name, 'CurrencyCode', ['type' => Table::TYPE_TEXT, 'comment' => 'CurrencyCode']);
        	}
        	if ($connection->tableColumnExists($table_name, 'CustomerDiscountGroup' ) === false) {
        		$connection->addColumn($table_name, 'CustomerDiscountGroup', ['type' => Table::TYPE_TEXT, 'comment' => 'CustomerDiscountGroup']);
        	}
        	if ($connection->tableColumnExists($table_name, 'EndingDate' ) === false) {
        		$connection->addColumn($table_name, 'EndingDate', ['type' => Table::TYPE_TEXT, 'comment' => 'EndingDate']);
        	}
        	if ($connection->tableColumnExists($table_name, 'IsDeleted' ) === false) {
        		$connection->addColumn($table_name, 'IsDeleted', ['type' => Table::TYPE_BOOLEAN, 'comment' => 'IsDeleted']);
        	}
        	if ($connection->tableColumnExists($table_name, 'ItemId' ) === false) {
        		$connection->addColumn($table_name, 'ItemId', ['type' => Table::TYPE_TEXT, 'comment' => 'ItemId']);
        	}
        	if ($connection->tableColumnExists($table_name, 'LoyaltySchemeCode' ) === false) {
        		$connection->addColumn($table_name, 'LoyaltySchemeCode', ['type' => Table::TYPE_TEXT, 'comment' => 'LoyaltySchemeCode']);
        	}
        	if ($connection->tableColumnExists($table_name, 'MinimumQuantity' ) === false) {
        		$connection->addColumn($table_name, 'MinimumQuantity', ['type' => Table::TYPE_FLOAT, 'comment' => 'MinimumQuantity']);
        	}
        	if ($connection->tableColumnExists($table_name, 'ModifyDate' ) === false) {
        		$connection->addColumn($table_name, 'ModifyDate', ['type' => Table::TYPE_TEXT, 'comment' => 'ModifyDate']);
        	}
        	if ($connection->tableColumnExists($table_name, 'PriceInclVat' ) === false) {
        		$connection->addColumn($table_name, 'PriceInclVat', ['type' => Table::TYPE_BOOLEAN, 'comment' => 'PriceInclVat']);
        	}
        	if ($connection->tableColumnExists($table_name, 'Priority' ) === false) {
        		$connection->addColumn($table_name, 'Priority', ['type' => Table::TYPE_INTEGER, 'comment' => 'Priority']);
        	}
        	if ($connection->tableColumnExists($table_name, 'QtyPerUnitOfMeasure' ) === false) {
        		$connection->addColumn($table_name, 'QtyPerUnitOfMeasure', ['type' => Table::TYPE_FLOAT, 'comment' => 'QtyPerUnitOfMeasure']);
        	}
        	if ($connection->tableColumnExists($table_name, 'SaleCode' ) === false) {
        		$connection->addColumn($table_name, 'SaleCode', ['type' => Table::TYPE_TEXT, 'comment' => 'SaleCode']);
        	}
        	if ($connection->tableColumnExists($table_name, 'SaleType' ) === false) {
        		$connection->addColumn($table_name, 'SaleType', ['type' => Table::TYPE_INTEGER, 'comment' => 'SaleType']);
        	}
        	if ($connection->tableColumnExists($table_name, 'StartingDate' ) === false) {
        		$connection->addColumn($table_name, 'StartingDate', ['type' => Table::TYPE_TEXT, 'comment' => 'StartingDate']);
        	}
        	if ($connection->tableColumnExists($table_name, 'StoreId' ) === false) {
        		$connection->addColumn($table_name, 'StoreId', ['type' => Table::TYPE_TEXT, 'comment' => 'StoreId']);
        	}
        	if ($connection->tableColumnExists($table_name, 'UnitOfMeasure' ) === false) {
        		$connection->addColumn($table_name, 'UnitOfMeasure', ['type' => Table::TYPE_TEXT, 'comment' => 'UnitOfMeasure']);
        	}
        	if ($connection->tableColumnExists($table_name, 'UnitPrice' ) === false) {
        		$connection->addColumn($table_name, 'UnitPrice', ['type' => Table::TYPE_FLOAT, 'comment' => 'UnitPrice']);
        	}
        	if ($connection->tableColumnExists($table_name, 'UnitPriceInclVat' ) === false) {
        		$connection->addColumn($table_name, 'UnitPriceInclVat', ['type' => Table::TYPE_FLOAT, 'comment' => 'UnitPriceInclVat']);
        	}
        	if ($connection->tableColumnExists($table_name, 'VATPostGroup' ) === false) {
        		$connection->addColumn($table_name, 'VATPostGroup', ['type' => Table::TYPE_TEXT, 'comment' => 'VATPostGroup']);
        	}
        	if ($connection->tableColumnExists($table_name, 'VariantId' ) === false) {
        		$connection->addColumn($table_name, 'VariantId', ['type' => Table::TYPE_TEXT, 'comment' => 'VariantId']);
        	}
        }
    }


}

