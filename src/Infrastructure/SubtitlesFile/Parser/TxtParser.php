<?php

declare(strict_types=1);

namespace SubtitlesCounter\Infrastructure\SubtitlesFile\Parser;

use SubtitlesCounter\Domain\SubtitlesFile\Parser\ParserInterface;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\SubtitlesSection;

/**git
 * Class TxtParser
 * @package SubtitlesCounter\Infrastructure\SubtitlesFile\Parser
 */
class TxtParser implements ParserInterface
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
        $data = str_replace("{", "[", $data);
        $data = str_replace("}", "]", $data);

        $sections = preg_split(
            '/(?=(\[(?:\d)+\]\[(?:\d)+\]))/m',
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

            $matches[] = preg_split(
                '/\]/m',
                $section,
                -1,
                PREG_SPLIT_NO_EMPTY
            );
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
            $startTime = $this->timeMatch($match[0]);
            $endTime = $this->timeMatch($match[1]);
            $text = $this->textMatch($match[2]);
            $sections[] = new SubtitlesSection($startTime, $endTime, $text);
        }
        return $sections;
    }

    /**
     * @param string $time
     * @return string
     */
    private function timeMatch(string $time): string
    {
        return preg_replace("/[\{\[\]\}]/", "", $time);
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