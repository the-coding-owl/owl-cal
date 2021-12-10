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
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Journal model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Journal extends AbstractEntity implements AttachmentsInterface {
    /**
     * @var ObjectStorage<FileReference>|null
     * @Lazy
     */
    protected ?ObjectStorage $files = null;

    public function __construct()
    {
        $this->files = new ObjectStorage();
    }

    /**
     * Get the files
     *
     * @return ObjectStorage
     */
    public function getFiles(): ObjectStorage
    {
        return $this->files ?? new ObjectStorage();
    }

    /**
     * Set the files
     *
     * @param ObjectStorage<FileReference> $files
     * @return self
     */
    public function setFiles(ObjectStorage $files): self
    {
        $this->files = $files;
        return $this;
    }

    /**
     * Add the given file
     *
     * @param FileReference $file
     * @return self
     */
    public function addFile(FileReference $file): self
    {
        $this->files->attach($file);
        return $this;
    }

    /**
     * Remove the given file
     *
     * @param FileReference $fileToRemove
     * @return self
     */
    public function removeFile(FileReference $fileToRemove): self
    {
        $this->files->detach($fileToRemove);
        return $this;
    }
}
