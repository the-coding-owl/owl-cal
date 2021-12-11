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

namespace TheCodingOwl\OwlCal\Property\TypeConverter;

use finfo;
use TheCodingOwl\OwlCal\IcsLexer;
use TheCodingOwl\OwlCal\IcsParser;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;
use TYPO3\CMS\Extbase\Validation\Error;

/**
 * This converter is used to convert an uploaded ics file to a calendar object
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class IcsFileConverter extends AbstractTypeConverter
{
    /**
     * Convert the given ics file to a Calendar
     *
     * @param string[] $source A $_FILES array representation of the uploaded ics file
     * @param string $targetType Will always be Calendar for this converter
     * @param array $convertedChildProperties
     * @param PropertyMappingConfigurationInterface $configuration
     * @return Calendar|Error
     */
    public function convertFrom($source, string $targetType, array $convertedChildProperties = [], PropertyMappingConfigurationInterface $configuration = null)
    {
        if (!isset($source['name'],$source['tmp_name'],$source['type'],$source['error'],$source['size'])) {
            return new Error('Upload data malformed', 1638803178);
        }
        if (substr($source['name'], -4) !== '.ics') {
            return new Error('Given file is not an ICS file', 1638803423);
        }
        $finfo = new finfo(FILEINFO_MIME);
        $mimeType = $finfo->file($source['tmp_name'], FILEINFO_MIME_TYPE);
        if ($mimeType !== 'text/calendar') {
            return new Error('Given file is not an ICS file', 1638803423);
        }
        $icsString = file_get_contents($source['tmp_name']);
        $icsLexer = new IcsLexer($icsString);
        $icsParser = new IcsParser($icsLexer->getStructure());
        $calendar = $icsParser->parse();
        return new Error('blubb', 123);
    }
}
