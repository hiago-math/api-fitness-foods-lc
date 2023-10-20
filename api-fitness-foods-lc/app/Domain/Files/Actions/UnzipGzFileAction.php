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

    public function execute(string $filename, string $pathGz)
    {
        try {
            $content = '';
            $gz = gzopen($pathGz, 'rb');

            while (!gzeof($gz)) {
                $chunk = gzread($gz, 1024);
                $content .= $chunk;
            }

            gzclose($gz);
            $this->fileService->deleteFile('gz/' . $filename);

            $path = 'js/' . Str::beforeLast($filename, '.gz');
            return $this->fileService->saveFileStorage($content, $path);

        } catch (\Exception $exception) {
            send_log($exception->getMessage(), ['CLASS' => __CLASS__], 'error', $exception);
        }
    }


}
