<?php

namespace wcf\acp\form;

use wcf\data\inventory\ItemCategoryAction;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\TextFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\WCF;

class ItemCategoryAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.item.category.add';

    /**
     * @inheritDoc
     */
    public $objectActionClass = ItemCategoryAction::class;

    /**
     * @inheritDoc
     * @var \wcf\data\inventory\ItemCategory
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
                    TextFormField::create('description')
                        ->label('wcf.global.description')
                ])
        );
    }
}
