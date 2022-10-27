<?php

namespace wcf\data\inventory;

use wcf\data\DatabaseObjectEditor;

class ItemEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = Item::class;
}
