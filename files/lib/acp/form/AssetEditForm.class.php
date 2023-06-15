<?php

namespace assets\acp\form;

use assets\data\asset\Asset;
use wcf\system\exception\IllegalLinkException;

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

        $assetID = 0;
        if (isset($_REQUEST['id'])) {
            $assetID = (int)$_REQUEST['id'];
        }
        $this->formObject = new Asset($assetID);
        if (!$this->formObject->assetID) {
            throw new IllegalLinkException();
        }
    }
}
