<?php

namespace assets\data\asset\location;

use DateTimeImmutable;
use wcf\data\DatabaseObject;

class AssetLocation extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'location';

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

    /**
     * Returns address
     * @return ?string
     */
    public function getAddress()
    {
        return $this->address;
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
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->getCreatedTimestamp());
    }
}
