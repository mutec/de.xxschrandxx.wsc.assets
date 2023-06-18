<?php

namespace assets\page;

use assets\data\asset\AssetList;
use assets\data\asset\category\AssetCategoryList;
use assets\data\asset\location\AssetLocationList;
use wcf\page\SortablePage;
use wcf\system\request\LinkHandler;

class AssetListPage extends SortablePage
{
    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'de.xxschrandxx.wsc.assets.AssetList';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    public $objectListClassName = AssetList::class;

    /**
     * @inheritDoc
     */
    public $itemsPerPage = 100;

    /**
     * @inheritDoc
     */
    public $validSortFields = [
        'assetID',
        'categoryID',
        'legacyID',
        'lastModifiedDate',
        'creationDate',
    ];

    /**
     * @inheritDoc
     */
    public $defaultSortField = ASSETS_LEGACYID_ENABLED ? 'assetID' : 'legacyID';

    /**
     * @inheritDoc
     */
    public $forceCanonicalURL = true;

    /**
     * available categories
     * @var array
     */
    public array $availableCategories = [];

    /**
     * available location
     * @var array
     */
    public array $availableLocations = [];

    /**
     * search for borrowed assets
     * @var ?bool
     */
    public ?bool $searchBorrowed = null;

    /**
     * @inheritDoc
     */
    public function readParameters()
    {
        parent::readParameters();

        $parameters = [];

        if (isset($_REQUEST['searchBorrowed'])) {
            $this->searchBorrowed = \intval($_REQUEST['searchBorrowed']);
        }

        if ($this->searchBorrowed) {
            $parameters['searchBorrowed'] = $this->searchBorrowed;
        }

        $this->canonicalURL = LinkHandler::getInstance()->getLink($this::class, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function readData()
    {
        // get categories
        $assetCategoryList = new AssetCategoryList();
        $assetCategoryList->readObjects();
        $this->availableCategories = $assetCategoryList->getObjects();

        // get locations
        $assetLocationList = new AssetLocationList();
        $assetLocationList->readObjects();
        $this->availableLocations = $assetLocationList->getObjects();

        // get users
        // TODO

        parent::readData();
    }
}
