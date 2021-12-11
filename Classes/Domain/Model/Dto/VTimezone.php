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

namespace TheCodingOwl\OwlCal\Domain\Model\Dto;

use TheCodingOwl\OwlCal\Domain\Model\Calendar;

/**
 * This model represents a timezone
 *
 * @author Kevin Ditscheid
 */
class VTimezone
{
    /**
     * @var Calendar
     */
    protected Calendar $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * Get the calendar
     *
     * @return Calendar
     */
    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    /**
     * Set the calendar
     *
     * @param Calendar $calendar
     * @return self
     */
    public function setCalendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;
        return $this;
    }
}
