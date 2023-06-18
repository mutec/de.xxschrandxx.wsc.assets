<?php

namespace assets\form;

use assets\data\asset\Asset;
use wcf\system\exception\IllegalLinkException;

/**
 * @property    Asset|null  $formObject
 */
class AssetEditForm extends AssetAddForm
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
            $this->formObject = new Asset((int)$_REQUEST['id']);
        }

        if (!$this->formObject->getObjectID()) {
            throw new IllegalLinkException();
        }
    }
}
