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

use GuzzleHttp\Psr7\Uri;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Event model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Event extends AbstractEntity {
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
     * @var \DateTime
     * @Validate("NotEmpty")
     */
    protected \DateTime $starttime;
    /**
     * @var \DateTime
     */
    protected \DateTime $endtime;
    /**
     * @var \DateTimeZone
     * @Validate("NotEmpty")
     */
    protected \DateTimeZone $timezone;
    /**
     * @var bool
     */
    protected bool $wholeDay = false;
    /**
     * @var Status
     * @Validate("NotEmpty")
     */
    protected Status $status;
    /**
     * @var Uri
     */
    protected Uri $wwwAddress;
    /**
     * @var string
     */
    protected string $description = '';
    /**
     * @var Calendar
     * @Validate("NotEmpty")
     */
    protected Calendar $calendar;

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
     * @param \DateTime $endtime
     * @return self
     */
    public function setEndtime(\DateTime $endtime): self
    {
        $this->endtime = $endtime;
        return $this;
    }

    /**
     * Get the timezone
     * 
     * @return \DateTimeZone
     */
    public function getTimezone(): \DateTimeZone
    {
        return $this->timezone;
    }

    /**
     * Set the timezone
     * 
     * @param \DateTimeZone $timezone
     * @return self
     */
    public function setTimezone(\DateTimeZone $timezone): self
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
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * Set status
     * 
     * @param Status $status
     * @return self
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get www address
     * 
     * @return Uri|null
     */
    public function getWwwAddress(): ?Uri
    {
        return $this->wwwAddress;
    }

    /**
     * Set www address
     * 
     * @param Uri $wwwAddress
     * @return self
     */
    public function setWwwAddress(Uri $wwwAddress): self
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
            'endtime' => $this->endtime->format('r'),
            'timezone' => $this->timezone->getName(),
            'wholeDay' => $this->wholeDay,
            'status' => $this->status->getValue(),
            'wwwAddress' => (string) $this->wwwAddress,
            'description' => $this->description,
            'calendar' => $this->calendar->getUid()
        ];
    }
}