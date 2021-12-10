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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Calendar model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Calendar extends AbstractEntity {
    public const SCALE_DEFAULT = 'GREGORIAN';
    public const VERSION = '2.0';

    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\Calendar\ScaleValidator")
     */
    protected $scale = self::SCALE_DEFAULT;
    /**
     * @var string
     * @Validate("NotEmpty")
     */
    protected string $title = '';
    /**
     * @var string
     * @Validate("NotEmpty")
     */
    protected string $identifier = '';
    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\Calendar\VersionValidator")
     */
    protected string $version = self::VERSION;
    /**
     * @var string
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\Calendar\ColorValidator")
     */
    protected string $color = '';
    /**
     * @var ObjectStorage<Event>
     * @Lazy
     */
    protected $events;
    /**
     * @var int
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\UserPermissionValidator")
     */
    protected int $owner = 0;

    public function __construct()
    {
        $this->events = new ObjectStorage();
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
     * Get the title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the title
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
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
     * Get the version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set the version
     *
     * @param string $version
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get the color
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Set the color
     *
     * @param string $color
     * @return self
     */
    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Get the events
     *
     * @return ObjectStorage
     */
    public function getEvents(): ObjectStorage
    {
        return $this->events;
    }

    /**
     * Set the events
     *
     * @param ObjectStorage $events
     * @return self
     */
    public function setEvents(ObjectStorage $events): self
    {
        $this->events = $events;
        return $this;
    }

    /**
     * Get the owner
     *
     * @return int
     */
    public function getOwner(): int
    {
        return $this->owner;
    }

    /**
     * Set the owner
     *
     * @param int $owner
     * @return self
     */
    public function setOwner(int $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Check of the calendar is visible
     *
     * @return bool
     * @TODO: Implement the actual logic
     */
    public function isVisible(): bool
    {
        return false;
    }

    /**
     * Create an array out of this object
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'title' => $this->title,
            'events' => $this->getEventsArray(),
            'owner' => $this->owner
        ];
    }

    /**
     * Get the events as their array representations
     *
     * @return array
     */
    public function getEventsArray(): array
    {
        $events = [];
        foreach ($this->events as $event) {
            $events[] = $event->toArray();
        }
        return $events;
    }
}
