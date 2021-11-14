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

namespace TheCodingOwl\OwlCal\Domain\Repository;

use TheCodingOwl\OwlCal\Domain\Model\User;
use TheCodingOwl\OwlCal\Exception\UserNotFoundException;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository class for users
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class UserRepository extends Repository {
    /**
     * Find the currently logged in user
     *
     * @return User
     */
    public function findCurrentUser(): User
    {
        $currentUser = $this->findByUid($this->getBackendUser()->user['uid']);
        if ($currentUser === null) {
            throw new UserNotFoundException('Current user could not be found!', 1001);
        }
        return $currentUser;
    }

    /**
     * Get the Backend user object aka $GLOBALS['BE_USER']
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
