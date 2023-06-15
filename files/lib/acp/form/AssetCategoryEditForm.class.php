<?php

namespace assets\acp\form;

use assets\data\asset\category\AssetCategory;
use wcf\system\exception\IllegalLinkException;

class AssetCategoryEditForm extends AssetCategoryAddForm
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
        $this->formObject = new AssetCategory($categoryID);
        if (!$this->formObject->categoryID) {
            throw new IllegalLinkException();
        }
    }
}
