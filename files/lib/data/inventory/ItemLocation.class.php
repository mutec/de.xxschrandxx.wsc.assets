<?php

namespace wcf\data\inventory;

use DateTime;
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
    * @return ?DateTime
    */
   public function getCreatdDate()
   {
       return new DateTime($this->getCreatedTimestamp());
   }
}
