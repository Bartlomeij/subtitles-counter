<?php

declare(strict_types=1);

namespace SubtitlesCounter\Domain;

use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileExtensionNotAllowedException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileNotFoundException;

/**
 * Class SubtitlesFile
 */
class SubtitlesFile
{
    const EXTENSION_SRT = 'srt';
    const EXTENSION_TXT = 'txt';

    const ALLOWED_EXTENSIONS = [
        self::EXTENSION_SRT,
        self::EXTENSION_TXT,
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * SubtitlesFile constructor.
     * @param string $name
     * @param $path
     * @throws FileExtensionNotAllowedException
     * @throws FileNotFoundException
     */
    public function __construct(string $name, $path)
    {
        if (!$this->isFileInPath($path)) {
            throw new FileNotFoundException('File "'.$path.'" does not exist"');
        }

        $this->name = $name;
        $this->path = $path;

        if (!$this->isExtensionAllowed($this->getExtension())) {
            throw new FileExtensionNotAllowedException('File extension "'.$this->getExtension().'" is not allowed"');
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return file_get_contents($this->path);
    }

    /**
     * @param $path
     * @return bool
     */
    private function isFileInPath(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @param $ext
     * @return bool
     */
    private function isExtensionAllowed(string $ext): bool
    {
        return in_array($ext, self::ALLOWED_EXTENSIONS);
    }
}