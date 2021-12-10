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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * File parser for the representation of attachments in ICS
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class FileParser implements ParserInterface {
    /**
     * The string representation of the file
     * @var string
     */
    protected string $fileString;
    /**
     * The parameters to help parse the file string
     * @var array
     */
    protected array $fileParameters;
    /**
     * The parent parser
     * @var ParserInterface
     */
    protected ParserInterface $parentParser;

    public function __construct(string $fileString, array $parameters = [])
    {
        $this->fileString = $fileString;
        $this->fileParameters = $parameters;
    }

    /**
     * Parse the file attachment
     *
     * @return FileReference
     */
    public function parse(): FileReference
    {
        return new FileReference();
    }

    /**
     * Get the parent parser
     *
     * @return ParserInterface
     */
    public function getParentParser(): ParserInterface
    {
        return $this->parentParser;
    }

    /**
     * Set the parent parser
     *
     * @param ParserInterface $parentParser
     * @return self
     */
    public function setParentParser(ParserInterface $parentParser): self
    {
        $this->parentParser = $parentParser;
        return $this;
    }
}
