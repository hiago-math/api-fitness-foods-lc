<?php

namespace Domain\Files\Interfaces\Services;

interface IFileService
{
    public function downloadFile(string $nameFile);
    public function saveFileStorage();
    public function cleanStoage();
}
