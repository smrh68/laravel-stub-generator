<?php
namespace App\Services\CustomStub;

use Exception;

class StubGenerationException extends Exception
{
    /**
     * The stub file not found exception
     *
     * @param  string  $stubFilePath
     * @return object<\Exception>
     */
    public static function stubFileNotFound(string $stubFilePath) {

        return new static("Stub file not found at given path `{$stubFilePath}`");
    }

    /**
     * The same name of generating file name already exist at given location exception
     *
     * @return object<\Exception>
     */
    public static function generatingFileAlreadyExists(string $filePath) {

        return new static("The file already exists at `{$filePath}`");
    }

}
