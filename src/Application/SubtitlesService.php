<?php

declare(strict_types=1);

namespace SubtitlesCounter\Application;

use SubtitlesCounter\Domain\SubtitlesFile;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\ParserInterface;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\SubtitlesTableLoadException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileExtensionNotAllowedException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileNotFoundException;
use SubtitlesCounter\Domain\SubtitlesFile\Factory\SubtitleFileFactory;
use SubtitlesCounter\Infrastructure\SubtitlesFile\Parser\SrtParser;
use SubtitlesCounter\Infrastructure\SubtitlesFile\Parser\TxtParser;

/**
 * Class SubtitlesService
 * @package App\Service
 */
class SubtitlesService
{
    /**
     * @param string $fileName
     * @param string $path
     * @return array
     * @throws FileExtensionNotAllowedException
     * @throws FileNotFoundException
     * @throws SubtitlesTableLoadException
     */
    public function getSubtitlesWordsTable(string $fileName, string $path): array
    {
        $subtitlesFile = SubtitleFileFactory::createNewFile($fileName, $path);
        $parser = $this->getParserForSubtitlesFile($subtitlesFile);
        $sections = $parser->parse($subtitlesFile->getContent());

        return $this->countWordsInSubtitlesSections($sections);
    }

    /**
     * @param SubtitlesFile $file
     * @return ParserInterface
     * @throws FileExtensionNotAllowedException
     */
    public function getParserForSubtitlesFile(SubtitlesFile $file): ParserInterface
    {
        switch ($file->getExtension()) {
            case SubtitlesFile::EXTENSION_SRT:
                return new SrtParser();
            case SubtitlesFile::EXTENSION_TXT:
                return new TxtParser();
        }

        throw new FileExtensionNotAllowedException(
            'File extension "'.$file->getExtension().'" is not allowed"'
        );
    }

    /**
     * @param array $sections
     * @return array
     * @throws SubtitlesTableLoadException
     */
    public function countWordsInSubtitlesSections(array $sections): array
    {
        $subtitlesTable = new SubtitlesFile\SubtitlesTable();
        $subtitlesTable->loadArray($sections);
        return $subtitlesTable->getWords();

    }
}