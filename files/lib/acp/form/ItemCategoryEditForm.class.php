<?php

namespace wcf\acp\form;

use wcf\data\inventory\ItemCategory;
use wcf\system\exception\IllegalLinkException;

class ItemCategoryEditForm extends ItemCategoryAddForm
{
    /**
     * @inheritDoc
     */
    public $formAction = 'edit';

    /**
     * @inheritDoc
     */
    public function readParameters()
    {
        parent::readParameters();

        $categoryID = 0;
        if (isset($_REQUEST['id'])) {
            $categoryID = (int)$_REQUEST['id'];
        }
        $this->formObject = new ItemCategory($categoryID);
        if (!$this->formObject->categoryID) {
            throw new IllegalLinkException();
        }
    }
}
