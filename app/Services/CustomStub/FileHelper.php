<?php

namespace App\Services\CustomStub;

use Illuminate\Support\Facades\File;

trait FileHelper
{

    /**
     * Get the content of file by path
     *
     * @param  string $filePath
     * @return string
     */
    protected function getFileContent(string $filePath)
    {
        return File::get($filePath);
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getFileFullPath(string $stub)
    {
        return base_path('/stubs/'. $stub .'.stub');
    }

    /**
     * Check if file exists
     *
     * @param  string  $filePath
     * @return bool
     */
    protected function fileExists(string $filePath)
    {
        return File::exists($filePath);
    }

    /**
     * Save file with content
     *
     * @param  string  $path
     * @param  string  $content
     *
     * @return bool
     */
    protected function saveGeneratedFile(string $path, string $content)
    {
        return File::put($path, $content);
    }
}
