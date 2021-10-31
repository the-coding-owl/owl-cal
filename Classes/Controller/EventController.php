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

namespace TheCodingOwl\OwlCal\Controller;

use Psr\Http\Message\ResponseInterface;
use TheCodingOwl\OwlCal\Domain\Model\Calendar;
use TheCodingOwl\OwlCal\Domain\Model\Event;
use TheCodingOwl\OwlCal\Domain\Repository\EventRepository;
use TheCodingOwl\OwlCal\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;

/**
 * Event controller
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class EventController extends ActionController {
    /**
     * @var EventRepository
     */
    protected EventRepository $eventRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    public function __construct(EventRepository $eventRepository, UserRepository $userRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating new events
     * 
     * @param Calendar $calendar The calendar to use for the new event
     * @param Event|null $event The new event
     * @IgnoreValidation(argumentName="calendar")
     * @return ResponseInterface
     */
    public function newAction(Calendar $calendar, Event $event = null): ResponseInterface
    {
        $this->view->assign('event', $event);
        $this->view->assign('calendar', $calendar);
        return new HtmlResponse($this->view->render());
    }

    /**
     * Persist the new event to database
     * 
     * @param Event $event The event to persist
     * @return ResponseInterface
     */
    public function createAction(Event $event): ResponseInterface
    {
        $this->addFlashMessage(
            LocalizationUtility::translate('event.create.success'), 
            LocalizationUtility::translate('event.create.success.title')
        );
        $this->eventRepository->add($event);
        return new RedirectResponse($this->uriBuilder->uriFor(
            'show', 
            ['calendar' => $event->getCalendar()->getUid()], 
            $this->request->getControllerName(), 
            $this->request->getControllerExtensionName(), 
            $this->request->getPluginName()
        ));
    }

    /**
     * Show the form for the edit view
     * 
     * @param Event $event The event to edit
     * @IgnoreValidation(argumentName="event")
     * @return ResponseInterface
     */
    public function editAction(Event $event): ResponseInterface
    {
        $this->view->assign('event', $event);
        return new HtmlResponse($this->view->render());
    }

    /**
     * Persist the event changes
     * 
     * @param Event $event The event to edit
     * @return ResponseInterface
     */
    public function saveAction(Event $event): ResponseInterface
    {
        $this->addFlashMessage(
            LocalizationUtility::translate('event.save.success'), 
            LocalizationUtility::translate('event.save.success.title')
        );
        $this->eventRepository->update($event);
        return new RedirectResponse($this->uriBuilder->uriFor(
            'show', 
            ['calendar' => $event->getCalendar()->getUid()], 
            CalendarController::class, 
            $this->request->getControllerExtensionName(), 
            $this->request->getPluginName()
        ));
    }
}