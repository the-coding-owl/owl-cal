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
 * Timing model
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Timing extends AbstractEntity {
    public const SCALE_MINUTES = 'minutes';
    public const SCALE_HOURS = 'hours';
    public const SCALE_DAYS = 'days';
    public const SCALE_WEEKS = 'weeks';
    public const SCALE_MONTHS = 'months';
    public const SCALE_YEARS = 'years';
    /**
     * @var int
     * @Validate("NotEmpty")
     */
    protected int $time = 0;
    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\TimingScaleValidator")
     */
    protected string $scale = '';

    /**
     * Get the time
     *
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * Set the time
     *
     * @param int $time
     * @return self
     */
    public function setTime(int $time): self
    {
        $this->time = $time;
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
}
