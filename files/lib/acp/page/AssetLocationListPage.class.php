<?php

namespace assets\acp\page;

use assets\data\asset\location\AssetLocation;
use assets\data\asset\location\AssetLocationList;
use wcf\page\MultipleLinkPage;

/**
 * @property    AssetLocationList   $objectList
 */
class AssetLocationListPage extends MultipleLinkPage
{
    /**
     * @inheritDoc
     */
    public $objectListClassName = AssetLocationList::class;

    /**
     * @inheritDoc
     */
    public $sortOrder = 'ASC';

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.application.assets.asset.location.list';

    /**
     * @inheritDoc
     */
    protected function initObjectList()
    {
        $this->sortField = AssetLocation::getDatabaseTableIndexName();

        parent::initObjectList();
    }
}
