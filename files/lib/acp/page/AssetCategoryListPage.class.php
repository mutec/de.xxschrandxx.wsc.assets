<?php

namespace assets\acp\page;

use assets\data\asset\AssetCategory;
use wcf\page\MultipleLinkPage;

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
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.assets.asset.category.list';

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->sortField = AssetCategory::getDatabaseTableIndexName();
        parent::__run();
    }
}
