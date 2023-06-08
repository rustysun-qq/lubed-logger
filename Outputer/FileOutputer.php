<?php

namespace Lubed\Logger\Outputer;

class FileOutputer implements LogOutputer
{
    private $path;
    private $file;
    private $file_handler;
    private $file_rotated;
    private $rotate_format;

    public function __construct(string $file,string $rotate_format='')
    {
        if (!$file) {
            Exceptions::InvalidArgument('Log outputer file is required');
        }
        $this->file = $file;
        $this->rotated = NULL;
        $this->rotate_format=$format;
        $this->path = dirname($file);
        $this->file_handler = null;
    }

    public function output(string $log)
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
            chmod($this->path, 0755);
        }

        $file_rotated = $this->rotate_format?date($this->rotate_format):$this->rotate_format;

        if($file_rotated!==$this->file_rotated)
        {
            $this->file_rotated = $file_rotated;
            $this->file_hander = fopen(sprintf($this->file,$file_rotated),'a');
        }

        fwrite($this->file_handler,$log);
    }

    public function __destruct()
    {
        if($this->file_handler){
            fclose($this->file_handler);
        }
    }

    private function getFileHander(){

    }
}
