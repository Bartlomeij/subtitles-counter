<?php

use PHPUnit\Framework\TestCase;
use SubtitlesCounter\Infrastructure\SubtitlesFile\Parser\TxtParser;

/**
 * Class TxtParserTest
 */
class TxtParserTest extends TestCase
{
    /**
     * @var TxtParser
     */
    private $txtParser;

    public function setUp(): void
    {
        $this->txtParser = new TxtParser();
    }

    public function testParseCurlyBrackets()
    {
        $content = <<<EOT
        {1500}{1530}Mamy towarzystwo
        {2128}{2171}Nie mam amunicji, komandorze
        {2216}{2247}Tych nie marnuj
        {2525}{2567}Od teraz to sprawa osobista
        {3207}{3246}Jestem na to za stary
        EOT;

        $sections = $this->txtParser->parse($content);

        $this->assertEquals(5, sizeof($sections));
        $this->assertEquals('Mamy towarzystwo', $sections[0]->getText());
        $this->assertEquals('2171', $sections[1]->getEndTime());
        $this->assertEquals('2216', $sections[2]->getStartTime());
    }

    public function testParseSquareBrackets()
    {
        $content = <<<EOT
        [1723][1744]Możesz to załatwić?
        [1753][1786]Dobrze.Widzimy się za parę godzin.
        [1787][1804]Wiadomo, gdzie on jest?
        [1804][1826]Visser przyjechał rano do Waszyngtonu.
        [1827][1845]To na co czekamy? Zwińmy go.
        [1845][1875]- Nie możemy. - Czemu?|- Bo nie jest na terytorium USA.
        EOT;

        $sections = $this->txtParser->parse($content);

        $this->assertEquals(6, sizeof($sections));
        $this->assertEquals('Możesz to załatwić?', $sections[0]->getText());
        $this->assertEquals('1786', $sections[1]->getEndTime());
        $this->assertEquals('1787', $sections[2]->getStartTime());
    }
}