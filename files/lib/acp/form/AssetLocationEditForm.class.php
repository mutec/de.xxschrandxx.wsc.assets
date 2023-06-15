<?php

namespace assets\acp\form;

use assets\data\asset\AssetLocation;
use wcf\system\exception\IllegalLinkException;

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
        parent::readParameters();

        $locationID = 0;
        if (isset($_REQUEST['id'])) {
            $locationID = (int)$_REQUEST['id'];
        }
        $this->formObject = new AssetLocation($locationID);
        if (!$this->formObject->locationID) {
            throw new IllegalLinkException();
        }
    }
}
