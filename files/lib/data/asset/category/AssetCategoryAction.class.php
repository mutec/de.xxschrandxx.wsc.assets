<?php

namespace assets\data\asset\category;

use wcf\data\AbstractDatabaseObjectAction;

/**
 * @property    AssetCategoryEditor[]   $objects
 * @method      AssetCategoryEditor[]   getObjects()
 * @method      AssetCategoryEditor     getSingleObject()
 */
class AssetCategoryAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    protected $className = AssetCategoryEditor::class;

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
    public function create(): AssetCategory
    {
        if (!isset($this->parameters['data']['time'])) {
            $this->parameters['data']['time'] = TIME_NOW;
        }

        $object = parent::create();
        \assert($object instanceof AssetCategory);

        return $object;
    }
}
