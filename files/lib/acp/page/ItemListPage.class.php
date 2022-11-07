<?php

namespace wcf\acp\page;

use wcf\data\inventory\Item;
use wcf\data\inventory\ItemCategoryList;
use wcf\data\inventory\ItemList;
use wcf\data\inventory\ItemLocationList;
use wcf\page\SortablePage;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

class ItemListPage extends SortablePage
{
    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.item.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    public $itemsPerPage = 100;

    /**
     * @inheritDoc
     */
    public $validSortFields = ['itemID', 'categoryID', 'legacyID', 'lastModifiedDate', 'creationDate'];

    /**
     * @inheritDoc
     */
    public $defaultSortField = INVENTORY_LEGACYID_ENABLED ? 'itemID' : 'legacyID';

    /**
     * @inheritDoc
     */
    public $forceCanonicalURL = true;

    /**
     * available categories
     * @var array
     */
    public $availableCategories = [];

    /**
     * available location
     * @var array
     */
    public $availableLocations = [];

    /**
     * available users
     * @var array
     */
    public $availableUsers = [];

    /**
     * search for borrowed items
     * @var ?bool
     */
    public $searchBorrowed = null;

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

        $this->canonicalURL = LinkHandler::getInstance()->getLink('ItemList', $parameters);
    }

    /**
     * @inheritDoc
     */
    protected function initObjectList()
    {
        $this->objectList = new ItemList();
    }

    /**
     * @inheritDoc
     */
    public function readData()
    {
        // get categories
        $itemCategoryList = new ItemCategoryList();
        $itemCategoryList->readObjects();
        $this->availableCategories = $itemCategoryList->getObjects();

        // get locations
        $itemLocationList = new ItemLocationList();
        $itemLocationList->readObjects();
        $this->availableLocations = $itemLocationList->getObjects();

        // get users
        // TODO

        parent::readData();
    }

    /**
     * @inheritDoc
     */
    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
        ]);
    }
}
