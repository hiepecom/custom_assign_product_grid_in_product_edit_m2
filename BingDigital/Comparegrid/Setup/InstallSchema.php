<?php

namespace BingDigital\Comparegrid\Setup;

use Magento\Backend\Block\Widget\Tab;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $CustomTable = $installer->getConnection()
            ->newTable($installer->getTable('assign_compare_product'))
            ->addColumn('id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true])

            ->addColumn('product_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => true, 'default' => 0])

            ->addColumn('assign_product_id',
                Table::TYPE_TEXT,
                5000,
                ['nullable' => false, 'default' => '']);

        $installer->getConnection()->createTable($CustomTable);

        $installer->endSetup();
    }
}