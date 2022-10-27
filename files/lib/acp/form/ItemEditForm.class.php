<?php

namespace wcf\acp\form;

use wcf\data\inventory\Item;
use wcf\system\exception\IllegalLinkException;

class ItemEditForm extends ItemAddForm
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
        $this->formObject = new Item($itemID);
        if (!$this->formObject->itemID) {
            throw new IllegalLinkException();
        }
    }
}
