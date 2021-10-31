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
use TheCodingOwl\OwlCal\Domain\Repository\UserRepository;
use TheCodingOwl\OwlCal\Exception\InvalidParameterTypeException;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator to check user permissions to a given calendar
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class UserPermissionValidator extends AbstractValidator {
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Check if the given value is valid
     * 
     * @param Calendar $value The Calendar to check
     * @return void
     */
    public function isValid($value)
    {
        if (!($value instanceof Calendar)) {
            throw new InvalidParameterTypeException('The given value is not of type Calendar!', 1002);
        }
        if ($value->getOwner() !== $this->userRespository->findCurrentUser()) {
            $this->addError('The current user is not allowed to see this calendar!', 1003);
        }
    }
}