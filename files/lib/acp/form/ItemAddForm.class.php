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
            0 => [
                'label' => WCF::getLanguage()->get('wcf.label.none'),
                'value' => 0,
                'depth' => 0
            ]
        ];
        $itemCategoryList = new ItemCategoryList();
        $itemCategoryList->readObjects();
        /** @var \wcf\data\inventory\ItemCategory[] */
        $itemCatefories = $itemCategoryList->getObjects();
        foreach ($itemCatefories as $itemCategory) {
            \array_push($categories, ['label' => $itemCategory->getTitle(), 'value' => $itemCategory->getObjectID(), 'depth' => 0]);
        }

        // Read Users
        $userOptions = [
            0 => [
                'label' => WCF::getLanguage()->get('wcf.label.none'),
                'value' => 0,
                'depth' => 0
            ]
        ];
        $userList = new UserList();
        $userList->readObjects();
        /** @var \wcf\data\user\User[] */
        $users = $userList->getObjects();
        foreach ($users as $user) {
            \array_push($userOptions, ['label' => $user->getTitle(), 'value' => $user->getObjectID(), 'depth' => 0]);
        }

        // Read Locations
        $locations = [
            0 => [
                'label' => WCF::getLanguage()->get('wcf.label.none'),
                'value' => 0,
                'depth' => 0
            ]
        ];
        $itemLocationList = new ItemLocationList();
        $itemLocationList->readObjects();
        /** @var \wcf\data\inventory\ItemLocation[] */
        $itemLocations = $itemLocationList->getObjects();
        foreach ($itemLocations as $itemLocation) {
            \array_push($locations, ['label' => $itemLocation->getTitle(), 'value' => $itemLocation->getObjectID(), 'depth' => 0]);
        }

        $canBeBorrowedFormField = BooleanFormField::create('canBeBorrowed')
            ->label('wcf.acp.form.item.field.canBeBorrowed')
            ->required();
        $borroewdFormField = BooleanFormField::create('borrowed')
            ->label('wcf.acp.form.item.field.borroewd')
            ->addDependency(
                NonEmptyFormFieldDependency::create('canBeBorrowed')
                ->field($canBeBorrowedFormField)
            )
            ->required();

        $children = [
            TitleFormField::create()
                ->value('Default')
                ->maximumLength(20)
                ->required(),
            SingleSelectionFormField::create('categoryID')
                ->label('wcf.acp.form.item.field.categoryID')
                ->options($categories, true, false)
                ->addValidator(new FormFieldValidator('checkCategoryID', function (SingleSelectionFormField $field) {
                    if ($field->getValue() === 0) {
                        throw new FormFieldValidationError(
                            'invalidValue',
                            'wcf.global.form.error.noValidSelection'
                        );
                    }
                }))
                ->required(),
            $canBeBorrowedFormField,
            $borroewdFormField,
            SingleSelectionFormField::create('userID')
                ->label('wcf.acp.form.item.field.userID')
                ->options($userOptions, true, false)
                ->addDependency(
                    NonEmptyFormFieldDependency::create('borrowed')
                        ->field($borroewdFormField)
                )
                ->addDependency(
                    NonEmptyFormFieldDependency::create('canBeBorrowed')
                    ->field($canBeBorrowedFormField)
                )
                ->required(),
            SingleSelectionFormField::create('locationID')
                ->label('wcf.acp.form.item.field.locationID')
                ->options($locations, true, false)
                ->addValidator(new FormFieldValidator('checkLocationID', function (SingleSelectionFormField $field) {
                    if ($field->getValue() === 0) {
                        throw new FormFieldValidationError(
                            'invalidValue',
                            'wcf.global.form.error.noValidSelection'
                        );
                    }
                }))
                ->addDependency(
                    EmptyFormFieldDependency::create('borrowed')
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
