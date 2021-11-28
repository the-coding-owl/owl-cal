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

use DateTimeZone;
use Psr\Http\Message\ResponseInterface;
use TheCodingOwl\OwlCal\Domain\Model\Calendar;
use TheCodingOwl\OwlCal\Domain\Model\Event;
use TheCodingOwl\OwlCal\Domain\Repository\CalendarRepository;
use TheCodingOwl\OwlCal\Domain\Repository\EventRepository;
use TheCodingOwl\OwlCal\Domain\Repository\UserRepository;
use TheCodingOwl\OwlCal\Property\TypeConverter\CombinedDateTimeTypeConverter;
use TheCodingOwl\OwlCal\Session\ViewSession;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
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
     * @var ModuleTemplateFactory
     */
    protected ModuleTemplateFactory $moduleTemplateFactory;

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
        ModuleTemplateFactory $moduleTemplateFactory,
        CalendarRepository $calendarRepository,
        EventRepository $eventRepository,
        UserRepository $userRepository,
        ViewSession $viewSession
    )
    {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
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
        return $this->createBackendResponse();
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
        $this->setDefaultCalendar($calendar);
        $this->prepareEditViewVariables($calendar);
        $this->view->assign('event', $event);
        return $this->createBackendResponse();
    }

    /**
     * Initiliaze the create action and set some type converters
     *
     * @return void
     */
    public function initializeCreateAction(): void
    {
        $this->addTypeConverterToEventProperty('endtime', CombinedDateTimeTypeConverter::class);
        $this->addTypeConverterToEventProperty('starttime', CombinedDateTimeTypeConverter::class);
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
            'Calendar',
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
        $this->prepareEditViewVariables();
        $this->view->assign('event', $event);
        return $this->createBackendResponse();
    }

    /**
     * Initiliaze the save action and set some type converters
     *
     * @return void
     */
    public function initializeSaveAction(): void
    {
        $this->addTypeConverterToEventProperty('endtime', CombinedDateTimeTypeConverter::class);
        $this->addTypeConverterToEventProperty('starttime', CombinedDateTimeTypeConverter::class);
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
            LocalizationUtility::translate(
                'event.save.success',
                $this->request->getControllerExtensionName(),
                [$event->getTitle()]
            ),
            LocalizationUtility::translate(
                'event.save.success.title',
                $this->request->getControllerExtensionName()
            )
        );
        return new RedirectResponse($this->uriBuilder->uriFor(
            'list',
            [],
            'Calendar',
            $this->request->getControllerExtensionName(),
            $this->request->getPluginName()
        ));
    }

    /**
     * Delete an event
     *
     * @param Event $event
     * @return ResponseInterface
     */
    public function deleteAction(Event $event): ResponseInterface
    {
        $this->eventRepository->remove($event);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse(['status' => 'success']);
        }
        $this->addFlashMessage(
            LocalizationUtility::translate(
                'event.delete.success',
                $this->request->getControllerExtensionName(),
                [$event->getTitle()]
            ),
            LocalizationUtility::translate(
                'event.delete.success.title',
                $this->request->getControllerExtensionName()
            )
        );
        return new RedirectResponse($this->uriBuilder->uriFor(
            'list',
            [],
            'Calendar',
            $this->request->getControllerExtensionName(),
            $this->request->getPluginName()
        ));
    }

    /**
     * Add the list of calendars of the current user to the view
     *
     * @return void
     */
    protected function setCalendarList(): void
    {
        $currentUser = $this->userRepository->findCurrentUser();
        $calendars = $this->calendarRepository->findByOwner($currentUser->getUid());
        $this->view->assign('calendars', $calendars);
    }

    /**
     * Add the default selected calendar to the view
     *
     * @param Calendar|null $calendar
     * @return void
     */
    protected function setDefaultCalendar(Calendar $calendar = null): void
    {
        if ($calendar === null && $this->viewSession->getFirstSelectedCalendar()) {
            $calendar = $this->calendarRepository->findByUid(
                $this->viewSession->getFirstSelectedCalendar()
            );
        }
        $this->view->assign('calendar', $calendar);
    }

    /**
     * Add the list of statuses to the view
     *
     * @return void
     */
    protected function setStatusList(): void
    {
        $this->view->assign('status', [
            Event::STATUS_NONE,
            Event::STATUS_TENTATIVE,
            Event::STATUS_CONFIRMED,
            Event::STATUS_CANCELED]
        );
    }

    /**
     * Add the list of timezones to the view
     */
    protected function setTimezones(): void
    {
        $timezones = \DateTimeZone::listIdentifiers();
        $this->view->assign('defaultTimezone', (new \DateTime())->getTimezone()->getName());
        $this->view->assign('timezones', $timezones);
    }

    /**
     * Prepare the edit view variables and add them to the view
     *
     * @return void
     */
    protected function prepareEditViewVariables(): void
    {
        $this->setCalendarList();
        $this->setTimezones();
        $this->setStatusList();
    }

    /**
     * Add the given type converter to the defined property of an event
     *
     * @param string $property The property name of the event
     * @param string $typeConverter The class name of the type converter
     * @return void
     */
    protected function addTypeConverterToEventProperty(string $property, string $typeConverter): void
    {
        $this->arguments->getArgument('event')
            ->getPropertyMappingConfiguration()
            ->forProperty($property)
            ->setTypeConverter(new $typeConverter());
    }

    /**
     * Use the ModuleTemplateResponse to create a response object for the backend
     *
     * @return ResponseInterface
     */
    protected function createBackendResponse(): ResponseInterface
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }
}
