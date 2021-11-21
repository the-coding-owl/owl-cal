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

namespace TheCodingOwl\OwlCal\Domain\Validator;

use TheCodingOwl\OwlCal\Domain\Model\Event;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator class that checks the event for validity
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class EventValidator extends AbstractValidator {
    /**
     * Check the validity of the event
     *
     * @param Event $value
     * @return void
     */
    public function isValid($value)
    {
        if (!($value instanceof Event)) {
            $this->addError('The given value is not an event!', 1637513029);
            return;
        }
        $endtime = $value->getEndtime();
        if ($endtime !== null) {
            $starttime = $value->getStarttime();
            if ($endtime < $starttime) {
                $this->addError(
                    'Endtime has to be greater then starttime',
                    1637513037,
                    [$starttime, $endtime]
                );
            }
        }
    }
}
