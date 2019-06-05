<?php

use SubtitlesCounter\Application\SubtitlesService;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileNotFoundException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\FileExtensionNotAllowedException;
use SubtitlesCounter\Domain\SubtitlesFile\Exception\SubtitlesTableLoadException;

require_once __DIR__.'/../vendor/autoload.php';

$errorMessage = null;
$originalFileName = null;
$wordsTable = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["file"])) {
    if($_FILES["file"]["size"] !== 0) {
        $originalFileName = $_FILES["file"]["name"];
        $tmpPath = $_FILES["file"]["tmp_name"];

        $subtitlesService = new SubtitlesService();
        try {
            $wordsTable = $subtitlesService->getSubtitlesWordsTable(
                $originalFileName,
                $tmpPath
            );
        } catch (FileNotFoundException|SubtitlesTableLoadException $exception) {
            $errorMessage = 'Server error. Please try again later.';
        } catch (FileExtensionNotAllowedException $exception) {
            $errorMessage = $exception->getMessage();
        }
    }
}
require_once __DIR__ . '/../view/form.php';