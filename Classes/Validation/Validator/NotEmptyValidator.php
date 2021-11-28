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
 * Validates a value for emptyness.
 * It also respects the combined DateTime format used in this extension
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class NotEmptyValidator extends AbstractValidator {
    /**
     * Checks if the given value is valid
     *
     * @param mixed $value
     * @return void
     */
    public function isValid($value)
    {
        if (empty($value)) {
            $this->addError('The property must not be empty!', 1638038373);
            return;
        }
        if (is_array($value) && isset($value['date']) && empty($value['date'])) {
            $this->addError('The property must not be empty!', 1638038373);
            return;
        }
    }
}
