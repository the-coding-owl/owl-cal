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

namespace TheCodingOwl\OwlCal\Ics\Parser;

use TYPO3\CMS\Core\SingletonInterface;
use TheCodingOwl\OwlCal\Ics\Parser\ParserInterface;

/**
 * Registry for iCal object parsers
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class ParserRegistry implements SingletonInterface
{
    protected array $parsers = [];
    protected array $propertyParsers = [];

    /**
     * Register a parser for an iCal object
     *
     * @param string $className The parser class name
     * @param string $iCalObject The name of the iCal object
     * @return self
     */
    public function registerParser(string $className, string $iCalObject): self
    {
        if (!is_subclass_of($className, ParserInterface::class)) {
            throw new \Exception(
                'Parser "' . $className . '" must implement "' . ParserInterface::class . '"!',
                1639174977
            );
        }
        $this->parsers[$iCalObject] = $className;
        return $this;
    }

    /**
     * Register a property parser
     *
     * @param string $className The parser class name
     * @param string $iCalProperty The name of the property
     * @return self
     */
    public function registerPropertyParser(string $className, string $iCalProperty): self
    {
        if (!is_subclass_of($className, ParserInterface::class)) {
            throw new \Exception(
                'Parser "' . $className . '" must implement "' . ParserInterface::class . '"!',
                1639174977
            );
        }
        $this->propertyParsers[$iCalProperty] = $className;
        return $this;
    }

    /**
     * Instanciate a parser for the given iCal object
     *
     * @param string $iCalObject The name of the iCal object
     * @return ParserInterface
     */
    public function instanciateParserFor(string $iCalObject): ParserInterface
    {
        if (!(isset($this->parsers[$iCalObject]))) {
            throw new \Exception('No parser found for iCal object"' . $iCalObject . '"!', 1639174716);
        }
        $parserClassName = $this->parsers[$iCalObject];
        return new $parserClassName();
    }

    /**
     * Instanciate a property parser for the given iCal property
     *
     * @param string $iCalProperty The name of the iCal property
     * @return ParserInterface
     */
    public function instanciatePropertyParserFor(string $iCalProperty): ParserInterface
    {
        if (!(isset($this->propertyParsers[$iCalProperty]))) {
            throw new \Exception('No parser found for iCal property"' . $iCalProperty . '"!', 1639176563);
        }
        $parserClassName = $this->parsers[$iCalProperty];
        return new $parserClassName();
    }
}
