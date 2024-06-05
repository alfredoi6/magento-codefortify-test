<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Setup\Declaration\Schema\Dto;

use Magento\Framework\App\ResourceConnection;

/**
 * Schema DTO element.
 *
 * Aggregation root for all structural elements. Provides access to tables by their names.
 *
 * @api
 */
class Schema
{
    /**
     * Get resource connection.
     *
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * Schema tables.
     *
     * @var Table[]
     */
    private $tables;

    /**
     * declared tables.
     *
     * @var array
     */
    private $tablesWithJsonTypeField = [];

    /**
     * Schema constructor.
     *
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
        $this->tables = [];
    }

    /**
     * Retrieve all tables, that are presented in schema.
     *
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * Add table by name key to tables registry.
     *
     * @param  Table $table
     * @return $this
     */
    public function addTable(Table $table)
    {
        $this->tables[$table->getName()] = $table;
        return $this;
    }

    /**
     * Retrieve table by it name.
     *
     * Return false if table is not present in schema.
     *
     * @param string $name
     * @return bool|Table
     */
    public function getTableByName($name)
    {
        $name = $this->resourceConnection->getTableName($name);
        return $this->tables[$name] ?? false;
    }

    /**
     * Get tables name with JSON type fields.
     *
     * @return array
     */
    public function getTablesWithJsonTypeField(): array
    {
        return $this->tablesWithJsonTypeField;
    }

    /**
     * Set tables name with JSON type fields.
     *
     * @param array $tablesWithJsonTypeField
     * @return array
     */
    public function setTablesWithJsonTypeField(array $tablesWithJsonTypeField): array
    {
        return $this->tablesWithJsonTypeField = $tablesWithJsonTypeField;
    }
}
