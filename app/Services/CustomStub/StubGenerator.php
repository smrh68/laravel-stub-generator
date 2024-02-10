<?php

namespace App\Services\CustomStub;



class StubGenerator
{
    use FileHelper;

    /**
     * The stub file itself
     *
     * @var string
     */
    protected $stubPath;

    /**
     * The stub file content
     *
     * @var string
     */
    protected $stubContent;

    /**
     * The generated content from stub file content
     *
     * @var string
     */
    protected $generatedContent;

    /**
    * The stub file from which to generate file
    *
    * @param string $stub
    *
    * @return self
    */
    public function load(string $stub) {
        $this->stubPath = $this->getFileFullPath($stub);
        if( ! $this->fileExists($this->stubPath) ) {
            throw StubGenerationException::stubFileNotFound($this->stubPath);
        }
        $this->stubContent = $this->getFileContent($this->stubPath);
        return $this;
    }

    /**
     * Map the stub file and replace each content
     *
     * @param  array  $contents
     *
     * @return self
     */
    public function make(array $contents = [])
    {
        $this->generatedContent = $this->stubContent;
        foreach ($contents as $key => $value){
            $this->processStub($key, $value);
        }
        return $this;
    }

    /**
     * Replace the occurrence of target string using the provided value
     *
     * @param  string  $key
     * @param  string  $content
     *
     * @return self
     */
    protected function processStub(string $key, string $content)
    {

        $pattern = "/\{\{\s*$key\s*\}\}/";
        $this->generatedContent = preg_replace($pattern, $content, $this->generatedContent);
        return $this;

    }

    /**
     * Save the the generated file
     *
     * @return bool
     */
    public function save(string $generatedFilePath)
    {
        if ( $this->fileExists($generatedFilePath) ) {
            throw StubGenerationException::generatingFileAlreadyExists($generatedFilePath);
        }

        $this->saveGeneratedFile($generatedFilePath, $this->generatedContent);

        return true;
    }
}
