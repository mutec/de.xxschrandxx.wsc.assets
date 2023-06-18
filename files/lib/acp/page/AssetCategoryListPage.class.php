<?php

namespace assets\acp\page;

use assets\data\asset\category\AssetCategory;
use assets\data\asset\category\AssetCategoryList;
use wcf\page\MultipleLinkPage;

/**
 * @property    AssetCategoryList   $objectList
 */
class AssetCategoryListPage extends MultipleLinkPage
{
    /**
     * @inheritDoc
     */
    public $objectListClassName = AssetCategoryList::class;

    /**
     * @inheritDoc
     */
    public $sortOrder = 'ASC';

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.application.assets.asset.category.list';

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->sortField = AssetCategory::getDatabaseTableIndexName();
        parent::__run();
    }
}
