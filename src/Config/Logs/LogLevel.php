<?php

namespace mattvb91\CaddyPhp\Config\Logs;

enum LogLevel: string
{
    case DEBUG = "DEBUG";
    case INFO = "INFO";
    case WARN = "WARN";
    case ERROR = "ERROR";
    case PANIC = "PANIC";
    case FATAL = "FATAL";
}
