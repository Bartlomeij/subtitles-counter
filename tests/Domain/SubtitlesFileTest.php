<?php

use PHPUnit\Framework\TestCase;
use SubtitlesCounter\Domain\SubtitlesFile;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileExtensionNotAllowedException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileNotFoundException;

/**
 * Class SubtitlesFileTest
 */
class SubtitlesFileTest extends TestCase
{
    public function testSubtitlesSrtFile()
    {
        $testFile = '/tmp/file.srt';
        $handle = fopen($testFile, 'w');
        $data = <<<EOT
        15
        00:01:55,725 --> 00:01:57,205
        Wszystko się ułoży.
        EOT;
        fwrite($handle, $data);

        $subtitlesFile = new SubtitlesFile($testFile, $testFile);
        $this->assertEquals($data, $subtitlesFile->getContent());
        $this->assertEquals($testFile, $subtitlesFile->getName());
        $this->assertEquals(SubtitlesFile::EXTENSION_SRT, $subtitlesFile->getExtension());
        $this->assertEquals($testFile, $subtitlesFile->getPath());
    }

    public function testSubtitlesTxtFile()
    {
        $testFile = '/tmp/file.txt';
        $handle = fopen($testFile, 'w');
        $data = '[123][456]This is the data';
        fwrite($handle, $data);

        $subtitlesFile = new SubtitlesFile($testFile, $testFile);
        $this->assertEquals($data, $subtitlesFile->getContent());
        $this->assertEquals($testFile, $subtitlesFile->getName());
        $this->assertEquals(SubtitlesFile::EXTENSION_TXT, $subtitlesFile->getExtension());
        $this->assertEquals($testFile, $subtitlesFile->getPath());
    }

    public function testSubtitlesFileUnsupportedExtension()
    {
        $testFile = '/tmp/file.csv';
        $handle = fopen($testFile, 'w');
        $data = 'This is the data';
        fwrite($handle, $data);

        $exception = null;
        try {
            new SubtitlesFile($testFile, $testFile);
        } catch (FileExtensionNotAllowedException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(FileExtensionNotAllowedException::class, $exception);
    }

    public function testSubtitlesFileDoesNotExist()
    {
        $exception = null;
        try {
            new SubtitlesFile('test.txt', '/tmp/foo');
        } catch (FileNotFoundException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(FileNotFoundException::class, $exception);
    }
}