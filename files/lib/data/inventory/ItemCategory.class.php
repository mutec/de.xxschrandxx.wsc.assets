<?php

namespace wcf\data\inventory;

use DateTime;
use wcf\data\DatabaseObject;

class ItemCategory extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'inventory_category';

    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'categoryID';

    /**
     * Returns title
     * @return ?string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns createdTimestamp
     * @return ?int
     */
    public function getCreatedTimestamp()
    {
        return $this->creationDate;
    }

    /**
     * Returns creation date
     * @return ?DateTime
     */
    public function getCreatdDate()
    {
        return new DateTime($this->getCreatedTimestamp());
    }
}
