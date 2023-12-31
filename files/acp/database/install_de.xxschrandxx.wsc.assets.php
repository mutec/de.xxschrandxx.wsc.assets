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
    DatabaseTable::create('assets1_asset')
        ->columns([
            ObjectIdDatabaseTableColumn::create('assetID'),
            NotNullInt10DatabaseTableColumn::create('categoryID'),
            VarcharDatabaseTableColumn::create('title')
                ->length(20)
                ->notNull(),
            VarcharDatabaseTableColumn::create('legacyID')
                ->length(50),
            NotNullInt10DatabaseTableColumn::create('amount'),
            DefaultFalseBooleanDatabaseTableColumn::create('canBeBorrowed'),
            DefaultFalseBooleanDatabaseTableColumn::create('isBorrowed'),
            IntDatabaseTableColumn::create('locationID'),
            IntDatabaseTableColumn::create('userID'),
            NotNullInt10DatabaseTableColumn::create('lastModifiedDate'),
            NotNullInt10DatabaseTableColumn::create('time'),
        ])
        ->indices([
            DatabaseTablePrimaryIndex::create()
                ->columns(['assetID']),
                DatabaseTableIndex::create('legacyID')
                    ->type(DatabaseTableIndex::UNIQUE_TYPE)
                    ->columns(['legacyID']),

        ])
        ->foreignKeys([
            DatabaseTableForeignKey::create()
                ->columns(['categoryID'])
                ->onDelete('CASCADE')
                ->referencedColumns(['categoryID'])
                ->referencedTable('assets1_category'),
            DatabaseTableForeignKey::create()
                ->columns(['locationID'])
                ->onDelete('SET NULL')
                ->referencedColumns(['locationID'])
                ->referencedTable('assets1_location'),
            DatabaseTableForeignKey::create()
                ->columns(['userID'])
                ->onDelete('SET NULL')
                ->referencedColumns(['userID'])
                ->referencedTable('wcf1_user'),
        ]),
    DatabaseTable::create('assets1_category')
        ->columns([
            ObjectIdDatabaseTableColumn::create('categoryID'),
            VarcharDatabaseTableColumn::create('title')
                ->length(20)
                ->notNull(),
            TextDatabaseTableColumn::create('description'),
            NotNullInt10DatabaseTableColumn::create('time'),
        ])
        ->indices([
            DatabaseTablePrimaryIndex::create()
                ->columns(['categoryID']),
        ]),
    DatabaseTable::create('assets1_location')
        ->columns([
            ObjectIdDatabaseTableColumn::create('locationID'),
            VarcharDatabaseTableColumn::create('title')
                ->length(20)
                ->notNull(),
            TextDatabaseTableColumn::create('address')
                ->notNull(),
            NotNullInt10DatabaseTableColumn::create('time'),
        ])
        ->indices([
            DatabaseTablePrimaryIndex::create()
                ->columns(['locationID']),
        ]),
];
