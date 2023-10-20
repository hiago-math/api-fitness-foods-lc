<?php

namespace Domain\Files\Interfaces\Services;

interface IFileService
{
    /**
     * @param string $filename
     * @return mixed
     */
    public function downloadFile(string $filename);

    /**
     * @return mixed
     */
    public function saveFileStorage();

    /**
     * @param string $path
     * @return void
     */
    public function cleanStoage(string $path = '/gz'): void;
}
