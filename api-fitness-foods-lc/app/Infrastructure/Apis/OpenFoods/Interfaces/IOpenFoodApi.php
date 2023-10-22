<?php

namespace Infrastructure\Apis\OpenFoods\Interfaces;

interface IOpenFoodApi
{
    public function getFilesGz();

    public function downloadFile(string $filename);
}
