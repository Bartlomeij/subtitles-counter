<?php

use PHPUnit\Framework\TestCase;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\SubtitlesSection;
use SubtitlesCounter\Domain\SubtitlesFile\SubtitlesTable;

/**
 * Class SubtitlesTableTest
 */
class SubtitlesTableTest extends TestCase
{
    public function testLoad()
    {
        $subtitlesTable = new SubtitlesTable();
        $subtitlesTable->load(new SubtitlesSection(
            '00:02:37,367',
            '00:02:39,533',
            'Najpierw się poślizgnęłam, a ty przypadkowo mnie trafiłeś.'
        ));

        $words = $subtitlesTable->getWords();
        $this->assertEquals(8, sizeof($words));
        $this->assertEquals(1, $words['najpierw']);
        $this->assertEquals(1, $words['się']);
        $this->assertEquals(1, $words['poślizgnęłam']);
        $this->assertEquals(1, $words['a']);
        $this->assertEquals(1, $words['ty']);
        $this->assertEquals(1, $words['przypadkowo']);
        $this->assertEquals(1, $words['mnie']);
        $this->assertEquals(1, $words['trafiłeś']);

        $subtitlesTable->load(new SubtitlesSection(
            '00:02:54,984',
            '00:02:58,454',
            'A przez to wątpisz w siebie i stajesz się bezbronna.'
        ));

        $words = $subtitlesTable->getWords();
        $this->assertEquals(16, sizeof($words));
        $this->assertEquals(1, $words['najpierw']);
        $this->assertEquals(2, $words['się']);
        $this->assertEquals(1, $words['poślizgnęłam']);
        $this->assertEquals(2, $words['a']);
        $this->assertEquals(1, $words['ty']);
        $this->assertEquals(1, $words['przypadkowo']);
        $this->assertEquals(1, $words['mnie']);
        $this->assertEquals(1, $words['trafiłeś']);
        $this->assertEquals(1, $words['przez']);
        $this->assertEquals(1, $words['to']);
        $this->assertEquals(1, $words['wątpisz']);
        $this->assertEquals(1, $words['w']);
        $this->assertEquals(1, $words['siebie']);
        $this->assertEquals(1, $words['i']);
        $this->assertEquals(1, $words['stajesz']);
        $this->assertEquals(1, $words['bezbronna']);
    }
    public function testLoadArray()
    {
        $firstSection = new SubtitlesSection(
            '00:02:37,367',
            '00:02:39,533',
            'Najpierw się poślizgnęłam, a ty przypadkowo mnie trafiłeś.'
        );

        $secondSection = new SubtitlesSection(
            '00:02:54,984',
            '00:02:58,454',
            'A przez to wątpisz w siebie i stajesz się bezbronna.'
        );

        $subtitlesTable = new SubtitlesTable();
        $subtitlesTable->loadArray([
            $firstSection,
            $secondSection,
        ]);

        $words = $subtitlesTable->getWords();
        $this->assertEquals(16, sizeof($words));
        $this->assertEquals(1, $words['najpierw']);
        $this->assertEquals(2, $words['się']);
        $this->assertEquals(1, $words['poślizgnęłam']);
        $this->assertEquals(2, $words['a']);
        $this->assertEquals(1, $words['ty']);
        $this->assertEquals(1, $words['przypadkowo']);
        $this->assertEquals(1, $words['mnie']);
        $this->assertEquals(1, $words['trafiłeś']);
        $this->assertEquals(1, $words['przez']);
        $this->assertEquals(1, $words['to']);
        $this->assertEquals(1, $words['wątpisz']);
        $this->assertEquals(1, $words['w']);
        $this->assertEquals(1, $words['siebie']);
        $this->assertEquals(1, $words['i']);
        $this->assertEquals(1, $words['stajesz']);
        $this->assertEquals(1, $words['bezbronna']);
    }
}