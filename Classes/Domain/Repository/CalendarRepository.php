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

use TheCodingOwl\OwlCal\Domain\Model\Calendar;
use TheCodingOwl\OwlCal\Domain\Model\Dto\ICS;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Repository class for calendars
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class CalendarRepository extends Repository
{
    /**
     * Overwrite the createQuery function to disable storage page respect
     *
     * @return QueryInterface
     */
    public function createQuery()
    {
        $query = parent::createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query;
    }

    /**
     * Import a new calendar by the given ics file
     *
     * @param ICS $icsFile A converted ics file
     * @return Calendar
     */
    public function import(ICS $icsFile): Calendar
    {
        // TODO: Write import logic
        return new Calendar();
    }
}
