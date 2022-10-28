<?php

namespace wcf\acp\page;

use wcf\data\inventory\ItemLocation;
use wcf\data\inventory\ItemLocationList;
use wcf\page\MultipleLinkPage;

class ItemLocationListPage extends MultipleLinkPage
{
    /**
     * @inheritDoc
     */
    public $objectListClassName = ItemLocationList::class;

    /**
     * @inheritDoc
     */
    public $sortOrder = 'ASC';

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.itemLocationList';

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->sortField = ItemLocation::getDatabaseTableIndexName();
        parent::__run();
    }
}
