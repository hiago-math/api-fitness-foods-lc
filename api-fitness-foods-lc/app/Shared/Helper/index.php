<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('get_files_routes')) {

    /**
     * @param string $folderPath
     */
    function get_files_routes(string $folderPath): void
    {
        if (!is_dir($folderPath)) {
            die("A pasta '$folderPath' não existe.");
        }

        $files = scandir($folderPath);

        foreach ($files as $file) {
            if (is_file($folderPath . '/' . $file) && $file !== '.' && $file !== '..') {
                require_once $folderPath . '/' . $file;
            }
        }
    }
}

if (!function_exists('instantiate_class')) {

    /**
     * @param string $class
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function instantiate_class(string $class): mixed
    {
        return app()->make($class);
    }
}

if (!function_exists('get_ddd_domains')) {

    /**
     * @return array
     */
    function get_ddd_domains(): array
    {
        $domains = [];

        $diretorios = base_path("app" . DIRECTORY_SEPARATOR . "Domain");
        if (File::exists($diretorios)) {
            collect(File::directories($diretorios))
                ->map(
                    function ($diretorios) use (&$domains) {
                        $domains[] = Str::afterLast($diretorios, DIRECTORY_SEPARATOR);
                    }
                );
        }

        return $domains;
    }
}

if (!function_exists('get_ddd_infrastructure_apis')) {

    /**
     * @return array
     */
    function get_ddd_infrastructure_apis(): array
    {
        $domains = [];

        $diretorios = base_path("app" . DIRECTORY_SEPARATOR . "Infrastructure/Apis");
        if (File::exists($diretorios)) {
            collect(File::directories($diretorios))
                ->map(
                    function ($diretorios) use (&$domains) {
                        $domains[] = Str::afterLast($diretorios, DIRECTORY_SEPARATOR);
                    }
                );
        }

        return $domains;
    }
}

if (!function_exists('remove_values_null')) {

    /**
     * @param array $array
     * @return array
     */
    function remove_values_null(array $itens): array
    {
        return array_filter($itens, function ($item) {
            return !is_null($item);
        });
    }
}

if (!function_exists('send_log')) {

    /**
     * @param string $messgae
     * @param array $options
     * @param string $type
     * @param Exception $exception
     * @return void
     */
    function send_log(string $messgae, array $options = [], string $type = "info", \Exception $exception = null)
    {
        if (!is_null($exception)) {
            $options['message'] = $exception->getMessage();
            $options['code'] = $exception->getCode();
            $options['file'] = $exception->getFile() . ": " . $exception->getLine();
            $options['trace'] = $exception->getTraceAsString();
        }

        Log::$type($messgae, $options);
    }
}

if (!function_exists('remove_mask_zip_code')) {

    /**
     * @param string $zip_code
     * @return string
     */
    function remove_mask_zip_code(string $zip_code): string
    {
        return str_replace('-', '', $zip_code);
    }
}

if (!function_exists('add_extension')) {

    /**
     * @param string $filename
     * @param string $extension
     * @return string
     */
    function add_extension(string $filename, string $extension): string
    {
        $extensionFile = Str::afterLast($filename, '.');
        if ($extensionFile === $extension) return $filename;

        return "$filename.$extension";
    }
}

if (!function_exists('prepare_errors_validators')) {

    /**
     * @param array $errors
     * @return array
     */
    function prepare_errors_validators(array $errors): array
    {
        $error = [];
        foreach ($errors as $field => $value) {
            $error[] = $value;
        }

        return $error;
    }
}

if (!function_exists('remove_null_array')) {

    /**
     * @param array $array
     * @return array
     */
    function remove_null_array(array $array): array
    {
        return array_filter($array, function ($value) {
            return $value !== null;
        });
    }
}


