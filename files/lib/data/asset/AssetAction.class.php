<?php

namespace assets\data\asset;

use wcf\data\AbstractDatabaseObjectAction;

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
                /** @var \assets\data\asset\Asset */
                $item = $object->getDecoratedObject();
                if ($item->canBeBorrowed() && !$this->parameters['data']['canBeBorrowed']) {
                    $object->update([
                        'borrowed' => 0,
                        'userID' => null,
                        'lastModifiedDate' => TIME_NOW
                    ]);
                } else if ($item->isBorrowed() && !$this->parameters['data']['borrowed']) {
                    $object->update([
                        'userID' => null,
                        'lastModifiedDate' => TIME_NOW
                    ]);
                } else {
                    $object->update([
                        'lastModifiedDate' => TIME_NOW
                    ]);
                }
            }
        }
    }
}
