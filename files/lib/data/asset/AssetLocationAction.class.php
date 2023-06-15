<?php

namespace assets\data\asset;

use wcf\data\AbstractDatabaseObjectAction;

class AssetLocationAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    protected $className = AssetLocationEditor::class;

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
