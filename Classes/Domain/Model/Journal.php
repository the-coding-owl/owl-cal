<?php
/*
 * the-coding-owl/owl-cal
 * Copyright (C) 2021 Kevin Ditscheid <kevin@the-coding-owl.de>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace TheCodingOwl\OwlCal\Domain\Model;

use TheCodingOwl\OwlCal\Domain\Interface\AttachmentsInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Journal model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Journal extends AbstractEntity implements AttachmentsInterface {
    /**
     * @var ObjectStorage<Attachment>|null
     * @Lazy
     */
    protected ?ObjectStorage $attachments = null;

    public function __construct()
    {
        $this->attachments = new ObjectStorage();
    }

    /**
     * Get the attachments
     *
     * @return ObjectStorage
     */
    public function getAttachments(): ObjectStorage
    {
        return $this->attachments ?? new ObjectStorage();
    }

    /**
     * Set the attachments
     *
     * @param ObjectStorage<Attachment> $attachments
     * @return self
     */
    public function setAttachments(ObjectStorage $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * Add the given attachment
     *
     * @param Attachment $attachment
     * @return self
     */
    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments->attach($attachment);
        return $this;
    }

    /**
     * Remove the given attachment
     *
     * @param Attachment $attachmentToRemove
     * @return self
     */
    public function removeAttachment(Attachment $attachmentToRemove): self
    {
        $this->attachments->detach($attachmentToRemove);
        return $this;
    }
}
