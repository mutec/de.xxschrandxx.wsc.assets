<?php

namespace assets\data\asset;

use wcf\data\DatabaseObjectEditor;

/**
 * @property    Asset   $object
 * @method      Asset   getDecoratedObject()
 * @mixin       Asset
 */
class AssetEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = Asset::class;
}
