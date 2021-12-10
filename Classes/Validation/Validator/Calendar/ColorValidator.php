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

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * This validator is used to validate the calendar scale
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class ScaleValidator extends AbstractValidator {
    /**
     * Checks if the given value is a valid color code
     *
     * @param string $value The color code to check
     * @return void
     */
    public function isValid($value)
    {
        if (empty($value)) {
            return;
        }
        if (strpos($value, '#') !== 0 && !(strlen($value) === 7 || strlen($value) === 4)) {
            $this->addError('The given value is not a valid color code!', 1639151989);
        }
    }
}
