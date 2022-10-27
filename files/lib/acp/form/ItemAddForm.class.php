<?php

namespace wcf\acp\form;

use wcf\data\inventory\ItemCategoryList;
use wcf\data\inventory\ItemLocationList;
use wcf\data\user\UserList;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\BooleanFormField;
use wcf\system\form\builder\field\dependency\EmptyFormFieldDependency;
use wcf\system\form\builder\field\dependency\NonEmptyFormFieldDependency;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TextFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\form\builder\field\validation\FormFieldValidationError;
use wcf\system\form\builder\field\validation\FormFieldValidator;
use wcf\system\WCF;

class ItemAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.inventory.canManage'];

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.itemList.add';

    /**
     * @inheritDoc
     */
    public $objectActionClass = ItemAction::class;

    /**
     * @inheritDoc
     * @var \wcf\data\inventory\Item
     */
    public $formObject;

    /**
     * @inheritDoc
     */
    protected function createForm()
    {
        parent::createForm();

        // Read Categories
        $categories = [
            'label' => WCF::getLanguage()->get('wcf.label.none'),
            'value' => 0,
            'depth' => 0
        ];
        $itemCategoryList = new ItemCategoryList();
        $itemCategoryList->readObjects();
        /** @var \wcf\data\inventory\ItemCategory[] */
        $itemCatefories = $itemCategoryList->getObjects();
        foreach ($itemCatefories as $itemCategory) {
            \array_push($categories, ['label' => $itemCategory->getTitle(), 'value' => $itemCategory->getObjectID(), 'depth' => 0]);
        }

        // Read Users
        $users = [
            'label' => WCF::getLanguage()->get('wcf.label.none'),
            'value' => 0,
            'depth' => 0
        ];
        $userList = new UserList();
        $userList->readObjects();
        /** @var \wcf\data\user\User[] */
        $users = $userList->getObjects();
        foreach ($users as $user) {
            \array_push($users, ['label' => $user->getTitle(), 'value' => $user->getObjectID(), 'depth' => 0]);
        }

        // Read Locations
        $locations = [
            'label' => WCF::getLanguage()->get('wcf.label.none'),
            'value' => 0,
            'depth' => 0
        ];
        $itemLocationList = new ItemLocationList();
        $itemLocationList->readObjects();
        /** @var \wcf\data\inventory\ItemLocation[] */
        $itemLocations = $itemLocationList->getObjects();
        foreach ($itemLocations as $itemLocation) {
            \array_push($locations, ['label' => $itemLocation->getTitle(), 'value' => $itemLocation->getObjectID(), 'depth' => 0]);
        }

        $borroewdFormField = BooleanFormField::create('borrowed');

        $children = [
            TitleFormField::create()
                ->value('Default')
                ->maximumLength(20)
                ->required(),
            SingleSelectionFormField::create('categoryID')
                ->options($categories)
                ->addValidator(new FormFieldValidator('checkCategoryID', function (SingleSelectionFormField $field) {
                    if ($field->getValue() === 0) {
                        throw new FormFieldValidationError(
                            'invalidValue',
                            'wcf.global.form.error.noValidSelection'
                        );
                    }
                }))
                ->addDependency(
                    EmptyFormFieldDependency::create('borroewd')
                        ->field($borroewdFormField)
                )
                ->required(),
            $borroewdFormField,
            SingleSelectionFormField::create('userID')
                ->options($users)
                ->required(),
            SingleSelectionFormField::create('locationID')
                ->options($locations)
                ->addValidator(new FormFieldValidator('checkCategoryID', function (SingleSelectionFormField $field) {
                    if ($field->getValue() === 0) {
                        throw new FormFieldValidationError(
                            'invalidValue',
                            'wcf.global.form.error.noValidSelection'
                        );
                    }
                }))
                ->addDependency(
                    NonEmptyFormFieldDependency::create('borrowed')
                        ->field($borroewdFormField)
                )
                ->required()
        ];

        if (INVENTORY_LEGACYID_ENABLED) {
            \array_push($children,
                TextFormField::create('legacyID')
            );
        }

        $this->form->appendChild(
            FormContainer::create('data')
                ->appendChildren($children)
        );
    }
}
