<?php

namespace assets\acp\form;

use assets\data\asset\location\AssetLocation;
use wcf\system\exception\IllegalLinkException;

/**
 * @property    AssetLocation|null  $formObject
 */
class AssetLocationEditForm extends AssetLocationAddForm
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
        if (isset($_REQUEST['id']) && \is_numeric($_REQUEST['id'])) {
            $this->formObject = new AssetLocation((int)$_REQUEST['id']);
        }

        if (!$this->formObject->getObjectID()) {
            throw new IllegalLinkException();
        }
    }
}
