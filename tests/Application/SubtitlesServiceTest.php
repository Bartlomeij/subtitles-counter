<?php

use PHPUnit\Framework\TestCase;
use SubtitlesCounter\Application\SubtitlesService;
use SubtitlesCounter\Domain\SubtitlesFile;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\ParserInterface;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\SubtitlesSection;
use SubtitlesCounter\Infrastructure\SubtitlesFile\Parser\SrtParser;
use SubtitlesCounter\Infrastructure\SubtitlesFile\Parser\TxtParser;

/**
 * Class SubtitlesServiceTest
 */
class SubtitlesServiceTest extends TestCase
{
    /**
     * @var SubtitlesService
     */
    private $subtitlesService;

    public function setUp(): void
    {
        $this->subtitlesService = new SubtitlesService();
    }

    public function testGetSubtitlesWordsTable()
    {
        $testFile = '/tmp/file.txt';
        $handle = fopen($testFile, 'w');
        $data = '[123][456]This is the data';
        fwrite($handle, $data);

        $wordsTable = $this->subtitlesService->getSubtitlesWordsTable($testFile, $testFile);
        $this->assertEquals(4, sizeof($wordsTable));
        $this->assertArrayHasKey('this', $wordsTable);
        $this->assertArrayHasKey('is', $wordsTable);
        $this->assertArrayHasKey('the', $wordsTable);
        $this->assertArrayHasKey('data', $wordsTable);
    }

    public function testGetParserForSrtFile()
    {
        $srtFileMock = $this->createMock(SubtitlesFile::class);
        $srtFileMock->method('getExtension')->willReturn(SubtitlesFile::EXTENSION_SRT);

        $parser = $this->subtitlesService->getParserForSubtitlesFile($srtFileMock);
        $this->assertInstanceOf(ParserInterface::class, $parser);
        $this->assertInstanceOf(SrtParser::class, $parser);
    }

    public function testGetParserForTxtFile()
    {
        $srtFileMock = $this->createMock(SubtitlesFile::class);
        $srtFileMock->method('getExtension')->willReturn(SubtitlesFile::EXTENSION_TXT);

        $parser = $this->subtitlesService->getParserForSubtitlesFile($srtFileMock);
        $this->assertInstanceOf(ParserInterface::class, $parser);
        $this->assertInstanceOf(TxtParser::class, $parser);
    }

    public function testCountWordsInSubtitlesSections()
    {
        $sectionMock1 = $this->createMock(SubtitlesSection::class);
        $sectionMock1->method('getWordsArray')->willReturn([
            'sun',
            'earth',
            'moon',
        ]);

        $sectionMock2 = $this->createMock(SubtitlesSection::class);
        $sectionMock2->method('getWordsArray')->willReturn([
            'summer',
            'fall',
            'winter',
            'spring',
            'moon',
        ]);

        $wordsArray = $this->subtitlesService->countWordsInSubtitlesSections([
            $sectionMock1,
            $sectionMock2,
        ]);

        $this->assertEquals(7, sizeof($wordsArray));
        $this->assertEquals('moon', array_key_first($wordsArray));
        $this->assertEquals(2, $wordsArray['moon']);
    }
}