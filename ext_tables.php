<?php

(static function($extKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $extKey,
        'web', 
        'tx_owlcal',
        '',
        [
            \TheCodingOwl\OwlCal\Controller\CalendarController::class => 'list,new,edit,create,save',
            \TheCodingOwl\OwlCal\Domain\Model\Event::class => 'new,edit,create,save'
        ],
        [
            'access' => 'user,group',
            'iconIdentifier' => 'owl-cal-extension',
            'labels' => 'LLL:EXT:'. $extKey . '/Resources/Private/language_mod.xlf'
        ]
    );
})('owl_cal');
