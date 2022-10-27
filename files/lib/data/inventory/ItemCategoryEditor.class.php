<?php

namespace wcf\data\inventory;

use wcf\data\DatabaseObjectEditor;

class ItemCategoryEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = ItemCategory::class;
}
