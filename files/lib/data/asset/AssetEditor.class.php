<?php

namespace assets\data\asset;

use wcf\data\DatabaseObjectEditor;

class AssetEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = Asset::class;
}
