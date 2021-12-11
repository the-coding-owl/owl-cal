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

use TheCodingOwl\OwlCal\Domain\Model\Calendar;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * This validator is used to validate the ical version of the calendar
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class VersionValidator extends AbstractValidator
{
    /**
     * Checks if the given value is a valid version
     *
     * @param string $value The version number to check
     * @return void
     */
    public function isValid($value)
    {
        if (empty($value)) {
            return;
        }
        if (version_compare($value, Calendar::VERSION, '>')) {
            $this->addError(
                'The version number is to high, please use iCal version "' . Calendar::VERSION . '" or lower',
                1639151614,
                [
                    'suppliedVersion' => $value,
                    'maxVersion' => Calendar::VERSION
                ]
            );
        }
    }
}
