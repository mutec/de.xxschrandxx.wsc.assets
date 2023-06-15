<?php

namespace assets\system;

use assets\page\AssetListPage;
use wcf\system\application\AbstractApplication;

final class AssetsCore extends AbstractApplication
{
    /**
     * @inheritDoc
     */
    protected $primaryController = AssetListPage::class;
}