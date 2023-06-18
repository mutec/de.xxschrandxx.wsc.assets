<?php

namespace assets\data\asset\location;

use DateTimeImmutable;
use wcf\data\DatabaseObject;
use wcf\data\ITitledObject;

/**
 * @property    int     $locationID
 * @property    string  $title
 * @property    string  $address
 * @property    int     $time
 */
class AssetLocation extends DatabaseObject implements ITitledObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'location';

    /**
     * Returns title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns address
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Returns createdTimestamp
     * @return int
     */
    public function getCreatedTimestamp(): int
    {
        return $this->time;
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
