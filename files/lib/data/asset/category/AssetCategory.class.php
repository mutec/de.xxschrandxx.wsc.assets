<?php

namespace assets\data\asset\category;

use DateTimeImmutable;
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
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->getCreatedTimestamp());
    }
}
