<?php

namespace wcf\data\inventory;

use wcf\data\AbstractDatabaseObjectAction;

class ItemLocationAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    protected $className = ItemLocationEditor::class;

    /**
     * @inheritDoc
     */
    protected $permissionsCreate = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    protected $permissionsDelete = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    protected $permissionsUpdate = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    protected $requireACP = ['create', 'update', 'delete'];

    /**
     * @inheritDoc
     */
    public function create()
    {
        if (!isset($this->parameters['data']['creationDate'])) {
            $this->parameters['data']['creationDate'] = TIME_NOW;
        }

        parent::create();
    }
}
