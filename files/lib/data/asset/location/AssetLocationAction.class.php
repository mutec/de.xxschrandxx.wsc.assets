<?php

namespace assets\data\asset\location;

use wcf\data\AbstractDatabaseObjectAction;

/**
 * @property    AssetLocationEditor[]   $objects
 * @method      AssetLocationEditor[]   getObjects()
 * @method      AssetLocationEditor     getSingleObject()
 */
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
        if (!isset($this->parameters['data']['time'])) {
            $this->parameters['data']['time'] = TIME_NOW;
        }

        parent::create();
    }
}
