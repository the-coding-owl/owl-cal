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

namespace TheCodingOwl\OwlCal\Ics\Parser;

use Exception;
use TheCodingOwl\OwlCal\Domain\Interface\AttachmentsInterface;
use TheCodingOwl\OwlCal\Domain\Model\Calendar;
use TheCodingOwl\OwlCal\Domain\Model\Dto\Daylight;
use TheCodingOwl\OwlCal\Domain\Model\Dto\Standard;
use TheCodingOwl\OwlCal\Domain\Model\Dto\VTimezone;
use TheCodingOwl\OwlCal\Domain\Model\Event;
use TheCodingOwl\OwlCal\Domain\Model\Reminder;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * An ICS parser that takes a structure from the IcsLexer and turns it
 * into Calenadar objects
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class IcsParser {
    /**
     * @var array
     */
    protected array $structure;

    public function __construct(array $structure)
    {
        $this->structure = $structure;
    }

    /**
     * Parse the structure and return a calendar
     *
     * @return Calendar
     */
    public function parse(): Calendar
    {
        $object = null;
        foreach ($this->structure as $line) {
            if ($line['property'] === 'BEGIN') {
                $this->createParser($line['value']);
                continue;
            } elseif ($line['property'] === 'END') {
                $parsedObjects = $this->currentParser->parse();
                continue;
            }
            if ($line['property'] === 'ATTACH') {
                $this->attachFile($line['value'], $line['parameters'], $object);
                continue;
            }
            $this->setToObject($line['property'], $line['value'], $line['parameters'], $object);
        }

        return $parsedObjects;
        return $object;
    }

    /**
     * Create an object of the given object type
     *
     * @return Calendar|Event|Reminder|VTimezone|Standard|Daylight
     */
    protected function createObject(string $objectType, $parentObject = null)
    {
        if ($objectType !== 'VCALENDAR' && $parentObject === null) {
            throw new Exception('Object of type "' . $objectType . '" must have a parent object!', 1638957905);
        }
        $object = null;
        switch ($objectType) {
            case 'VCALENDAR':
                $object = new Calendar();
                break;
            case 'VTIMEZONE':
                $object = new VTimezone($parentObject);
                break;
            case 'DAYLIGHT':
                $object = new Daylight($parentObject);
                break;
            case 'STANDARD':
                $object = new Standard($parentObject);
                break;
            case 'VEVENT':
                $object = new Event();
                $object->setCalendar($parentObject);
                break;
            case 'VALARM':
                $object = new Reminder();
                $object->setEvent($parentObject);
                break;
            default:
                throw new Exception('Unknown object type "' . $objectType . '"', 1638954090);
                break;
        }
        return $object;
    }

    /**
     * Close the object
     *
     * @param string $objectType
     * @param Calendar|Event|Reminder|VTimezone|Standard|Daylight $object
     * @return Calendar|Event|Reminder|VTimezone|Standard|Daylight|null
     */
    protected function closeObject(string $objectType, $object)
    {
        switch ($objectType) {
            case 'VCALENDAR':
                $object = null;
                break;
            case 'VTIMEZONE':
                $object = $object->getCalendar();
                break;
            case 'STANDARD':
                $object = $object->getVTimezone();
                break;
            case 'DAYLIGHT':
                $object = $object->getVTimezone();
                break;
            case 'VEVENT':
                $object = $object->getCalendar();
                break;
            case 'VALARM':
                $object = $object->getEvent();
                break;
            default:
                throw new Exception('Unknown object type "' . $objectType . '"', 1638954090);
                break;
        }
        return $object;
    }

    /**
     * Set a value to a given object
     *
     * @param string $property
     * @param string $value
     * @param array $parameters
     * @param Calendar|Event|Reminder|VTimezone|Standard|Daylight $object
     *
     * @return void
     */
    protected function setToObject(string $property, string $value, array $parameters, $object): void
    {
        if ($object instanceof Calendar) {
            $this->setToCalendar($property, $value, $parameters, $object);
            return;
        }
        if ($object instanceof VTimezone) {
            // Not implemented
            return;
        }
        if ($object instanceof Standard) {
            // Not implemented
            return;
        }
        if ($object instanceof Daylight) {
            // Not implemented
            return;
        }
        if ($object instanceof Event) {
            $this->setToEvent($property, $value, $parameters, $object);
            return;
        }
        if ($object instanceof Reminder) {
            $this->setToReminder($property, $value, $parameters, $object);
            return;
        }
    }

    /**
     * Set a value to the given calendar
     *
     * @param string $property
     * @param string $value
     * @param array $parameters
     * @param Calendar $calendar
     *
     * @return void
     */
    protected function setToCalendar(string $property, string $value, array $parameters, Calendar $calendar): void
    {
        switch ($property) {
            case 'VERSION':
                $calendar->setVersion($value);
                break;
            case 'CALSCALE':
                $calendar->setScale($value);
                break;
            case 'UID':
            case 'PRODID':
                $calendar->setIdentifier($value);
                break;
            case 'NAME':
            case 'X-WR-CALNAME':
                $calendar->setTitle($value);
                break;
            case 'COLOR':
            case 'X-APPLE-CALENDAR-COLOR':
                $calendar->setColor($value);
                break;
            default:
                throw new Exception('Unknown property "' . $property . '"!', 1638958135);
        }
    }

    /**
     * Set the given value to an event
     *
     * @param string $property
     * @param string $value
     * @param array $parameters
     * @param Event $event
     * @return void
     */
    protected function setToEvent(string $property, string $value, array $parameters, Event $event): void
    {
        switch ($property) {
            case 'DTSTART':
                $date = $this->convertDate($value, $parameters);
                $event->setStarttime($date);
                break;
            case 'SUMMARY':
                $event->setSummary($value);
                break;
            case 'TRANSP':
                break;
            case 'DTEND':
                $date = $this->convertDate($value, $parameters);
                $event->setEndtime($date);
                break;
            case 'LAST-MODIFIED':
                $date = $this->convertDate($value, $parameters);
                $event->setTstamp($date);
                break;
            case 'DTSTAMP':
                $date = $this->convertDate($value, $parameters);
                $event->setTstamp($date);
                break;
            case 'CREATED':
                $date = $this->convertDate($value, $parameters);
                $event->setCrdate($date);
                break;
            case 'UID':
                $event->setIdentifier($value);
                break;
            case 'STATUS':
                switch ($value) {
                    case 'CONFIRMED':
                        $value = Event::STATUS_CONFIRMED;
                        break;
                    default:
                        throw new \Exception('Unknown event status "' . $value . '"!', 1639040225);
                }
                $event->setStatus($value);
                break;
            default:
                throw new Exception('Unknown property "' . $property . '"!', 1638958135);
        }
    }

    /**
     * Set the given value to a reminder
     *
     * @param string $property
     * @param string $value
     * @param array $parameters
     * @param Reminder $reminder
     * @return void
     */
    protected function setToReminder(string $property, string $value, array $parameters, Reminder $reminder): void
    {
        switch ($property) {
            case 'ACTION':
                switch ($value) {
                    case 'EMAIL':
                        $value = Reminder::TYPE_EMAIL;
                        break;
                    case 'DISPLAY':
                        $value = Reminder::TYPE_PUSH;
                        break;
                    default:
                        throw new \Exception('Unknown action "' . $value . '"!', 1639041704);
                }
                $reminder->setType($value);
                break;
            case 'DESCRIPTION':
                $reminder->setDescription($value);
                break;
            case 'TRIGGER':
                $reminder->setInterval($value);
                break;
            case 'UID':
            case 'X-WR-ALARMUID':
            case 'X-EVOLUTION-ALARM-UID':
                $reminder->setIdentifier($value);
                break;
            default:
                throw new Exception('Unknown property "' . $property . '"!', 1638958135);
        }
    }

    /**
     * Find the timezone parameter
     *
     * @param array $parameters
     * @return string
     */
    protected function findTimezone(array $parameters): string
    {
        foreach ($parameters as $parameter) {
            if (substr($parameter, 0, 5) === 'TZID=') {
                return substr($parameter, 5);
            }
        }
        return '';
    }

    /**
     * Convert a date to a DateTime
     *
     * @param string $dateString
     * @param array $parameters
     * @return \DateTime
     */
    protected function convertDate(string $dateString, array $parameters): \DateTime
    {
        $timezone = $this->findTimezone($parameters);
        $date = new \DateTime($dateString);
        if ($timezone) {
            $date->setTimezone(new \DateTimeZone($timezone));
        }
        return $date;
    }

    protected function attachFile(string $file, array $parameters, $object): void
    {
        if ($objects instanceof AttachmentsInterface) {
            $fileParser = new FileParser($file, $parameters);
            $fileReference = $fileParser->parse();
            $objects->addFile($fileReference);
        }
    }
}
