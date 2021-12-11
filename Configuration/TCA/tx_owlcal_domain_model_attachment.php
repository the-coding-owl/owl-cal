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

return [
    'ctrl' => [
        'hideTable' => true,
        'rootLevel' => 1,
        'crdate' => 'crdate',
        'tstamp' => 'tstamp',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted'
    ],
    'columns' => [
        'file' => [
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'files',
                [
                    'maxitems' => 1
                ]
            )
        ],
        'uri' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'tablename' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'uid_foreign' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'fieldname' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ]
    ],
    'palettes' => [],
    'types' => []
];
