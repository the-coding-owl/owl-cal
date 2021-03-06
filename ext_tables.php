<?php

(static function ($extKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $extKey,
        'web',
        'tx_owlcal',
        '',
        [
            \TheCodingOwl\OwlCal\Controller\CalendarController::class =>
                'index,list,new,edit,create,save,delete,showImportForm,import',
            \TheCodingOwl\OwlCal\Controller\EventController::class =>
                'new,edit,create,save,delete'
        ],
        [
            'access' => 'user,group',
            'iconIdentifier' => 'owl-cal-extension',
            'labels' => 'LLL:EXT:'. $extKey . '/Resources/Private/Language/locallang_mod.xlf',
            'navigationComponentId' => '', // TODO: Create a custom implementation for viewing different calendars
            'inheritNavigationComponentFromMainModule' => false
        ]
    );
})('owl_cal');
