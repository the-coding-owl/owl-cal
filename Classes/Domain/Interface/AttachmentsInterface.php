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

namespace TheCodingOwl\OwlCal\Domain\Interface;

use TheCodingOwl\OwlCal\Domain\Model\Attachment;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Interface for objects that can have attachments
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
interface AttachmentsInterface
{
    public function getAttachments(): ObjectStorage;
    public function setAttachments(ObjectStorage $attachments): self;
    public function addAttachment(Attachment $attachment): self;
    public function removeAttachment(Attachment $attachmentToRemove): self;
}
