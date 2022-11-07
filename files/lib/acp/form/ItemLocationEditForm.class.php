<?php

namespace wcf\acp\form;

use wcf\data\inventory\ItemLocation;
use wcf\system\exception\IllegalLinkException;

class ItemLocationEditForm extends ItemLocationAddForm
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
        $this->formObject = new ItemLocation($locationID);
        if (!$this->formObject->locationID) {
            throw new IllegalLinkException();
        }
    }
}
