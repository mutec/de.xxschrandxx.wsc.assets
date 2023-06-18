<?php

namespace assets\data\asset\category;

use DateTime;
use wcf\data\DatabaseObject;
use wcf\data\ITitledObject;

/**
 * @property-read   int         $categoryID
 * @property-read   string      $title
 * @property-read   string|null $description
 * @property-read   int         $creationDate
 */
class AssetCategory extends DatabaseObject implements ITitledObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'category';

    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'categoryID';

    /**
     * Returns title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns createdTimestamp
     * @return int
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
