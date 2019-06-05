<?php

use PHPUnit\Framework\TestCase;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\SubtitlesSection;

/**
 * Class SubtitlesSectionTest
 */
class SubtitlesSectionTest extends TestCase
{
    public function testSubtitlesSection()
    {
        $startTime = '123';
        $endTime = '321';
        $text = 'Wiadomość została przechwycona, a jego przykrywka spalona.';
        $subtitlesSection = new SubtitlesSection($startTime, $endTime, $text);
        $this->assertEquals($startTime, $subtitlesSection->getStartTime());
        $this->assertEquals($endTime, $subtitlesSection->getEndTime());
        $this->assertEquals($text, $subtitlesSection->getText());
        $this->assertEquals('wiadomość', $subtitlesSection->getWordsArray()[0]);
        $this->assertEquals('została', $subtitlesSection->getWordsArray()[1]);
        $this->assertEquals('przechwycona', $subtitlesSection->getWordsArray()[2]);
    }
}