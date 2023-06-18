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

        if (isset($_REQUEST['id']) && \is_numeric($_REQUEST['id'])) {
            $this->formObject = new AssetCategory((int)$_REQUEST['id']);
        }

        if (!$this->formObject->getObjectID()) {
            throw new IllegalLinkException();
        }
    }
}
