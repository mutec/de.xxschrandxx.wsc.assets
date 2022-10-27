<?php

namespace wcf\acp\page;

use wcf\data\inventory\ItemCategory;
use wcf\data\inventory\ItemCategoryList;
use wcf\page\MultipleLinkPage;

class ItemCategoryListPage extends MultipleLinkPage
{
    /**
     * @inheritDoc
     */
    public $objectListClassName = ItemCategoryList::class;

    /**
     * @inheritDoc
     */
    public $sortOrder = 'ASC';

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.itemCategoryList';

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->sortField = ItemCategory::getDatabaseTableIndexName();
        parent::__run();
    }
}
