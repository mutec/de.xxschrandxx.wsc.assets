<?php

namespace assets\form;

use assets\data\asset\Asset;
use assets\data\asset\AssetAction;
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

/**
 * @property    AssetAction $objectAction
 */
class AssetAddForm extends AbstractFormBuilderForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.assets.canManage'];

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'de.xxschrandxx.wsc.assets.AssetAdd';

    /**
     * @inheritDoc
     */
    public $objectActionClass = AssetAction::class;

    /**
     * @inheritDoc
     */
    public $objectEditLinkController = AssetEditForm::class;

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

        // Read Categories
        $categories = [
            0 => [
                'label' => WCF::getLanguage()->get('wcf.label.none'),
                'value' => 0,
                'depth' => 0,
            ],
        ];

        $categoryList = new AssetCategoryList();
        $categoryList->readObjects();

        foreach ($categoryList->getObjects() as $assetCategory) {
            \array_push($categories, [
                'label' => $assetCategory->getTitle(),
                'value' => $assetCategory->getObjectID(),
                'depth' => 0,
            ]);
        }

        // Read Users
        $userOptions = [
            0 => [
                'label' => WCF::getLanguage()->get('wcf.label.none'),
                'value' => 0,
                'depth' => 0,
            ],
        ];

        $userList = new UserList();
        $userList->readObjects();

        foreach ($userList->getObjects() as $user) {
            \array_push($userOptions, [
                'label' => $user->getTitle(),
                'value' => $user->getObjectID(),
                'depth' => 0,
            ]);
        }

        // Read Locations
        $locations = [
            0 => [
                'label' => WCF::getLanguage()->get('wcf.label.none'),
                'value' => 0,
                'depth' => 0,
            ],
        ];

        $assetLocationList = new AssetLocationList();
        $assetLocationList->readObjects();

        foreach ($assetLocationList->getObjects() as $assetLocation) {
            \array_push($locations, [
                'label' => $assetLocation->getTitle(),
                'value' => $assetLocation->getObjectID(),
                'depth' => 0,
            ]);
        }

        $this->form->appendChildren([
            FormContainer::create('data')
                ->appendChildren([
                    TextFormField::create('legacyID')
                        ->label('wcf.form.asset.field.legacyID')
                        ->description('wcf.form.asset.field.legacyID.description')
                        ->minimumLength(1)
                        ->available(ASSETS_LEGACYID_ENABLED)
                        ->addValidator(
                            new FormFieldValidator(
                                'checkDuplicate',
                                function (TextFormField $field) {
                                    if (
                                        $this->formAction === 'edit'
                                        && $this->formObject instanceof Asset
                                        && $this->formObject->getLegacyID() === $field->getValue()
                                    ) {
                                        return;
                                    }

                                    $assetList = new AssetList();
                                    $assetList->getConditionBuilder()->add('legacyID = ?', [$field->getValue()]);
                                    if ($assetList->countObjects() > 0) {
                                        $field->addValidationError(
                                            new FormFieldValidationError(
                                                'duplicate',
                                                'wcf.form.asset.field.legacyID.error.duplicate'
                                            )
                                        );
                                    }
                                }
                            )
                        ),
                    TitleFormField::create()
                        ->value('Default')
                        ->maximumLength(20)
                        ->required(),
                    SingleSelectionFormField::create('categoryID')
                        ->label('wcf.form.asset.field.categoryID')
                        ->options($categories, true, false)
                        ->addValidator(
                            new FormFieldValidator(
                                'checkCategoryID',
                                static function (SingleSelectionFormField $field) {
                                    if ($field->getValue() === null || $field->getValue() === '0') {
                                        $field->addValidationError(
                                            new FormFieldValidationError(
                                                'invalidValue',
                                                'wcf.global.form.error.noValidSelection'
                                            )
                                        );
                                    }
                                }
                            )
                        )
                        ->required(),
                    IntegerFormField::create('amount')
                        ->label('wcf.form.asset.field.amount')
                        ->minimum(1)
                        ->required(),
                    BooleanFormField::create('canBeBorrowed')
                        ->label('wcf.form.asset.field.canBeBorrowed'),
                    BooleanFormField::create('isBorrowed')
                        ->label('wcf.form.asset.field.borrowed')
                        ->addDependency(
                            NonEmptyFormFieldDependency::create('canBeBorrowed')
                                ->fieldId('canBeBorrowed')
                        ),
                    SingleSelectionFormField::create('userID')
                        ->label('wcf.form.asset.field.userID')
                        ->options($userOptions, true, false)
                        ->addDependency(
                            NonEmptyFormFieldDependency::create('isBorrowed')
                                ->fieldId('isBorrowed')
                        )
                        ->addDependency(
                            NonEmptyFormFieldDependency::create('canBeBorrowed')
                                ->fieldId('canBeBorrowed')
                        )
                        ->required(),
                    SingleSelectionFormField::create('locationID')
                        ->label('wcf.form.asset.field.locationID')
                        ->description('wcf.form.asset.field.locationID.description')
                        ->options($locations, true, false)
                        ->addValidator(
                            new FormFieldValidator(
                                'checkLocationID',
                                static function (SingleSelectionFormField $field) {
                                    if ($field->getValue() === null || $field->getValue() === '0') {
                                        $field->addValidationError(
                                            new FormFieldValidationError(
                                                'invalidValue',
                                                'wcf.global.form.error.noValidSelection'
                                            )
                                        );
                                    }
                                }
                            )
                        )
                        ->required(),
                ]),
            WysiwygFormContainer::create('description')
                ->label('wcf.form.asset.field.description')
                ->messageObjectType('de.xxschrandxx.wsc.assets.asset.description')
                ->attachmentData('de.xxschrandxx.wsc.assets.asset.description.attachment'),
        ]);
    }
}
