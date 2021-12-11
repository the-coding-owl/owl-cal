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

abstract class AbstractIcsParser implements ParserInterface
{
    public const ICALOBJECT_BEGIN = 'BEGIN';
    public const ICALOBJECT_END = 'END';

    protected ParserRegistry $parserRegistry;
    protected string $parserName = '';
    protected $parsedObject;

    public function __construct(ParserRegistry $parserRegistry)
    {
        $this->parserRegistry = $parserRegistry;
    }

    public function parse()
    {
        foreach ($this->lines as $line) {
            if ($line['property'] === self::ICALOBJECT_BEGIN) {
                $this->parserRegistry->instanciateParserFor($line['value']);
            }
        }
    }

    protected function parseAttachments()
    {
    }

    abstract protected function parseProperty();
    abstract public function getParserName(): string;
}
