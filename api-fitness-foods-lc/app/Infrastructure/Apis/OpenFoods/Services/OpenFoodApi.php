<?php

namespace Infrastructure\Apis\OpenFoods\Services;

use GuzzleHttp\Exception\GuzzleException;
use Infrastructure\Apis\BaseServiceApi;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;

class OpenFoodApi extends BaseServiceApi implements IOpenFoodApi
{
    public function __construct()
    {
        $this->setBaseUrl(config('custom.SERVICE_API_OPEN_FOOD'));
    }

    public function getFilesGz()
    {
        return $this->request('GET', 'index.txt');
    }

    /**
     * @throws GuzzleException
     */
    public function downloadFile(string $filename)
    {
        return $this->request('GET', "{$filename}");
    }
}
