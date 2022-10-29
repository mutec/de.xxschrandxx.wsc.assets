<?php

namespace wcf\data\inventory;

use wcf\data\AbstractDatabaseObjectAction;

class ItemAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    protected $className = ItemEditor::class;

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
    protected $requireACP = ['delete'];

    /**
     * @inheritDoc
     */
    public function create()
    {
        if (!isset($this->parameters['data']['creationDate'])) {
            $this->parameters['data']['creationDate'] = TIME_NOW;
        }
        if (!isset($this->parameters['data']['lastModifiedDate'])) {
            $this->parameters['data']['lastModifiedDate'] = TIME_NOW;
        }

        parent::create();
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        parent::update();

        if (isset($this->parameters['data'])) {
            foreach ($this->getObjects() as $object) {
                $object->update([
                    'lastModifiedDate' => TIME_NOW
                ]);
            }
        }
    }
}
