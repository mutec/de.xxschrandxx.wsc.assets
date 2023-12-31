<?php

namespace assets\acp\form;

use assets\data\asset\location\AssetLocationAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\MultilineTextFormField;
use wcf\system\form\builder\field\TitleFormField;

/**
 * @property    AssetLocationAction $objectAction
 */
class AssetLocationAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.application.assets.asset.location.add';

    /**
     * @inheritDoc
     */
    public $objectActionClass = AssetLocationAction::class;

    /**
     * @inheritDoc
     */
    public $objectEditLinkController = AssetLocationEditForm::class;

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
                    MultilineTextFormField::create('address')
                        ->label('wcf.acp.form.assetLocation.field.address')
                        ->description('wcf.acp.form.assetLocation.field.address.description')
                        ->required(),
                ]),
        );
    }
}
