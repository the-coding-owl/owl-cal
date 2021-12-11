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

/**
 * This model represents daylight timezone
 *
 * @author Kevin Ditscheid
 */
class Daylight
{
    /**
     * @var VTimezone
     */
    protected VTimezone $vtimezone;

    public function __construct(VTimezone $vtimezone)
    {
        $this->vtimezone = $vtimezone;
    }

    /**
     * Get the timezone object
     *
     * @return VTimezone
     */
    public function getVTimezone(): VTimezone
    {
        return $this->vtimezone;
    }

    /**
     * Set the timezone object
     *
     * @param VTimezone $vtimezone
     * @return self
     */
    public function setVTimezone(VTimezone $vtimezone): self
    {
        $this->vtimezone = $vtimezone;
        return $this;
    }
}
