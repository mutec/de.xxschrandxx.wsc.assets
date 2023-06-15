<?php

namespace assets\acp\page;

use assets\data\asset\AssetLocation;
use wcf\page\MultipleLinkPage;

class AssetLocationListPage extends MultipleLinkPage
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
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.assets.asset.location.list';

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->sortField = AssetLocation::getDatabaseTableIndexName();
        parent::__run();
    }
}
