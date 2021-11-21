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

use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;
use TYPO3\CMS\Extbase\Validation\Error;

/**
 * This converter takes a split datetime and combines them into a datetime object
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class CombinedDateTimeTypeConverter extends AbstractTypeConverter {
    /**
     * Convert the given values to a proper DateTime object
     *
     * @param array $source
     * @param string $targetType
     * @param array $convertedChildProperties
     * @param PropertyMappingConfiguration $configuration
     * @return \DateTime|Error
     */
    public function convertFrom($source, string $targetType, array $convertedChildProperties = [], PropertyMappingConfigurationInterface $configuration = null)
    {
        if (!is_array($source)) {
            return new Error('No valid date!', 1637513016);
        }
        if (!isset($source['date'])) {
            return new Error('No date given!', 1637513005);
        }
        if ($source['date'] === '') {
            return null;
        }
        try {
            return new \DateTime($source['date'] . ' ' . $source['time']);
        } catch(\Exception $e) {
            return new Error('No valid date!', 1637513016);
        }
    }
}
