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
 * Validator class that checks if a given string is a valid password
 * 
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class PasswordValidator extends AbstractValidator {
    /**
     * Checks if the given value is a valid password string
     * 
     * @param string $value
     * @return void
     */
    public function isValid($value)
    {
        if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/', $value)) {
            $this->addError('Password has to contain uppercase, lowercase, numbers and special characters!', 1000);
        }
    }
}