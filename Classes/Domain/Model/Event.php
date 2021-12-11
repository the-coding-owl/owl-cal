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

namespace TheCodingOwl\OwlCal\Domain\Model;

use TheCodingOwl\OwlCal\Domain\Interface\AttachmentsInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Event model
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class Event extends AbstractEntity implements AttachmentsInterface
{
    public const STATUS_NONE = 'none';
    public const STATUS_TENTATIVE = 'tentative';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';
    /**
     * @var string
     * @Validate("NotEmpty")
     */
    protected string $summary = '';
    /**
     * @var string
     */
    protected string $identifier = '';
    /**
     * @var string
     */
    protected string $place = '';
    /**
     * @var ObjectStorage<Recurrence>|null
     */
    protected ?ObjectStorage $recurrences = null;
    /**
     * @var Date|null
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\NotEmptyValidator")
     */
    protected ?Date $starttime = null;
    /**
     * @var Date|null
     */
    protected ?Date $endtime = null;
    /**
     * @var bool
     */
    protected bool $wholeDay = false;
    /**
     * @var string
     * @Validate("NotEmpty")
     * @Validate("TheCodingOwl\OwlCal\Validation\Validator\StatusValidator")
     */
    protected string $status = self::STATUS_TENTATIVE;
    /**
     * @var string
     */
    protected string $wwwAddress = '';
    /**
     * @var string
     */
    protected string $description = '';
    /**
     * @var string
     */
    protected string $icon = '';
    /**
     * @var Date|null
     */
    protected ?Date $crdate = null;
    /**
     * @var Date|null
     */
    protected ?Date $tstamp = null;
    /**
     * @var Calendar|null
     * @Validate("NotEmpty")
     */
    protected ?Calendar $calendar = null;
    /**
     * @var ObjectStorage<Attendee>|null
     * @Lazy
     */
    protected ?ObjectStorage $attendees = null;
    /**
     * @var ObjectStorage<Reminder>|null
     * @Lazy
     */
    protected ?ObjectStorage $reminders = null;

    /**
     * @var ObjectStorage<Attachment>|null
     * @Lazy
     */
    protected ?ObjectStorage $attachments = null;

    public function __construct()
    {
        $this->attendees = new ObjectStorage();
        $this->reminders = new ObjectStorage();
        $this->attachments = new ObjectStorage();
        $this->recurrences = new ObjectStorage();
    }

    /**
     * Get the summary
     *
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * Set the summary
     *
     * @param string $summary
     * @return self
     */
    public function setSummary(string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Get the identifier
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Set the identifier
     *
     * @param string $identifier
     * @return self
     */
    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Get the place
     *
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * Set the place
     *
     * @param string $place
     * @return self
     */
    public function setPlace(string $place): self
    {
        $this->place = $place;
        return $this;
    }

    /**
     * Get all recurrences
     *
     * @return ObjectStorage
     */
    public function getRecurrences(): ObjectStorage
    {
        return $this->recurrences ?? new ObjectStorage();
    }

    /**
     * Set all recurrences
     *
     * @param ObjectStorage $recurrences
     * @return self
     */
    public function setRecurrences(ObjectStorage $recurrences): self
    {
        $this->recurrences = $recurrences;
        return $this;
    }

    /**
     * Add a recurrence
     *
     * @param Recurrence $recurrence
     * @return self
     */
    public function addRecurrence(Recurrence $recurrence): self
    {
        $this->recurrences->attach($recurrence);
        return $this;
    }

    /**
     * Remove a recurrence
     *
     * @param Recurrence $recurrenceToRemove
     * @return self
     */
    public function removeRecurrence(Recurrence $recurrenceToRemove): self
    {
        $this->recurrences->detach($recurrenceToRemove);
        return $this;
    }

    /**
     * Get starttime
     *
     * @return Date
     */
    public function getStarttime(): Date
    {
        return $this->starttime;
    }

    /**
     * Set starttime
     *
     * @param Date $starttime
     * @return self
     */
    public function setStarttime(Date $starttime): self
    {
        $this->starttime = $starttime;
        return $this;
    }

    /**
     * Get endtime
     *
     * @return Date|null
     */
    public function getEndtime(): ?Date
    {
        return $this->endtime;
    }

    /**
     * Set endtime
     *
     * @param Date|null $endtime
     * @return self
     */
    public function setEndtime(Date $endtime = null): self
    {
        $this->endtime = $endtime;
        return $this;
    }

    /**
     * Is whole day
     *
     * @return bool
     */
    public function isWholeDay(): bool
    {
        return $this->wholeDay;
    }

    /**
     * Set whole day
     *
     * @param bool $wholeDay
     * @return self
     */
    public function setWholeDay(bool $wholeDay): self
    {
        $this->wholeDay = $wholeDay;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get www address
     *
     * @return string
     */
    public function getWwwAddress(): string
    {
        return $this->wwwAddress;
    }

    /**
     * Set www address
     *
     * @param string $wwwAddress
     * @return self
     */
    public function setWwwAddress(string $wwwAddress): self
    {
        $this->wwwAddress = $wwwAddress;
        return $this;
    }

    /**
     * Get the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set the icon
     *
     * @param string $icon
     * @return self
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get calendar
     *
     * @return Calendar
     */
    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    /**
     * Set calendar
     *
     * @param Calendar $calendar
     * @return self
     */
    public function setCalendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;
        return $this;
    }

    /**
     * Get the attendees
     *
     * @return ObjectStorage
     */
    public function getAttendees(): ObjectStorage
    {
        return $this->attendees ?? new ObjectStorage();
    }

    /**
     * Set the attendees
     *
     * @param ObjectStorage<Attendee> $attendees
     * @return self
     */
    public function setAttendees(ObjectStorage $attendees): self
    {
        $this->attendees = $attendees;
        return $this;
    }

    /**
     * Add the given attendee
     *
     * @param Attendee $attendee
     * @return self
     */
    public function addAttendee(Attendee $attendee): self
    {
        $this->attendees->attach($attendee);
        return $this;
    }

    /**
     * Remove the given attendee
     *
     * @param Attendee $attendeeToRemove
     * @return self
     */
    public function removeAttendee(Attendee $attendeeToRemove): self
    {
        $this->attendees->detach($attendeeToRemove);
        return $this;
    }

    /**
     * Get the reminders
     *
     * @return ObjectStorage
     */
    public function getReminders(): ObjectStorage
    {
        return $this->reminders ?? new ObjectStorage();
    }

    /**
     * Set the reminders
     *
     * @param ObjectStorage<Reminder> $reminders
     * @return self
     */
    public function setReminders(ObjectStorage $reminders): self
    {
        $this->reminders = $reminders;
        return $this;
    }

    /**
     * Add the given reminder
     *
     * @param Reminder $reminder
     * @return self
     */
    public function addReminder(Reminder $reminder): self
    {
        $this->reminders->attach($reminder);
        return $this;
    }

    /**
     * Remove the given reminder
     *
     * @param Reminder $reminderToRemove
     * @return self
     */
    public function removeReminder(Reminder $reminderToRemove): self
    {
        $this->reminders->detach($reminderToRemove);
        return $this;
    }

    /**
     * Get the attachments
     *
     * @return ObjectStorage
     */
    public function getAttachments(): ObjectStorage
    {
        return $this->attachments ?? new ObjectStorage();
    }

    /**
     * Set the attachments
     *
     * @param ObjectStorage<Attachment> $attachments
     * @return self
     */
    public function setAttachments(ObjectStorage $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * Add the given attachment
     *
     * @param Attachment $attachment
     * @return self
     */
    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments->attach($attachment);
        return $this;
    }

    /**
     * Remove the given attachment
     *
     * @param Attachment $attachmentToRemove
     * @return self
     */
    public function removeAttachment(Attachment $attachmentToRemove): self
    {
        $this->attachments->detach($attachmentToRemove);
        return $this;
    }

    /**
     * Get the crdate
     *
     * @return Date
     */
    public function getCrdate(): Date
    {
        return $this->crdate;
    }

    /**
     * Set the crdate
     *
     * @param Date $crdate
     * @return self
     */
    public function setCrdate(Date $crdate): self
    {
        $this->crdate = $crdate;
        return $this;
    }

    /**
     * Get the tstamp
     *
     * @return Date
     */
    public function getTstamp(): Date
    {
        return $this->tstamp;
    }

    /**
     * Set the tstamp
     *
     * @param Date $tstamp
     * @return self
     */
    public function setTstamp(Date $tstamp): self
    {
        $this->tstamp = $tstamp;
        return $this;
    }

    /**
     * Create an array representation of the event
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'place' => $this->place,
            'recurring' => $this->recurring,
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
            'timezone' => $this->timezone,
            'wholeDay' => $this->wholeDay,
            'status' => $this->status,
            'wwwAddress' => $this->wwwAddress,
            'description' => $this->description,
            'calendar' => $this->calendar->getUid(),
            'icon' => $this->icon,
            'attendees' => $this->attendees->count(),
            'reminders' => $this->reminders->count(),
            'attachments' => $this->attachments->count()
        ];
    }
}
