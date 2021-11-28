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

use TheCodingOwl\OwlCal\Domain\Model\Reminder;
use TheCodingOwl\OwlCal\Domain\Model\Timing;
use TheCodingOwl\OwlCal\Exception\InvalidParameterTypeException;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator that checks if the input can be used in the
 * reminder for the remindAt property
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class RemindAtValidator extends AbstractValidator {
    /**
     * Check if the input is a valid value for the remindAt property
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
        $validValues = [
            Reminder::BEFORE_BEGINNING_OF_EVENT,
            Reminder::BEFORE_END_OF_EVENT,
            Reminder::AFTER_BEGINNING_OF_EVENT,
            Reminder::AFTER_END_OF_EVENT
        ];
        if(!in_array($value, $validValues)) {
            $this->addError(
                'The given value is not a valid value for the remindAt property! Valid values are "%s".',
                1637866215,
                [implode(', ', $validValues)]
            );
        }
    }
}
