<?php

namespace assets\page;

use assets\acp\page\AssetListPage as ACPAssetListPage;

class AssetListPage extends ACPAssetListPage
{
    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.menu.link.configuration.assets.asset.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['user.assets.canSee'];
}
