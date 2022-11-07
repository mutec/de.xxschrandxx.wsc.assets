<?php

use wcf\system\database\table\column\DefaultFalseBooleanDatabaseTableColumn;
use wcf\system\database\table\column\IntDatabaseTableColumn;
use wcf\system\database\table\column\NotNullInt10DatabaseTableColumn;
use wcf\system\database\table\column\ObjectIdDatabaseTableColumn;
use wcf\system\database\table\column\TextDatabaseTableColumn;
use wcf\system\database\table\column\VarcharDatabaseTableColumn;
use wcf\system\database\table\DatabaseTable;
use wcf\system\database\table\index\DatabaseTableForeignKey;
use wcf\system\database\table\index\DatabaseTableIndex;
use wcf\system\database\table\index\DatabaseTablePrimaryIndex;

return [
    DatabaseTable::create('wcf1_inventory')
        ->columns([
            ObjectIdDatabaseTableColumn::create('itemID'),
            NotNullInt10DatabaseTableColumn::create('categoryID'),
            VarcharDatabaseTableColumn::create('title')
                ->length(20),
            VarcharDatabaseTableColumn::create('legacyID')
                ->length(50),
            NotNullInt10DatabaseTableColumn::create('amount'),
            DefaultFalseBooleanDatabaseTableColumn::create('canBeBorrowed'),
            DefaultFalseBooleanDatabaseTableColumn::create('borrowed'),
            IntDatabaseTableColumn::create('locationID'),
            IntDatabaseTableColumn::create('userID'),
            NotNullInt10DatabaseTableColumn::create('lastModifiedDate'),
            NotNullInt10DatabaseTableColumn::create('creationDate')
        ])
        ->indices([
            DatabaseTablePrimaryIndex::create()
                ->columns(['itemID']),
                DatabaseTableIndex::create('legacyID')
                    ->type(DatabaseTableIndex::UNIQUE_TYPE)
                    ->columns(['legacyID'])

        ])
        ->foreignKeys([
            DatabaseTableForeignKey::create()
                ->columns(['categoryID'])
                ->onDelete('CASCADE')
                ->referencedColumns(['categoryID'])
                ->referencedTable('wcf1_inventory_category'),
            DatabaseTableForeignKey::create()
                ->columns(['locationID'])
                ->onDelete('SET NULL')
                ->referencedColumns(['locationID'])
                ->referencedTable('wcf1_inventory_location'),
            DatabaseTableForeignKey::create()
                ->columns(['userID'])
                ->onDelete('SET NULL')
                ->referencedColumns(['userID'])
                ->referencedTable('wcf1_user')
        ]),
    DatabaseTable::create('wcf1_inventory_category')
        ->columns([
            ObjectIdDatabaseTableColumn::create('categoryID'),
            VarcharDatabaseTableColumn::create('title')
                ->length(20),
            TextDatabaseTableColumn::create('description'),
            NotNullInt10DatabaseTableColumn::create('creationDate')
        ])
        ->indices([
            DatabaseTablePrimaryIndex::create()
                ->columns(['categoryID'])
        ]),
    DatabaseTable::create('wcf1_inventory_location')
        ->columns([
            ObjectIdDatabaseTableColumn::create('locationID'),
            VarcharDatabaseTableColumn::create('title')
                ->length(20),
            TextDatabaseTableColumn::create('address')
                ->notNull(),
            NotNullInt10DatabaseTableColumn::create('creationDate')
        ])
        ->indices([
            DatabaseTablePrimaryIndex::create()
                ->columns(['locationID'])
        ])
];
