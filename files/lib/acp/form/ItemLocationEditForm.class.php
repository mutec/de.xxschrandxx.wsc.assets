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

        $itemID = 0;
        if (isset($_REQUEST['id'])) {
            $itemID = (int)$_REQUEST['id'];
        }
        $this->formObject = new ItemLocation($itemID);
        if (!$this->formObject->itemID) {
            throw new IllegalLinkException();
        }
    }
}
