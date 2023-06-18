<?php

namespace assets\data\asset\category;

use wcf\data\DatabaseObjectEditor;

/**
 * @property    AssetCategory   $object
 * @method      AssetCategory   getDecoratedObject()
 * @mixin       AssetCategory
 */
class AssetCategoryEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = AssetCategory::class;
}
