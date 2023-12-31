<?php

namespace assets\acp\form;

use assets\data\asset\category\AssetCategoryAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\TextFormField;
use wcf\system\form\builder\field\TitleFormField;

/**
 * @property    AssetCategoryAction $objectAction
 */
class AssetCategoryAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.application.assets.asset.category.add';

    /**
     * @inheritDoc
     */
    public $objectActionClass = AssetCategoryAction::class;

    /**
     * @inheritDoc
     */
    public $objectEditLinkController = AssetCategoryEditForm::class;

    /**
     * @inheritDoc
     */
    public $objectEditLinkApplication = 'assets';

    /**
     * @inheritDoc
     */
    protected function createForm()
    {
        parent::createForm();

        $this->form->appendChild(
            FormContainer::create('data')
                ->appendChildren([
                    TitleFormField::create()
                        ->value('Default')
                        ->maximumLength(20)
                        ->required(),
                    TextFormField::create('description')
                        ->label('wcf.global.description'),
                ]),
        );
    }
}
