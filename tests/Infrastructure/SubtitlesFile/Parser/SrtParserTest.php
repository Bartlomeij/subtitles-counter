<?php

use PHPUnit\Framework\TestCase;
use SubtitlesCounter\Infrastructure\SubtitlesFile\Parser\SrtParser;

/**
 * Class SrtParserTest
 */
class SrtParserTest extends TestCase
{
    /**
     * @var SrtParser
     */
    private $srtParser;

    public function setUp(): void
    {
        $this->srtParser = new SrtParser();
    }

    public function testParse()
    {
        $content = <<<EOT
        10
        00:01:30,165 --> 00:01:32,845
        HUMANITARNE ZWALCZANIE MYSZY
        
        11
        00:01:43,485 --> 00:01:44,445
        Co tam w szkole?
        
        12
        00:01:45,765 --> 00:01:47,285
        Dobrze.
        
        13
        00:01:47,805 --> 00:01:49,685
        To byli twoi koledzy?
        
        14
        00:01:51,685 --> 00:01:54,685
        Nie wiem. Jeszcze nie rozmawialiśmy.
        
        15
        00:01:55,725 --> 00:01:57,205
        Wszystko się ułoży.
        EOT;

        $sections = $this->srtParser->parse($content);

        $this->assertEquals(6, sizeof($sections));
        $this->assertEquals('HUMANITARNE ZWALCZANIE MYSZY', $sections[0]->getText());
        $this->assertEquals('00:01:44,445', $sections[1]->getEndTime());
        $this->assertEquals('00:01:45,765', $sections[2]->getStartTime());
    }
}