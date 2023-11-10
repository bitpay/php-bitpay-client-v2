<?php

//
///**
// * Copyright (c) 2019 BitPay
// **/
//
//declare(strict_types=1);
//
//namespace BitPaySDK\Logger;
//
//use Monolog\Handler\StreamHandler;
//use Monolog\Level;
//use Monolog\Logger as MonologLogger;
//
//class MonologLoggerExample implements BitPayLogger
//{
//    private MonologLogger $logger;
//
//    public function __construct()
//    {
//        $this->logger = new MonologLogger('channel');
//        $this->logger->pushHandler(new StreamHandler('path/to/your.log', Level::Info));
//    }
//
//    public function logRequest(string $method, string $endpoint, ?string $json): void
//    {
//        $this->logger->info($this->getLogMessage('Request', $method, $endpoint, $json));
//    }
//
//    public function logResponse(string $method, string $endpoint, ?string $json): void
//    {
//        $this->logger->info($this->getLogMessage('Response', $method, $endpoint, $json));
//    }
//
//    public function logError(?string $message): void
//    {
//        $this->logger->error($message);
//    }
//
//    private function getLogMessage(string $type, string $method, string $endpoint, ?string $json): string
//    {
//        $array = [
//            'type' => $type,
//            'method' => $method,
//            'endpoint' => $endpoint,
//            'json' => $json
//        ];
//
//        return json_encode($array, JSON_ERROR_NONE);
//    }
//}
