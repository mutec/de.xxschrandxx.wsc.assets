<?php

namespace wcf\acp\form;

use wcf\data\inventory\ItemAction;
use wcf\data\inventory\ItemCategoryList;
use wcf\data\inventory\ItemList;
use wcf\data\inventory\ItemLocationList;
use wcf\data\user\UserList;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\container\wysiwyg\WysiwygFormContainer;
use wcf\system\form\builder\field\BooleanFormField;
use wcf\system\form\builder\field\dependency\NonEmptyFormFieldDependency;
use wcf\system\form\builder\field\IntegerFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\TextFormField;
use wcf\system\form\builder\field\TitleFormField;
use wcf\system\form\builder\field\validation\FormFieldValidationError;
use wcf\system\form\builder\field\validation\FormFieldValidator;
use wcf\system\form\builder\field\wysiwyg\WysiwygFormField;
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
    public $activeMenuItem = 'wcf.acp.menu.link.configuration.inventory.item.add';

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
            ->label('wcf.acp.form.item.field.canBeBorrowed');
        $borroewdFormField = BooleanFormField::create('borrowed')
            ->label('wcf.acp.form.item.field.borrowed')
            ->addDependency(
                NonEmptyFormFieldDependency::create('canBeBorrowed')
                    ->field($canBeBorrowedFormField)
            );

        if (INVENTORY_LEGACYID_ENABLED) {
            $children = [
                TextFormField::create('legacyID')
                    ->label('wcf.acp.form.item.field.legacyID')
                    ->description('wcf.acp.form.item.field.legacyID.description')
                    ->minimumLength(1)
                    ->addValidator(new FormFieldValidator('checkDuplicate', function (TextFormField $field) {
                        if ($this->formAction === 'edit' && $this->formObject->getLegacyID() === $field->getValue()) {
                            return;
                        }
                        $itemList = new ItemList();
                        $itemList->getConditionBuilder()->add('legacyID = ?', [$field->getValue()]);
                        if ($itemList->countObjects() !== 0) {
                            $field->addValidationError(
                                new FormFieldValidationError(
                                    'duplicate',
                                    'wcf.acp.form.item.field.legacyID.error.duplicate'
                                )
                            );
                        }
                    }))
            ];
        } else {
            $children = [];
        }
    
        \array_push($children,
            TitleFormField::create()
                ->value('Default')
                ->maximumLength(20)
                ->required(),
            SingleSelectionFormField::create('categoryID')
                ->label('wcf.acp.form.item.field.categoryID')
                ->options($categories, true, false)
                ->addValidator(new FormFieldValidator('checkCategoryID', function (SingleSelectionFormField $field) {
                    if ($field->getValue() === null || $field->getValue() === "0") {
                        $field->addValidationError(
                            new FormFieldValidationError(
                                'invalidValue',
                                'wcf.global.form.error.noValidSelection'
                            )
                        );
                    }
                }))
                ->required(),
            IntegerFormField::create('amount')
                ->label('wcf.acp.form.item.field.amount')
                ->minimum(1)
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
                ->description('wcf.acp.form.item.field.locationID.description')
                ->options($locations, true, false)
                ->addValidator(new FormFieldValidator('checkLocationID', function (SingleSelectionFormField $field) {
                    if ($field->getValue() === null || $field->getValue() === "0") {
                        $field->addValidationError(
                            new FormFieldValidationError(
                                'invalidValue',
                                'wcf.global.form.error.noValidSelection'
                            )
                        );
                    }
                }))
                ->required()
        );

        $this->form->appendChildren([
            FormContainer::create('data')
                ->appendChildren($children),
            WysiwygFormContainer::create('description')
                ->label('wcf.acp.form.item.field.description')
                ->messageObjectType('de.xxschrandxx.wsc.inventory.item.description')
                ->attachmentData('de.xxschrandxx.wsc.inventory.item.description.attachment'),
        ]);
    }
}
