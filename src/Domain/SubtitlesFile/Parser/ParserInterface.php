<?php

declare(strict_types=1);

namespace SubtitlesCounter\Domain\SubtitlesFile\Parser;

/**
 * Interface ParserInterface
 * @package SubtitlesCounter\Domain\SubtitlesFile\Parser
 */
interface ParserInterface
{
    /**
     * @param string $content
     * @return SubtitlesSection[]
     */
    public function parse(string $content): array;
}