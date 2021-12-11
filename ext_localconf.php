<?php

(static function ($extKey) {
    $parserRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TheCodingOwl\OwlCal\Ics\Parser\ParserRegistry::class
    );
    $parserRegistry->registerParser(
        \TheCodingOwl\OwlCal\Ics\Parser\CalendarParser::class,
        'VCALENDAR'
    )->registerParser(
            \TheCodingOwl\OwlCal\Ics\Parser\EventParser::class,
            'VEVENT'
        )->registerParser(
            \TheCodingOwl\OwlCal\Ics\Parser\TodoParser::class,
            'VTODO'
        )->registerParser(
            \TheCodingOwl\OwlCal\Ics\Parser\JournalParser::class,
            'VJOURNAL'
        )->registerParser(
            \TheCodingOwl\OwlCal\Ics\Parser\AlarmParser::class,
            'VALARM'
        )->registerPropertyParser(
            \TheCodingOwl\OwlCal\Ics\Parser\FileParser::class,
            'ATTACH'
        )->registerPropertyParser(
            \TheCodingOwl\OwlCal\Ics\Parser\CategoryParser::class,
            'CATEGORIES'
        );
})('owl_cal');
