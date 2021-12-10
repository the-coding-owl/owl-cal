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
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Reminder model
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Reminder extends AbstractEntity implements AttachmentsInterface {
    public const TYPE_PUSH = 'push';
    public const TYPE_EMAIL = 'email';

    /**
     * @var string
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\ReminderTypeValidator")
     * @Validate("NotEmpty")
     */
    protected string $type = '';
    /**
     * @var string
     */
    protected string $identifier = '';
    /**
     * @var string
     */
    protected string $description = '';
    /**
     * @var string
     */
    protected string $interval = '';
    /**
     * @var ObjectStorage<Recurrence>|null
     */
    protected ?ObjectStorage $recurrences = null;
    /**
     * @var Event|null
     */
    protected ?Event $event = null;
    /**
     * @var ObjectStorage<FileReference>|null
     * @Lazy
     */
    protected ?ObjectStorage $files = null;

    public function __construct()
    {
        $this->recurrences = new ObjectStorage();
        $this->files = new ObjectStorage();
    }

    /**
     * Get the type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the type
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the identifier
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Set the identifier
     *
     * @param string $identifier
     * @return self
     */
    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;
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

    /**
     * Get the amount
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Set the amount
     *
     * @param int $amount
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get the scale
     *
     * @return string
     */
    public function getScale(): string
    {
        return $this->scale;
    }

    /**
     * Set the scale
     *
     * @param string $scale
     * @return self
     */
    public function setScale(string $scale): self
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * Get the interval
     *
     * @return string
     */
    public function getInterval(): string
    {
        return $this->interval;
    }

    /**
     * Returns a DateInterval representation of the interval
     *
     * @return \DateInterval
     */
    public function getDateInterval(): \DateInterval
    {
        return new \DateInterval($this->interval);
    }

    /**
     * Set the interval
     *
     * @param string $timing
     * @return self
     */
    public function setInterval(string $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * Set the interval via a given DateInterval
     *
     * @param \DateInterval $dateInterval
     * @return self
     */
    public function setDateInterval(\DateInterval $dateInterval): self
    {
        $this->interval = $dateInterval->format('P%dDT%hH%iM%sS');
        return $this;
    }

    /**
     * Get all recurrences
     *
     * @return ObjectStorage
     */
    public function getRecurrences(): ObjectStorage
    {
        return $this->recurrences ?? new ObjectStorage();
    }

    /**
     * Set all recurrences
     *
     * @param ObjectStorage $recurrences
     * @return self
     */
    public function setRecurrences(ObjectStorage $recurrences): self
    {
        $this->recurrences = $recurrences;
        return $this;
    }

    /**
     * Add a recurrence
     *
     * @param Recurrence $recurrence
     * @return self
     */
    public function addRecurrence(Recurrence $recurrence): self
    {
        $this->recurrences->attach($recurrence);
        return $this;
    }

    /**
     * Remove a recurrence
     *
     * @param Recurrence $recurrenceToRemove
     * @return self
     */
    public function removeRecurrence(Recurrence $recurrenceToRemove): self
    {
        $this->recurrences->detach($recurrenceToRemove);
        return $this;
    }

    /**
     * Get the event
     *
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * Set the event
     *
     * @param Event $event
     * @return self
     */
    public function setEvent(Event $event): self
    {
        $this->event = $event;
        return $this;
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
