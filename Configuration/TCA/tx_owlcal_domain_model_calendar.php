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
        'title' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'identifier' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'version' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'events' => [
            'config' => [
                'default' => 0,
                'type' => 'inline',
                'foreign_table' => 'tx_owlcal_domain_model_event',
                'foreign_field' => 'calendar'
            ]
        ],
        'color' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'owner' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'be_users'
            ]
        ]
    ],
    'palettes' => [],
    'types' => []
];
