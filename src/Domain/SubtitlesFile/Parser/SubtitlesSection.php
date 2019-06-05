<?php

declare(strict_types=1);

namespace SubtitlesCounter\Domain\SubtitlesFile\Parser;

/**
 * Class SubtitlesSection
 * @package SubtitlesCounter\Domain\SubtitlesFile\Parser
 */
class SubtitlesSection
{
    const CONVERTED_TO_SPACE_VALUES = ["-",",",".","_",">","/","<",":",";","?","!","–","–"];

    const UNWANTED_VALUES = [" ","","\n"];

    /**
     * @var string
     */
    private $startTime;

    /**
     * @var string
     */
    private $endTime;

    /**
     * @var string
     */
    private $text;

    /**
     * SubtitlesSection constructor.
     * @param string $startTime
     * @param string $endTime
     * @param string $text
     */
    public function __construct(string $startTime, string $endTime, string $text)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @return string
     */
    public function getEndTime(): string
    {
        return $this->endTime;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string[]
     */
    public function getWordsArray(): array
    {
        $text = str_replace(self::CONVERTED_TO_SPACE_VALUES, " ", $this->getText());
        $text = strtolower(str_replace(self::UNWANTED_VALUES, "|", $text));
        $wordsArray = explode("|", htmlentities($text));
        return $wordsArray;
    }
}