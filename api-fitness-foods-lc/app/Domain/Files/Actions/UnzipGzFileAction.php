<?php

namespace Domain\Files\Actions;

use Domain\Files\Interfaces\Services\IFileService;
use Illuminate\Support\Str;

class UnzipGzFileAction
{
    public function __construct(
        private IFileService $fileService
    )
    {}

    public function execute(string $filename, string $binFile)
    {
        $content = '';
        $unzipFile = $this->saveFileGzTemporary($binFile, $filename);

        $gz = gzopen($unzipFile, 'rb');

        while (!gzeof($gz)) {
            $chunk = gzread($gz, 1024);
            $content .= $chunk;
        }

        gzclose($gz);
        $this->fileService->cleanStoage();

        $path = 'js/' . Str::beforeLast($filename, '.gz');
        return $this->fileService->saveFileStorage($content, $path);

    }

    private function saveFileGzTemporary(string $binFile, string $name)
    {
        $path = 'gz/' . $name;
        return $this->fileService->saveFileStorage($binFile, $path);
    }
}
