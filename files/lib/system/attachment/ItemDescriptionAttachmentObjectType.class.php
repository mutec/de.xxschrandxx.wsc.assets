<?php

namespace wcf\system\attachment;

class ItemDescriptionAttachmentObjectType extends AbstractAttachmentObjectType
{
    /**
     * @inheritDoc
     */
    public function canDownload($objectID)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function canViewPreview($objectID)
    {
        return $this->canDownload($objectID);
    }
    /**
     * @inheritDoc
     */
    public function canUpload($objectID, $parentObjectID = 0)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function canDelete($objectID)
    {
        return $this->canUpload($objectID);
    }
}