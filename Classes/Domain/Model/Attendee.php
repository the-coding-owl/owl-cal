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
 * Model class for an attendee
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Attendee extends AbstractEntity
{
    /**
     * @var string
     * @Validate("NotEmpty")
     */
    protected string $name = '';
    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("EmailAddress")
     */
    protected string $email = '';
    /**
     * @var string
     */
    protected string $participation = '';
    /**
     * @var string
     */
    protected string $role = '';

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the email
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get participation
     *
     * @return string
     */
    public function getParticipation(): string
    {
        return $this->participation;
    }

    /**
     * Set participation
     *
     * @param string $participation
     * @return self
     */
    public function setParticipation(string $participation): self
    {
        $this->participation = $participation;
        return $this;
    }

    /**
     * Get the role
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Set the role
     *
     * @param string $role
     * @return self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}
