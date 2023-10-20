<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnzipFileAction
{
    public function execute(string $namefile, string $binFile)
    {
        $file = $this->saveFileGzTemporary($binFile, $namefile);
        $tempFile = tempnam(sys_get_temp_dir(), 'teste');

        $gz = gzopen($file, 'rb');

        $newFile = fopen($tempFile, 'w');

        while (!gzeof($gz)) {
            $chunk = gzread($gz, 1024);
            fwrite($newFile , $chunk);
        }

        gzclose($gz);
        fclose($newFile);

        $path = 'js/' .  Str::beforeLast($namefile, '.gz');
        Storage::disk('downloads')->put($path, $newFile);

        return Storage::disk('downloads')->path($path);

    }

    private function saveFileGzTemporary(string $binFile, string $name)
    {
        $path = 'gz/' . $name;
        Storage::disk('downloads')->put($path, $binFile);

        return Storage::disk('downloads')->path($path);
    }
}
