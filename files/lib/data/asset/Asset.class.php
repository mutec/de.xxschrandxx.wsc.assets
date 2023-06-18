<?php

namespace assets\data\asset;

use assets\data\asset\category\AssetCategory;
use assets\data\asset\location\AssetLocation;
use DateTimeImmutable;
use InvalidArgumentException;
use wcf\data\DatabaseObject;
use wcf\data\ITitledObject;
use wcf\data\user\User;
use wcf\data\user\UserProfile;

/**
 * @property    int         $assetID
 * @property    int         $categoryID
 * @property    string      $title
 * @property    string|null $legacyID
 * @property    int         $amount
 * @property    int         $canBeBorrowed
 * @property    int         $borrowed
 * @property    int|null    $locationID
 * @property    int|null    $userID
 * @property    int         $lastModifiedDate
 * @property    int         $creationDate
 */
class Asset extends DatabaseObject implements ITitledObject
{
    /**
     * Returns title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns legacyID
     * @return ?string
     */
    public function getLegacyID(): ?string
    {
        return $this->legacyID;
    }

    /**
     * Returns amount
     * @return ?int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Returns weather can be borrowed
     * @return bool
     */
    public function canBeBorrowed(): bool
    {
        return (bool)$this->canBeBorrowed;
    }

    /**
     * Returns weather borroewd
     * @return bool
     */
    public function isBorrowed(): bool
    {
        return (bool)$this->borrowed;
    }

    /**
     * Returns locationID
     * @return ?int
     * @throws InvalidArgumentException If the Asset is borrowed
     */
    public function getLocationID(): ?int
    {
        if ($this->isBorrowed()) {
            throw new InvalidArgumentException('Asset is borrowed.');
        }

        return $this->locationID;
    }

    /**
     * Returns AssetLocation
     * @return ?AssetLocation
     */
    public function getLocation(): ?AssetLocation
    {
        return new AssetLocation($this->getLocationID());
    }

    /**
     * Returns userID
     * @return ?int
     * @throws InvalidArgumentException If the Asset is not borrowed
     */
    public function getUserID(): ?int
    {
        if (!$this->isBorrowed()) {
            throw new InvalidArgumentException('Asset is borrowed.');
        }

        return $this->userID;
    }

    /**
     * Returns User
     * @return ?User
     */
    public function getUser(): ?User
    {
        return new User($this->getUserID());
    }

    /**
     * Returns user Profile
     * @return ?UserProfile
     */
    public function getUserProfile(): ?UserProfile
    {
        return new UserProfile($this->getUser());
    }

    /**
     * Returns categoryID
     * @return int
     */
    public function getCategoryID(): int
    {
        return $this->categoryID;
    }

    /**
     * Returns AssetCategory
     * @return ?AssetCategory
     */
    public function getCategory(): AssetCategory
    {
        return new AssetCategory($this->getCategoryID());
    }

    /**
     * Returns lastModifiedTimestamp
     * @return int
     */
    public function getLastModifiedTimestamp(): int
    {
        return $this->lastModifiedDate;
    }

    /**
     * Returns last modified date
     * @return DateTimeImmutable
     */
    public function getLastModified(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->getLastModifiedTimestamp());
    }

    /**
     * Returns createdTimestamp
     * @return int
     */
    public function getCreatedTimestamp(): int
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
