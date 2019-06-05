<?php

declare(strict_types=1);

namespace SubtitlesCounter\Domain\SubtitlesFile;

use SubtitlesCounter\Domain\SubtitlesFile\Exception\SubtitlesTableLoadException;
use SubtitlesCounter\Domain\SubtitlesFile\Parser\SubtitlesSection;

/**
 * Class SubtitlesTable
 */
class SubtitlesTable
{
    /**
     * @var array
     */
    private $words = [];

    /**
     * @param array $sections
     * @throws SubtitlesTableLoadException
     */
    public function loadArray(array $sections): void
    {
        foreach ($sections as $section) {
            if (!$section instanceof SubtitlesSection) {
                throw new SubtitlesTableLoadException("Object loaded to SubtitlesTable has to be an instance of SubtitlesSection class");
            }
            $this->load($section);
        }
    }

    /**
     * @param SubtitlesSection $section
     */
    public function load(SubtitlesSection $section): void
    {
        foreach($section->getWordsArray() as $word) {
            if (empty($word)) {
                continue;
            }
            $this->addWord($word);
        }
    }

    protected function addWord(string $word): void
    {
        if (isset($this->words[$word])) {
            $this->words[$word]++;
            return;
        }
        $this->words[$word] = 1;
    }

    /**
     * @return array
     */
    public function getWords(): array
    {
        arsort($this->words);
        return $this->words;
    }
}