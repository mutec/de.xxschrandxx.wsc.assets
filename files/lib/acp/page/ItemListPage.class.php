<?php

namespace wcf\acp\page;

use wcf\data\inventory\Item;
use wcf\data\inventory\ItemList;
use wcf\page\MultipleLinkPage;

class ItemListPage extends MultipleLinkPage
{
    /**
     * @inheritDoc
     */
    public $objectListClassName = ItemList::class;

    /**
     * @inheritDoc
     */
    public $sortOrder = 'ASC';

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.item.list';

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->sortField = Item::getDatabaseTableIndexName();
        parent::__run();
    }
}
