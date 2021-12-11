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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Model representing an attachment
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Attachment extends AbstractEntity {
    /**
     * @var FileReference|null
     */
    protected ?FileReference $file = null;
    /**
     * @var string
     */
    protected string $uri = '';

    /**
     * Get the file
     *
     * @return FileReference|null
     */
    public function getFile(): ?FileReference
    {
        return $this->file;
    }

    /**
     * Set the file
     *
     * @param FileReference $file
     * @return self
     */
    public function setFile(FileReference $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get the uri
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Set the uri
     *
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }
}
