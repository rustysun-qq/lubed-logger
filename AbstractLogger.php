<?php

namespace Lubed\Logger;

use Lubed\Supports\PSR\LoggerInterface;
use Lubed\Supports\PSR\LogLevel;
use Lubed\Utils\Config;

abstract class AbstractLogger implements LoggerInterface
{
    protected $supported = [
        LogLevel::DEBUG=> 1,
        LogLevel::INFO => 2,
        LogLevel::NOTICE => 3,
        LogLevel::WARNING => 4,
        LogLevel::ERROR => 5,
        LogLevel::CRITICAL => 6,
        LogLevel::ALERT => 7,
        LogLevel::EMERGENCY => 8,
    ];
    protected $config;
    protected $outputer = null;
    protected $level_num = 0;

    abstract public function format($level, $message, $context);

    public function __construct(Config $config)
    {
        if (!$config) {
            Exceptions::invalidArgument('Log config is required');
        }
        $this->config = $config;
        $this->level_num = $this->getLevelNum($this->config->get('level');
    }

    public function emergency($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::EMERGENCY)) {
            this->output(LogLevel::EMERGENCY, $message, $context);
        }
    }

    public function alert($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::ALERT)) {
            $this->output(LogLevel::ALERT, $message, $context);
        }
    }

    public function critical($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::CRITICAL)) {
            $this->output(LogLevel::CRITICAL, $message, $context);
        }
    }

    public function error($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::ERROR)) {
            $this->output(LogLevel::ERROR, $message, $context);
        }
    }

    public function warning($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::WARNING)) {
            $this->output(LogLevel::WARNING, $message, $context);
        }
    }
    public function notice($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::NOTICE)) {
            $this->output(LogLevel::NOTICE, $message, $context);
        }
    }

    public function info($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::INFO)) {
            $this->output(LogLevel::INFO, $message, $context);
        }
    }

    public function debug($message, array $context = [])
    {
        if ($this->checkLevel(LogLevel::DEBUG)) {
            $this->output(LogLevel::DEBUG, $message, $context);
        }
    }

    public function log(string $level,string $message, array $context = [])
    {
        if (!isset($this->supported[$level])) {
            Exceptions::invalidArgument(sprintf('Log level %s is illegal.',$level,['method'=>__METHOD__]);
        }
        $this[$level]($message, $context);
    }

    protected function getLevelNum(string $level):int
    {
        return $this->supported[$level];
    }

    public function checkLevel(string $level)
    {
        $num = $this->getLevelNum($level);
        if ($num >= $this->level_num) {
            return true;
        }

        return false;
    }

    public function getOutputer():?LogOutputer
    {
        return $this->outputer;
    }

    public function output(string $level, $message, array $context = [])
    {
        $log = $this->format($level, $message, $context);
        $this->getOutputer()->output($log);
    }
}
