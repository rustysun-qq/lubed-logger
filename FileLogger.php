<?php
namespace Lubed\Logger;

use Lubed\Utils\Config;
use Lubed\Logger\Outputer\FileOutputer;

class FileLogger extends AbstractLogger
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->outputer = new FileOutputer($this->config->get('path'),$this->config->get('rotate_format'));
    }

    public function format(string $level,string $message, $context)
    {
        $config = $this->config;
        $time = date('Y-m-d H:i:s.u');
        $level = strtoupper($level);
        $app = $config->get('app');
        $module = $config->get('module');
        $log = $this->getLog($message, $context);
        $result = sprintf("[%s]\t[%s]\t[%s]\t%s\t%s\n", $time, $level, $app, $module, $log);
        return $result;
    }

    private function getLog(string $message, $context)
    {
        if (empty($context)) {
            return $message;
        }

        return sprintf("%s\t%s",$message,json_encode(['extra'=>$context],JSON_UNESCAPED_UNICODE));
    }
}
