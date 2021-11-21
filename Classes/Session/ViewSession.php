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

namespace TheCodingOwl\OwlCal\Session;

use TheCodingOwl\OwlCal\Exception\InvalidDateException;
use TheCodingOwl\OwlCal\Exception\UnsupportedViewModeException;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * This class holds the session data of what view is selected.
 * This includes the selected calendar, the selected date and the settings
 * of which view should be shown.
 *
 * @author Kevin Ditscheid<kevin@the-coding-owl.de>
 */
class ViewSession {
    public const VIEW_MODE_NEXT = 'next';
    public const VIEW_MODE_MONTH = 'month';
    public const VIEW_MODE_WEEK = 'week';
    public const VIEW_MODE_DAY = 'day';
    /**
     * @var BackendUserAuthentication
     * @internal
     */
    protected BackendUserAuthentication $beUser;
    /**
     * @var int[]
     */
    protected array $selectedCalendars = [];
    /**
     * @var int
     */
    protected int $selectedMonth = 1;
    /**
     * @var int
     */
    protected int $selectedYear = 0;
    /**
     * @var string
     */
    protected string $viewMode = self::VIEW_MODE_WEEK;

    public function __construct(BackendUserAuthentication $beUser)
    {
        $this->beUser = $beUser;
        $this->loadSessionData();
    }

    /**
     * Load the session data
     */
    protected function loadSessionData(): void
    {
        $owlCalSettings = $this->beUser->getSessionData('tx_owlcal_view');
        if (is_array($owlCalSettings)){
            $currentDate = new \DateTime();
            $this->selectedCalendars = $owlCalSettings['selectedCalendars'] ?? [];
            $this->selectedMonth = $owlCalSettings['selectedMonth'] ?? $currentDate->format('n');
            $this->selectedYear = $owlCalSettings['selectedYear'] ?? $currentDate->format('Y');
            $this->viewMode = $owlCalSettings['viewMode'] ?? self::VIEW_MODE_WEEK;
        } else {
            $currentDate = new \DateTime();
            $this->selectedMonth = $currentDate->format('n');
            $this->selectedYear = $currentDate->format('Y');
        }
    }

    /**
     * Set the selected calendars
     *
     * @param int[] An array of calendar ids
     * @return self
     */
    public function setSelectedCalendars(array $calendars): self
    {
        $this->selectedCalendars = $calendars;
        return $this;
    }

    /**
     * Get the selected calendars
     *
     * @return int[]
     */
    public function getSelectedCalendars(): array
    {
        return $this->selectedCalendars;
    }

    /**
     * Add a calendar to the list of selected calendars
     *
     * @return self
     */
    public function addSelectedCalendar(int $calendar): self
    {
        $this->selectedCalendars[] = $calendar;
        $this->selectedCalendars = array_unique($this->selectedCalendars, \SORT_NUMERIC);
        return $this;
    }

    /**
     * Remove the given calendar from the list of selected calendars
     *
     * @return self
     */
    public function removeSelectedCalendar(int $calendarToRemove): self
    {
        $this->selectedCalendars = array_splice(
            $this->selectedCalendars,
            array_search(
                $calendarToRemove,
                $this->selectedCalendars
            ),
            1
        );
        return $this;
    }

    /**
     * Get the first calendar out of the list of selected calendars
     * Returns 0 if there are no selected calendars
     *
     * @return int
     */
    public function getFirstSelectedCalendar(): int
    {
        if (count($this->selectedCalendars) > 0) {
            return $this->selectedCalendars[0];
        }
        return 0;
    }

    /**
     * Set the selected month
     *
     * @param int $selectedMonth The numerical month that should be selected
     * @return self
     */
    public function setSelectedMonth(int $selectedMonth): self
    {
        if ($selectedMonth > 12 || $selectedMonth < 1) {
            throw new InvalidDateException('The entered month "' . $selectedMonth . '" is invalid!');
        }
        $this->selectedMonth = $selectedMonth;
        return $this;
    }

    /**
     * Get the selected month
     *
     * @return int
     */
    public function getSelectedMonth(): int
    {
        return $this->selectedMonth;
    }

    /**
     * Set the selected year
     *
     * @param int $selectedYear The year that should be selected
     */
    public function setSelectedYear(int $selectedYear): self
    {
        $this->selectedYear = $selectedYear;
        return $this;
    }

    /**
     * Get the selected year
     *
     * @return int
     */
    public function getSelectedYear(): int
    {
        return $this->selectedYear;
    }

    /**
     * Set the view mode
     *
     * @param string $viewMode The view mode to select
     * @return self
     */
    public function setViewMode(string $viewMode): self
    {
        if(!in_array($viewMode, [
            self::VIEW_MODE_DAY,
            self::VIEW_MODE_MONTH,
            self::VIEW_MODE_NEXT,
            self::VIEW_MODE_WEEK
        ])){
            throw new UnsupportedViewModeException('The view mode "' . $viewMode . '" is not supported!');
        }
        $this->viewMode = $viewMode;
        return $this;
    }

    /**
     * Get the view mode
     *
     * @return string
     */
    public function getViewMode(): string
    {
        return $this->viewMode;
    }
}
