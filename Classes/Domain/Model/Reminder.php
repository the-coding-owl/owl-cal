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
 * Reminder model
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Reminder extends AbstractEntity {
    public const TYPE_PUSH = 'push';
    public const TYPE_EMAIL = 'email';
    public const BEFORE_BEGINNING_OF_EVENT = 'before beginning';
    public const AFTER_BEGINNING_OF_EVENT = 'after beginning';
    public const BEFORE_END_OF_EVENT = 'before end';
    public const AFTER_END_OF_EVENT = 'after end';

    /**
     * @var string
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\ReminderTypeValidator")
     * @Validate("NotEmpty")
     */
    protected string $type = '';
    /**
     * @var Timing|null
     */
    protected ?Timing $timing = null;
    /**
     * @var bool
     */
    protected bool $recurring = false;
    /**
     * @var int
     */
    protected int $recurringTimes = 0;
    /**
     * @var Timing|null
     */
    protected ?Timing $recurrenceTiming = null;
    /**
     * @var string
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\RemindAtValidator")
     */
    protected $remindAt = self::BEFORE_BEGINNING_OF_EVENT;

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
     * Get the timing
     *
     * @return Timing|null
     */
    public function getTiming(): ?Timing
    {
        return $this->timing;
    }

    /**
     * Set the timing
     *
     * @param Timing $timing
     * @return self
     */
    public function setTiming(Timing $timing): self
    {
        $this->timing = $timing;
        return $this;
    }

    /**
     * Is recurring
     *
     * @return bool
     */
    public function isRecurring(): bool
    {
        return $this->recurring;
    }

    /**
     * Set recurring
     *
     * @param bool $recurring
     * @return self
     */
    public function setRecurring(bool $recurring): self
    {
        $this->recurring = $recurring;
        return $this;
    }

    /**
     * Get the recurrence times
     *
     * @return int
     */
    public function getRecurrenceTimes(): int
    {
        return $this->recurrenceTimes;
    }

    /**
     * Set the recurrence times
     *
     * @param int $recurrenceTimes
     * @return self
     */
    public function setRecurrenceTimes(int $recurrenceTimes): self
    {
        $this->recurrenceTimes = $recurrenceTimes;
        return $this;
    }

    /**
     * Get the recurrence timing
     *
     * @return Timing|null
     */
    public function getRecurrenceTiming(): ?Timing
    {
        return $this->recurrenceTiming;
    }

    /**
     * Set the recurrence timing
     *
     * @param Timing $recurrenceTiming
     * @return self
     */
    public function setRecurrenceTiming(Timing $recurrenceTiming): self
    {
        $this->recurrenceTiming = $recurrenceTiming;
        return $this;
    }

    /**
     * Get when the reminder will trigger
     *
     * @return string
     */
    public function getRemindAt(): string
    {
        return $this->remindAt;
    }

    /**
     * Set when the reminder will trigger
     *
     * @param string $remindAt
     * @return self
     */
    public function setRemindAt(string $remindAt): self
    {
        $this->remindAt = $remindAt;
        return $this;
    }
}
