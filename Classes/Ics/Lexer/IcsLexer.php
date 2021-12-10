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

namespace TheCodingOwl\OwlCal;

/**
 * Lexer class that can bring a given string into a data structure
 *
 * @author Kevin Ditscheid <kevin@the-coding-owl.de>
 */
class IcsLexer {
    private const PROPERTY_PREGMATCH = '/(?<property>[\w\-\;\=\/]+):(?<value>.*)/';
    /**
     * @var string
     */
    protected string $content = '';
    /**
     * @var array
     */
    protected array $structure = [];

    public function __construct(string $content)
    {
        $this->content = $content;
        $this->start();
    }

    /**
     * Start the lexer
     *
     * @return void
     */
    protected function start(): void
    {
        $lines = explode(PHP_EOL, $this->content);
        $structure = [];
        $previous = null;
        $index = 0;
        foreach ($lines as $line) {
            if ($previous !== null && strpos($line, ' ') === 0) {
                // First character is a whitespace and there is a previous entry,
                // probably a continuation of the contentline
                $structure[$previous]['value'] .= substr($line, 1);
                continue;
            }
            $parts = [];
            $result = preg_match_all(self::PROPERTY_PREGMATCH, $line, $parts);
            if ($result === false) {
                throw new \Exception('There was an error in the preg match function', 1638880734);
            }
            if ($result > 0 && count($parts) > 0) {
                $parameters = explode(';', $parts['property'][0]);
                $property = array_shift($parameters);
                $structure[$index] = [
                    'property' => $property,
                    'parameters' => $parameters,
                    'value' => trim($parts['value'][0])
                ];
                $previous = $index;
                $index++;
            }
        }
        $this->structure = $structure;
    }

    /**
     * Get the structure
     *
     * @return array
     */
    public function getStructure(): array
    {
        return $this->structure;
    }

    /***
     * Get the content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
