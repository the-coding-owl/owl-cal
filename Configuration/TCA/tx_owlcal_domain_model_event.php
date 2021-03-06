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
        'summary' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'identifier' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'place' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'recurring' => [
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
        'recurrence_interval' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'recurring_times' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'recurring_until' => [
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime,null'
            ]
        ],
        'starttime' => [
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime,null'
            ]
        ],
        'endtime' => [
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime,null'
            ]
        ],
        'timezone' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'whole_day' => [
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
        'status' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'www_address' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'description' => [
            'config' => [
                'type' => 'text'
            ]
        ],
        'icon' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'calendar' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_owlcal_domain_model_calendar'
            ]
        ],
        'attendees' => [
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_owlcal_domain_model_attendee',
                'foreign_field' => 'event'
            ]
        ],
        'reminders' => [
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_owlcal_domain_model_reminder',
                'foreign_field' => 'event'
            ]
        ],
        'attachments' => [
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_owlcal_domain_model_attachment',
                'foreign_table_field' => 'tablename',
                'foreign_match_fields' => [
                    'fieldname' => 'attachments'
                ]
            ]
        ],
        'categories' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_owlcal_domain_model_category',
                'MM' => 'tx_owlcal_domain_model_event_category_mm'
            ]
        ],
        'class' => [
            'config' => [
                'type' => 'input'
            ]
        ],
        'comment' => [
            'config' => [
                'type' => 'text'
            ]
        ]
    ],
    'palettes' => [],
    'types' => []
];
