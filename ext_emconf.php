<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

 $EXT_CONF['owl_cal'] = [
    'title' => 'A calendar app',
    'description' => '',
    'category' => 'be',
    'author' => 'Kevin Ditscheid',
    'author_email' => 'kevin@the-coding-owl.de',
    'author_company' => '',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.21'
        ],
        'conflicts' => [],
        'suggests' => []
    ]
];