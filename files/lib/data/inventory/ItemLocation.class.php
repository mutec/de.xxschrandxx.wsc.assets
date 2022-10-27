<?php

namespace wcf\data\inventory;

use wcf\data\DatabaseObject;

class ItemLocation extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'inventory_location';

    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'locationID';

    /**
     * Returns title
     * @return ?string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
