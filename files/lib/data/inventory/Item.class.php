<?php

namespace wcf\data\inventory;

use DateTime;
use InvalidArgumentException;
use wcf\data\DatabaseObject;
use wcf\data\user\User;

class Item extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'inventory';

    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'itemID';

    /**
     * Returns title
     * @return ?string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns legacyID
     * @return ?string
     */
    public function getLegacyID()
    {
        return $this->legacyID;
    }

    /**
     * Returns weather can be borrowed
     * @return ?bool
     */
    public function canBeBorrowed()
    {
        return $this->canBeBorrowed;
    }

    /**
     * Returns weather borroewd
     * @return ?bool
     */
    public function isBorrowed()
    {
        return $this->borrowed;
    }

    /**
     * Returns locationID
     * @return ?int
     * @throws InvalidArgumentException If the Item is borrowed
     */
    public function getLocationID()
    {
        if ($this->isBorrowed()) {
            throw new InvalidArgumentException('Item is borrowed.');
        }
        return $this->locationID;
    }

    /**
     * Returns ItemLocation
     * @return ?ItemLocation
     * @throws InvalidArgumentException If the Item is borrowed
     */
    public function getLocation()
    {
        return new ItemLocation($this->getLocationID());
    }

    /**
     * Returns userID
     * @return ?int
     * @throws InvalidArgumentException If the Item is not borrowed
     */
    public function getUserID()
    {
        if (!$this->isBorrowed()) {
            throw new InvalidArgumentException('Item is borrowed.');
        }
        return $this->userID;
    }

    /**
     * Returns User
     * @return ?User
     * @throws InvalidArgumentException If the Item is not borrowed
     */
    public function getUser()
    {
        return new User($this->getUserID());
    }

    /**
     * Returns categoryID
     * @return ?int
     */
    public function getCategoryID()
    {
        return $this->categoryID;
    }

    /**
     * Returns ItemCategory
     * @return ?ItemCategory
     */
    public function getCategory()
    {
        return new ItemCategory($this->getCategoryID());
    }

    /**
     * Returns lastModifiedTimestamp
     * @return ?int
     */
    public function getLastModifiedTimestamp()
    {
        return $this->lastModifiedDate;
    }

    /**
     * Returns last modified date
     * @return ?DateTime
     */
    public function getLastModified()
    {
        return new DateTime($this->getCreatedTimestamp());
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
