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
use TheCodingOwl\OwlCal\Domain\Interface\CategoriesInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Abstract event model
 * Serves as a base for shared properties between events, journals and todos
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class AbstractEvent extends AbstractEntity implements AttachmentsInterface, CategoriesInterface
{
    public const CLASS_PUBLIC = 'PUBLIC';
    public const CLASS_PRIVATE = 'PRIVATE';
    public const CLASS_CONFIDENTIAL = 'CONFIDENTIAL';

    /**
     * @var ObjectStorage<Attachment>|null
     * @Lazy
     */
    protected ?ObjectStorage $attachments = null;

    /**
     * @var ObjectStorage<Category>|null
     * @Lazy
     */
    protected ?ObjectStorage $categories = null;

    /**
     * @var string $class
     */
    protected string $class = self::CLASS_PUBLIC;

    /**
     * @var string $comment
     */
    protected string $comment = '';

    /**
     * @var string
     */
    protected string $description = '';

    public function __construct()
    {
        $this->attachments = new ObjectStorage();
        $this->categories = new ObjectStorage();
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

    /**
     * Get the categories
     *
     * @return ObjectStorage
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories ?? new ObjectStorage();
    }

    /**
     * Set the categories
     *
     * @param ObjectStorage<Category> $categories
     * @return self
     */
    public function setCategories(ObjectStorage $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * Add the given category
     *
     * @param Category $category
     * @return self
     */
    public function addCategory(Category $category): self
    {
        $this->categores->attach($category);
        return $this;
    }

    /**
     * Remove the given category
     *
     * @param Category $categoryToRemove
     * @return self
     */
    public function removeCategory(Category $categoryToRemove): self
    {
        $this->categories->detach($categoryToRemove);
        return $this;
    }

    /**
     * Get the class
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Set the class
     *
     * @param string $class
     * @return self
     */
    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Get the commment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set the comment
     *
     * @param string $comment
     * @return self
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
