<?php

namespace App\Log;

use App\Log\Handler\MattermostHandler;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;


/**
 * Class LoggerFactory
 * @package Infotelecom\App\Log
 */
class LoggerFactory
{
    /**
     * @param array $config
     *
     * @return bool|LoggerInterface
     * @throws \Exception
     */
    public static function create(array $config)
    {
        //$channelName, $webHook, $username;
        if (!self::validateConfig($config)) {
            return false;
        }
        $logger = new Logger($config['log_name']);
        $logger->pushHandler(new StreamHandler($config['log_path'], Logger::DEBUG));

        // If we have a mattermost config key in config.yml init and register MatterMost Handler
        if(isset($config['mattermost'])){
            $handler = new MattermostHandler(
                $config['mattermost']['webHook'],
                $config['mattermost']['channelName'],
                $config['mattermost']['username']
            );
            $handler->setLevel(Logger::ERROR);

            $logger->pushHandler($handler);
        }


        // Register the logger to handle PHP errors and exceptions
        ErrorHandler::register($logger);

        return $logger;
    }

    private static function validateConfig(array $config)
    {
        return (isset($config['cdr_log_path'])
            && isset($config['mattermost']['channelName'])
            && isset($config['mattermost']['webHook'])
            && isset($config['mattermost']['username'])
        );
    }
}