<?php

declare(strict_types=1);

namespace SubtitlesCounter\Infrastructure\SubtitlesFile\Parser;

use SubtitlesCounter\Domain\SubtitlesFile\Parser\ParserInterface;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\SubtitlesSection;

/**
 * Class SrtParser
 * @package SubtitlesCounter\Infrastructure\SubtitlesFile\Parser
 */
class SrtParser implements ParserInterface
{
    /**
     * @param string $content
     * @return SubtitlesSection[]
     */
    public function parse(string $content): array
    {
        $splitContent = $this->splitContent($content);
        $sections = $this->buildSections($splitContent);
        return $sections;
    }

    /**
     * @param string $data
     * @return array
     */
    private function splitContent(string $data): array
    {
        $sections = preg_split(
            '/\d+(?:\r\n|\r|\n)(?=(?:\d\d:\d\d:\d\d,\d\d\d)\s-->\s(?:\d\d:\d\d:\d\d,\d\d\d))/m',
            $data,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $matches = [];
        foreach ($sections as $section) {
            $section = preg_replace(
                '/[^\PC\s]/u',
                '',
                $section
            );

            if($section === null || trim($section) === '') {
                continue;
            }
            $section = preg_split(
                '/(\r\n|\r|\n)/m',
                $section,
                2,
                PREG_SPLIT_NO_EMPTY
            );
            $matches[] = $section;
        }
        return $matches;
    }

    /**
     * @param $matches
     * @return SubtitlesSection[]
     */
    private function buildSections($matches): array
    {
        $sections = [];
        foreach ($matches as $match) {
            $times = $this->timeMatch($match[0]);
            $text = $this->textMatch($match[1]);
            $sections[] = new SubtitlesSection($times['start_time'], $times['end_time'], $text);
        }
        return $sections;
    }

    /**
     * @param string $time
     * @return array
     */
    private function timeMatch(string $time): array
    {
        $matches = [];
        preg_match_all(
            '/(\d\d:\d\d:\d\d,\d\d\d)\s-->\s(\d\d:\d\d:\d\d,\d\d\d)/m',
            $time,
            $matches,
            PREG_SET_ORDER
        );
        $time = $matches[0];

        return [
            'start_time' => $time[1],
            'end_time'   => $time[2]
        ];
    }

    /**
     * @param string $text
     * @return string
     */
    private function textMatch(string $text): string
    {
        $text = rtrim($text);
        $text = str_replace("\r\n", "\n", $text);
        return $text;
    }
}