<?php

namespace Test;

require __DIR__ . '/../main.php';
class EventModel
{

    public $rawPath = null;
    public $cookies = null;
    public $route = null;
    public $method = null;
    public $body = null;

    public function __construct($rawPath, $cookies, $route, $method, $body)
    {
        $this->rawPath = $rawPath;
        $this->cookies = $cookies;
        $this->route = $route;
        $this->method = $method;
        $this->body = $body;
    }

    public static function constructEvent(EventModel $testModel)
    {
        if(is_array($testModel->body) || is_object($testModel->body)){
            $body = json_encode($testModel->body);
        }else if(is_string($testModel->body)){
            $body = json_decode($testModel->body, true);
            $body = json_encode($body);
        }

        $event = [
            "rawPath" => "/".$testModel->rawPath,
            "cookies" => json_decode($testModel->cookies, true),
            "headers" => json_decode('{"access-token": "Fq0830jA9h5pEeAvdTW5wDglb9JFqBju5RDtls5xKGVVXJAPOwto3bB5ivvVU14E"}', true),
            "queryStringParameters" => json_decode('{"route": "' . $testModel->route . '"}', true),
            "requestContext" => json_decode('{"http":{"method":"' . $testModel->method . '"}}', true),
            "body" => $body
        ];

        echo "\n Evento a ejecutar:" . json_encode($event) . "\n";

        return json_encode($event);
    }

    public static function executeEvent(EventModel $testModel)
    {
        $event = static::constructEvent($testModel);
        echo "\n Respuesta obtenida: " . main(
            json_decode($event, true)
        );
    }
}