<?php

declare(strict_types=1);

namespace SubtitlesCounter\Domain\SubtitlesFile\Factory;

use SubtitlesCounter\Domain\SubtitlesFile;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileExtensionNotAllowedException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileNotFoundException;

/**
 * Class SubtitleFileFactory
 */
class SubtitleFileFactory
{
    /**
     * @param string $fileName
     * @param string $path
     * @return SubtitlesFile
     * @throws FileExtensionNotAllowedException
     * @throws FileNotFoundException
     */
    public static function createNewFile(string $fileName, string $path): SubtitlesFile
    {
        return new SubtitlesFile($fileName, $path);
    }
}