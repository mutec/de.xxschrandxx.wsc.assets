<?php

namespace assets\data\asset;

use assets\data\asset\category\AssetCategory;
use assets\data\asset\location\AssetLocation;
use DateTime;
use InvalidArgumentException;
use wcf\data\DatabaseObject;
use wcf\data\user\User;
use wcf\data\user\UserProfile;

class Asset extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'assets';

    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'assetID';

    /**
     * Returns title
     * @return ?string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns description
     * @return ?string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Returns amount
     * @return ?int
     */
    public function getAmount()
    {
        return $this->amount;
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
     * @throws InvalidArgumentException If the Asset is borrowed
     */
    public function getLocationID()
    {
        if ($this->isBorrowed()) {
            throw new InvalidArgumentException('Asset is borrowed.');
        }
        return $this->locationID;
    }

    /**
     * Returns AssetLocation
     * @return ?AssetLocation
     * @throws InvalidArgumentException If the Asset is borrowed
     */
    public function getLocation()
    {
        return new AssetLocation($this->getLocationID());
    }

    /**
     * Returns userID
     * @return ?int
     * @throws InvalidArgumentException If the Asset is not borrowed
     */
    public function getUserID()
    {
        if (!$this->isBorrowed()) {
            throw new InvalidArgumentException('Asset is borrowed.');
        }
        return $this->userID;
    }

    /**
     * Returns User
     * @return ?User
     * @throws InvalidArgumentException If the Asset is not borrowed
     */
    public function getUser()
    {
        return new User($this->getUserID());
    }

    /**
     * Returns user Profile
     * @return ?UserProfile
     * @throws InvalidArgumentException If the Asset is not borrowed
     */
    public function getUserProfile()
    {
        return new UserProfile($this->getUser());
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
     * Returns AssetCategory
     * @return ?AssetCategory
     */
    public function getCategory()
    {
        return new AssetCategory($this->getCategoryID());
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