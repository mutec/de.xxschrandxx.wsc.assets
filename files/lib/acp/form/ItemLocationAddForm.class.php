<?php

namespace wcf\acp\form;

use wcf\data\inventory\ItemLocationAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\MultilineTextFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\WCF;

class ItemLocationAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.item.location.add';

    /**
     * @inheritDoc
     */
    public $objectActionClass = ItemLocationAction::class;

    /**
     * @inheritDoc
     * @var \wcf\data\inventory\ItemLocation
     */
    public $formObject;

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
                        ->label('wcf.acp.form.itemLocation.field.address')
                        ->description('wcf.acp.form.itemLocation.field.address.description')
                        ->required()
                ])
        );
    }
}
