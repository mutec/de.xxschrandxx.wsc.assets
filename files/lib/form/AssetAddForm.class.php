<?php

namespace assets\form;

use assets\data\asset\AssetList;
use assets\data\asset\category\AssetCategoryList;
use assets\data\asset\location\AssetLocationList;
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
use wcf\system\WCF;

class AssetAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     * TODO
     */
//    public $activeMenuItem = 'wcf.menu.link.application.assets.asset.add';

    /**
     * @inheritDoc
     */
    public $objectActionClass = AssetAction::class;

    /**
     * @inheritDoc
     * @var \wcf\data\assets\Asset
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
        $assetCategoryList = new AssetCategoryList();
        $assetCategoryList->readObjects();
        /** @var \wcf\data\assets\AssetCategory[] */
        $assetCatefories = $assetCategoryList->getObjects();
        foreach ($assetCatefories as $assetCategory) {
            \array_push($categories, ['label' => $assetCategory->getTitle(), 'value' => $assetCategory->getObjectID(), 'depth' => 0]);
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
        $assetLocationList = new AssetLocationList();
        $assetLocationList->readObjects();
        /** @var \wcf\data\assets\AssetLocation[] */
        $assetLocations = $assetLocationList->getObjects();
        foreach ($assetLocations as $assetLocation) {
            \array_push($locations, ['label' => $assetLocation->getTitle(), 'value' => $assetLocation->getObjectID(), 'depth' => 0]);
        }

        $canBeBorrowedFormField = BooleanFormField::create('canBeBorrowed')
            ->label('wcf.form.asset.field.canBeBorrowed');
        $borroewdFormField = BooleanFormField::create('borrowed')
            ->label('wcf.form.asset.field.borrowed')
            ->addDependency(
                NonEmptyFormFieldDependency::create('canBeBorrowed')
                    ->field($canBeBorrowedFormField)
            );

        if (ASSETS_LEGACYID_ENABLED) {
            $children = [
                TextFormField::create('legacyID')
                    ->label('wcf.form.asset.field.legacyID')
                    ->description('wcf.form.asset.field.legacyID.description')
                    ->minimumLength(1)
                    ->addValidator(new FormFieldValidator('checkDuplicate', function (TextFormField $field) {
                        if ($this->formAction === 'edit' && $this->formObject->getLegacyID() === $field->getValue()) {
                            return;
                        }
                        $assetList = new AssetList();
                        $assetList->getConditionBuilder()->add('legacyID = ?', [$field->getValue()]);
                        if ($assetList->countObjects() !== 0) {
                            $field->addValidationError(
                                new FormFieldValidationError(
                                    'duplicate',
                                    'wcf.form.asset.field.legacyID.error.duplicate'
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
                ->label('wcf.form.asset.field.categoryID')
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
                ->label('wcf.form.asset.field.amount')
                ->minimum(1)
                ->required(),
            $canBeBorrowedFormField,
            $borroewdFormField,
            SingleSelectionFormField::create('userID')
                ->label('wcf.form.asset.field.userID')
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
                ->label('wcf.form.asset.field.locationID')
                ->description('wcf.form.asset.field.locationID.description')
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
                ->label('wcf.form.asset.field.description')
                ->messageObjectType('de.xxschrandxx.wsc.assets.asset.description')
                ->attachmentData('de.xxschrandxx.wsc.assets.asset.description.attachment'),
        ]);
    }
}
