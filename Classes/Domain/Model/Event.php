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
 * Event model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Event extends AbstractEntity {
    public const STATUS_NONE = 'none';
    public const STATUS_TENTATIVE = 'tentative';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';
    public const RECURRING_SCALE_DAYS = 'days';
    public const RECURRING_SCALE_WEEKS = 'weeks';
    public const RECURRING_SCALE_MONTHS = 'months';
    public const RECURRING_SCALE_YEARS = 'years';
    /**
     * @var string
     * @Validate("NotEmpty")
     */
    protected string $title = '';
    /**
     * @var string
     */
    protected string $place = '';
    /**
     * @var bool
     */
    protected bool $recurring = false;
    /**
     * @var int
     */
    protected int $recurringTime = 0;
    /**
     * @var string
     */
    protected string $recurringScale = '';
    /**
     * @var int
     */
    protected int $recurringTimes = 0;
    /**
     * @var \DateTime|null
     */
    protected ?\DateTime $recurringUntil = null;
    /**
     * @var \DateTime|null
     * @Validate("NotEmpty")
     */
    protected ?\DateTime $starttime = null;
    /**
     * @var \DateTime|null
     */
    protected ?\DateTime $endtime = null;
    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\DateTimeZoneValidator")
     */
    protected string $timezone = '';
    /**
     * @var bool
     */
    protected bool $wholeDay = false;
    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\StatusValidator")
     */
    protected string $status = self::STATUS_TENTATIVE;
    /**
     * @var string
     */
    protected string $wwwAddress = '';
    /**
     * @var string
     */
    protected string $description = '';
    /**
     * @var string
     */
    protected string $icon = '';
    /**
     * @var Calendar|null
     * @Validate("NotEmpty")
     */
    protected ?Calendar $calendar = null;
    /**
     * @var ObjectStorage<Attendee>|null
     * @Lazy
     */
    protected ?ObjectStorage $attendees = null;

    public function __construct()
    {
        $this->attendees = new ObjectStorage();
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
     * Get the place
     *
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * Set the place
     *
     * @param string $place
     * @return self
     */
    public function setPlace(string $place): self
    {
        $this->place = $place;
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
     * Get the time of recurring
     *
     * @return int
     */
    public function getRecurringTime(): int
    {
        return $this->recurringTime;
    }

    /**
     * Set the time of recurring
     *
     * @param int $time
     * @return self
     */
    public function setRecurringTime(int $time): self
    {
        $this->recurringTime = $time;
        return $this;
    }

    /**
     * Get the recurring scale
     *
     * @return string
     */
    public function getRecurringScale(): string
    {
        return $this->recurringScale;
    }

    /**
     * Set the recurring scale
     *
     * @param string $scale
     * @return self
     */
    public function setRecurringScale(string $scale): self
    {
        $this->recurringScale = $scale;
        return $this;
    }

    /**
     * Get the amount of times of the recurrence
     *
     * @return int
     */
    public function getRecurringTimes(): int
    {
        return $this->recurringTimes;
    }

    /**
     * Set the amount of times of the recurrence
     *
     * @param int $times
     * @return self
     */
    public function setRecurringTimes(int $times): self
    {
        $this->recurringTimes = $times;
        return $this;
    }

    /**
     * Get the time until the recurrence ends
     *
     * @return \DateTime|null
     */
    public function getRecurringUntil(): ?\DateTime
    {
        return $this->recurringUntil;
    }

    /**
     * Set the time untul the recurrence ends
     *
     * @param string $until
     * @return self
     */
    public function setRecurringUntil(\DateTime $until): self
    {
        $this->recurringUntil = $until;
        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime
     */
    public function getStarttime(): \DateTime
    {
        return $this->starttime;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return self
     */
    public function setStarttime(\DateTime $starttime): self
    {
        $this->starttime = $starttime;
        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime|null
     */
    public function getEndtime(): ?\DateTime
    {
        return $this->endtime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime|null $endtime
     * @return self
     */
    public function setEndtime(\DateTime $endtime = null): self
    {
        $this->endtime = $endtime;
        return $this;
    }

    /**
     * Get the timezone
     *
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * Set the timezone
     *
     * @param string $timezone
     * @return self
     */
    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * Is whole day
     *
     * @return bool
     */
    public function isWholeDay(): bool
    {
        return $this->wholeDay;
    }

    /**
     * Set whole day
     *
     * @param bool $wholeDay
     * @return self
     */
    public function setWholeDay(bool $wholeDay): self
    {
        $this->wholeDay = $wholeDay;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get www address
     *
     * @return string
     */
    public function getWwwAddress(): string
    {
        return $this->wwwAddress;
    }

    /**
     * Set www address
     *
     * @param string $wwwAddress
     * @return self
     */
    public function setWwwAddress(string $wwwAddress): self
    {
        $this->wwwAddress = $wwwAddress;
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
     * Get the icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set the icon
     *
     * @param string $icon
     * @return self
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get calendar
     *
     * @return Calendar
     */
    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    /**
     * Set calendar
     *
     * @param Calendar $calendar
     * @return self
     */
    public function setCalendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;
        return $this;
    }

    /**
     * Get the attendees
     *
     * @return ObjectStorage
     */
    public function getAttendees(): ObjectStorage
    {
        return $this->attendees ?? new ObjectStorage();
    }

    /**
     * Set the attendees
     *
     * @param ObjectStorage<Attendee> $attendees
     * @return self
     */
    public function setAttendees(ObjectStorage $attendees): self
    {
        $this->attendees = $attendees;
        return $this;
    }

    /**
     * Add the given attendee
     *
     * @param Attendee $attendee
     * @return self
     */
    public function addAttendee(Attendee $attendee): self
    {
        $this->attendees->attach($attendee);
        return $this;
    }

    /**
     * Remove the given attendee
     *
     * @param Attendee $attendeeToRemove
     * @return self
     */
    public function removeAttendee(Attendee $attendeeToRemove): self
    {
        $this->attendees->detach($attendeeToRemove);
        return $this;
    }

    /**
     * Create an array representation of the event
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'place' => $this->place,
            'recurring' => $this->recurring,
            'starttime' => $this->starttime->format('r'),
            'endtime' => $this->endtime instanceof \DateTime ? $this->endtime->format('r') : '',
            'timezone' => $this->timezone,
            'wholeDay' => $this->wholeDay,
            'status' => $this->status,
            'wwwAddress' => $this->wwwAddress,
            'description' => $this->description,
            'calendar' => $this->calendar->getUid(),
            'icon' => $this->icon,
            'attendees' => $this->attendees->count()
        ];
    }
}
