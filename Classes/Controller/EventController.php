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
use TheCodingOwl\OwlCal\Domain\Repository\CalendarRepository;
use TheCodingOwl\OwlCal\Domain\Repository\EventRepository;
use TheCodingOwl\OwlCal\Domain\Repository\UserRepository;
use TheCodingOwl\OwlCal\Property\TypeConverter\CombinedDateTimeTypeConverter;
use TheCodingOwl\OwlCal\Session\ViewSession;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Event controller
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class EventController extends ActionController {
    /**
     * @var PageRenderer
     */
    protected PageRenderer $pageRenderer;

    /**
     * @var CalendarRepository
     */
    protected CalendarRepository $calendarRepository;

    /**
     * @var EventRepository
     */
    protected EventRepository $eventRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var ViewSession
     */
    protected ViewSession $viewSession;

    public function __construct(
        PageRenderer $pageRenderer,
        CalendarRepository $calendarRepository,
        EventRepository $eventRepository,
        UserRepository $userRepository,
        ViewSession $viewSession
    )
    {
        $this->pageRenderer = $pageRenderer;
        $this->calendarRepository = $calendarRepository;
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->viewSession = $viewSession;
    }

    /**
     * Show the given event
     *
     * @param Event $event
     * @return ResponseInterface
     */
    public function showAction(Event $event): ResponseInterface
    {
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse($event->toArray());
        }

        $this->view->assign('event', $event);
        return new HtmlResponse($this->view->render());
    }

    /**
     * List events from a given calendar
     *
     * @param Calendar $calendar
     * @return ResponseInterface
     */
    public function listAction(Calendar $calendar): ResponseInterface
    {
        $events = $this->eventRepository->findByCalendar($calendar);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse((array) $events);
        }

        $this->view->assign('events', $events);
        $this->view->assign('calendar', $calendar);
        return new HtmlResponse($this->view->render());
    }

    /**
     * Show the form for creating new events
     *
     * @param Calendar|null $calendar The calendar to use for the new event
     * @param Event|null $event The new event
     * @IgnoreValidation(argumentName="calendar")
     * @return ResponseInterface
     */
    public function newAction(Calendar $calendar = null, Event $event = null): ResponseInterface
    {
        if ($calendar === null && $this->viewSession->getFirstSelectedCalendar()) {
            $calendar = $this->calendarRepository->findByUid(
                $this->viewSession->getFirstSelectedCalendar()
            );
        }
        $currentUser = $this->userRepository->findCurrentUser();
        $calendars = $this->calendarRepository->findByOwner($currentUser->getUid());
        $timezones = \DateTimeZone::listIdentifiers();
        $this->view->assign('calendars', $calendars);
        $this->view->assign('event', $event);
        $this->view->assign('calendar', $calendar);
        $this->view->assign('timezones', $timezones);
        $this->view->assign('status', [
            Event::STATUS_NONE,
            Event::STATUS_TENTATIVE,
            Event::STATUS_CONFIRMED,
            Event::STATUS_CANCELED]
        );
        $this->pageRenderer->setBodyContent($this->view->render());
        return $this->htmlResponse($this->pageRenderer->render());
    }

    /**
     * Initiliaze the create action and set some type converters
     *
     * @return void
     */
    public function initializeCreateAction(): void
    {
        $propertyMappingConfiguration = $this->arguments->getArgument('event')
            ->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->forProperty('endtime')
            ->setTypeConverter(new CombinedDateTimeTypeConverter());
        $propertyMappingConfiguration->forProperty('starttime')
            ->setTypeConverter(new CombinedDateTimeTypeConverter());
    }

    /**
     * Persist the new event to database
     *
     * @param Event $event The event to persist
     * @return ResponseInterface
     * @Validate("TheCodingOwl\OwlCal\Domain\Validator\EventValidator", param="event")
     */
    public function createAction(Event $event): ResponseInterface
    {
        $this->eventRepository->add($event);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse($event->toArray());
        }
        $this->addFlashMessage(
            LocalizationUtility::translate(
                'event.create.success',
                $this->request->getControllerExtensionName(),
                [$event->getTitle()]
            ),
            LocalizationUtility::translate(
                'event.create.success.title',
                $this->request->getControllerExtensionName()
            )
        );
        return new RedirectResponse($this->uriBuilder->uriFor(
            'list',
            [],
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
        $this->eventRepository->update($event);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse($event->toArray());
        }
        $this->addFlashMessage(
            LocalizationUtility::translate('event.save.success', $this->request->getControllerExtensionName()),
            LocalizationUtility::translate('event.save.success.title', $this->request->getControllerExtensionName())
        );
        return new RedirectResponse($this->uriBuilder->uriFor(
            'show',
            ['calendar' => $event->getCalendar()->getUid()],
            CalendarController::class,
            $this->request->getControllerExtensionName(),
            $this->request->getPluginName()
        ));
    }
}
