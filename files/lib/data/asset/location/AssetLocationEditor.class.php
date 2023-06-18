<?php

namespace assets\data\asset\location;

use wcf\data\DatabaseObjectEditor;

/**
 * @property    AssetLocation   $object
 * @method      AssetLocation   getDecoratedObject()
 * @mixin       AssetLocation
 */
class AssetLocationEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = AssetLocation::class;
}
