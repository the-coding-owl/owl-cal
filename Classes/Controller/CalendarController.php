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
use TheCodingOwl\OwlCal\Domain\Repository\CalendarRepository;
use TheCodingOwl\OwlCal\Domain\Repository\UserRepository;
use TheCodingOwl\OwlCal\Property\TypeConverter\IcsFileConverter;
use TheCodingOwl\OwlCal\Session\ViewSession;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;

/**
 * Controller class for the calendar objects
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class CalendarController extends ActionController {
    /**
     * @var ModuleTemplateFactory
     */
    protected ModuleTemplateFactory $moduleTemplateFactory;

    /**
     * @var CalendarRepository
     */
    protected CalendarRepository $calendarRepository;

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
        UserRepository $userRepository,
        ViewSession $viewSession
    )
    {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
        $this->calendarRepository = $calendarRepository;
        $this->userRepository = $userRepository;
        $this->viewSession = $viewSession;
    }

    /**
     * Index action
     *
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        if (!$this->settings['vue']['enable']) {
            return new RedirectResponse($this->uriBuilder->uriFor(
                'list',
                [],
                $this->request->getControllerName(),
                $this->request->getControllerExtensionName(),
                $this->request->getPluginName()
            ));
        }
        return $this->createBackendResponse();
    }

    /**
     * Show the given calendar
     *
     * @param Calendar $calendar The calendar to show
     * @return ResponseInterface
     */
    public function showAction(Calendar $calendar): ResponseInterface
    {
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse(['calendar' => $calendar->toArray()]);
        }
        return $this->createBackendResponse();
    }

    /**
     * Show the new form for creating a new calendar
     *
     * @param Calendar|null $calendar The calendar to create
     * @IgnoreValidation(argumentName="calendar")
     * @return ResponseInterface
     */
    public function newAction(Calendar $calendar = null): ResponseInterface
    {
        $owner = $this->userRepository->findCurrentUser();
        $this->view->assign('owner', $owner);
        $this->view->assign('calendar', $calendar);
        return $this->createBackendResponse();
    }

    /**
     * Initialize the create function and force the user to the currently logged in user
     */
    public function initializeCreateAction(): void
    {
        if ($this->request->hasArgument('calendar')) {
            $calendar = $this->request->getArgument('calendar');
            $calendar['owner'] = $this->userRepository->findCurrentUser()->getUid();
            $this->request->setArgument('calendar', $calendar);
            $this->arguments->getArgument('calendar')->getPropertyMappingConfiguration()->allowAllProperties();
        }
    }

    /**
     * Persist the given calendar
     *
     * @param Calendar $calendar The calendar to persist
     * @return ResponseInterface
     */
    public function createAction(Calendar $calendar): ResponseInterface
    {
        $this->calendarRepository->add($calendar);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse(['calendar' => $calendar]);
        }

        $this->addFlashMessage(
            LocalizationUtility::translate(
                'calendar.create.success',
                $this->request->getControllerExtensionName(),
                [$calendar->getTitle()]
            ),
            LocalizationUtility::translate(
                'calendar.create.success.title',
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
     * List all calendars of the current user
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $currentUser = $this->userRepository->findCurrentUser();
        $calendars = $this->calendarRepository->findByOwner($currentUser->getUid());
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse((array) $calendars);
        }
        $weeks = [];
        $currentDate = new \DateTime();
        $daysOfMonth = $currentDate->format('t');
        $date = clone $currentDate;
        $date->modify('-' . $currentDate->format('d') . ' days');
        for ($i = 1; $i <= $daysOfMonth; $i++) {
            $date->modify('+1 day');
            $week = $date->format('W');
            $weeks[$week][] = clone $date;
        }
        $this->view->assign('weeks', $weeks);
        $this->view->assign('currentMonth', $currentDate->format('n'));
        $this->view->assign('currentYear', $currentDate->format('Y'));
        $this->view->assign('months', range(1, 12));
        $this->view->assign('years', range(1970, 2100));
        $this->view->assign('calendars', $calendars);
        return $this->createBackendResponse();
    }

    /**
     * Show the form for editing the given calendar
     *
     * @param Calendar $calendar The calendar to edit
     * @IgnoreValidation(argumentName="calendar")
     * @return ResponseInterface
     */
    public function editAction(Calendar $calendar): ResponseInterface
    {
        $this->view->assign('calendar', $calendar);
        return $this->createBackendResponse();
    }

    /**
     * Persist the changed calendar
     *
     * @param Calendar $calendar The calendar to persist
     * @return ResponseInterface
     */
    public function saveAction(Calendar $calendar): ResponseInterface
    {
        $this->calendarRepository->update($calendar);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse($calendar->toArray());
        }
        $this->addFlashMessage(
            LocalizationUtility::translate(
                'calendar.save.success',
                $this->request->getControllerExtensionName(),
                [$calendar->getTitle()]
            ),
            LocalizationUtility::translate(
                'calendar.save.success.title',
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
     * Delete the given calendar
     *
     * @param Calendar $calendar
     * @return ResponseInterface
     */
    public function deleteAction(Calendar $calendar): ResponseInterface
    {
        $this->calendarRepository->remove($calendar);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse(['status' => 'success']);
        }
        $this->addFlashMessage(
            LocalizationUtility::translate(
                'calendar.delete.success',
                $this->request->getControllerExtensionName(),
                [$calendar->getTitle()]
            ),
            LocalizationUtility::translate(
                'calendar.delete.success.title',
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
     * Show the form for importing a calendar
     *
     * @return ResponseInterface
     */
    public function showImportFormAction(): ResponseInterface
    {
        return $this->createBackendResponse();
    }

    /**
     * Set the type converter for the import action
     *
     * @return void
     */
    public function initializeImportAction(): void
    {
        $this->arguments->getArgument('calendar')
            ->getPropertyMappingConfiguration()
            ->setTypeConverter(new IcsFileConverter());
    }

    /**
     * Import a calendar via ics file
     *
     * @param Calendar $calendar
     */
    public function importAction(Calendar $calendar)
    {
        $this->calendarRepository->add($calendar);
        if ($this->request->getFormat() === 'json') {
            return new JsonResponse($calendar->toArray());
        }
        $this->addFlashMessage(
            LocalizationUtility::translate(
                'calendar.import.successfull',
                $this->request->getControllerExtensionName(),
                [$calendar->getTitle()]
            ),
            LocalizationUtility::translate(
                'calendar.import.successfull.title',
                $this->request->getControllerExtensionName()
            ),
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
