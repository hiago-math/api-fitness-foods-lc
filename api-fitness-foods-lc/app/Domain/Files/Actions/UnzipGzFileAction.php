<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnzipGzFileAction
{
    public function execute(string $filename, string $binFile)
    {
        $content = '';
        $file = $this->saveFileGzTemporary($binFile, $filename);

        $gz = gzopen($file, 'rb');

        while (!gzeof($gz)) {
            $chunk = gzread($gz, 1024);
            $content .= $chunk;
        }

        gzclose($gz);

        $path = 'js/' .  Str::beforeLast($filename, '.gz');
        Storage::disk('downloads')->put($path, $content);

        return Storage::disk('downloads')->path($path);

    }

    private function saveFileGzTemporary(string $binFile, string $name)
    {
        $path = 'gz/' . $name;
        Storage::disk('downloads')->put($path, $binFile);

        return Storage::disk('downloads')->path($path);
    }
}
