<?php

namespace Domain\Files\Interfaces\Services;

interface IFileService
{
    /**
     * @param string $filename
     * @return mixed
     */
    public function downloadFile(string $filename): string;

    /**
     * @return mixed
     */
    public function saveFileStorage(string $content, string $path, string $disk = 'downloads'): string;

    /**
     * @param string $path
     * @return void
     */
    public function deleteFile(string $path): void;
}
