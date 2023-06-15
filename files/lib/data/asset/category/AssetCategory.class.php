<?php

namespace assets\data\asset\category;

use DateTime;
use wcf\data\DatabaseObject;

class AssetCategory extends DatabaseObject
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
