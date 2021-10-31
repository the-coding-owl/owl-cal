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

/**
 * Calendar model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Calendar extends AbstractEntity {
    /**
     * @var string
     * @Validate("NotEmpty")
     */
    protected string $title = '';

    /**
     * @var Event[]
     * @Validate("NotEmpty")
     */
    protected array $events = [];

    /**
     * @var User
     * @Validate("NotEmpty")
     * @Validate("\TheCodingOwl\OwlCal\Validation\Validator\UserPermissionValidator")
     */
    protected User $owner;

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
     * Get the events
     * 
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * Set the events
     * 
     * @param Event[] $events
     * @return self
     */
    public function setEvents(array $events): self
    {
        $this->events = $events;
        return $this;
    }

    /**
     * Get the owner
     *
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * Set the owner
     *
     * @param User $owner
     * @return self
     */
    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }
}