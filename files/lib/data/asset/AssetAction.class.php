<?php

namespace assets\data\asset;

use wcf\data\AbstractDatabaseObjectAction;

/**
 * @property    AssetEditor[]   $objects
 * @method      AssetEditor[]   getObjects()
 * @method      AssetEditor     getSingleObject()
 */
class AssetAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    protected $className = AssetEditor::class;

    /**
     * @inheritDoc
     */
    protected $permissionsCreate = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    protected $permissionsDelete = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    protected $permissionsUpdate = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    protected $requireACP = ['delete'];

    /**
     * @inheritDoc
     */
    public function create()
    {
        if (!isset($this->parameters['data']['time'])) {
            $this->parameters['data']['time'] = TIME_NOW;
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

        foreach ($this->getObjects() as $object) {
            if ($object->canBeBorrowed() && !$this->parameters['data']['canBeBorrowed']) {
                $object->update([
                    'borrowed' => 0,
                    'userID' => null,
                    'lastModifiedDate' => TIME_NOW,
                ]);
            } elseif ($object->isBorrowed() && !$this->parameters['data']['borrowed']) {
                $object->update([
                    'userID' => null,
                    'lastModifiedDate' => TIME_NOW,
                ]);
            } else {
                $object->update([
                    'lastModifiedDate' => TIME_NOW,
                ]);
            }
        }
    }
}
