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

namespace TheCodingOwl\OwlCal\Validation\Validator;

use TheCodingOwl\OwlCal\Domain\Model\Event;
use TheCodingOwl\OwlCal\Exception\InvalidParameterTypeException;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator that checks if the input is a valid DateTimeZone
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class StatusValidator extends AbstractValidator
{
    /**
     * Check if the input is a valid status
     *
     * @param string $value
     * @return void
     * @throws InvalidParameterTypeException if the given value is not a string
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            throw new InvalidParameterTypeException('The given value is not a string!');
        }
        if ($value === '') {
            return;
        }
        if (!in_array($value, [
            Event::STATUS_CANCELED,
            Event::STATUS_CONFIRMED,
            Event::STATUS_NONE,
            Event::STATUS_TENTATIVE
        ])) {
            $this->addError('The given value is not a valid status!', 1637512916);
        }
    }
}
