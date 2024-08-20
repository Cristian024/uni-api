<?php

namespace Test;

require __DIR__ . '/../main.php';
class EventModel
{
    public $cookies = null;
    public $route = null;
    public $method = null;
    public $body = null;
    public $id;

    public function __construct($cookies, $route, $method, $body)
    {
        $this->cookies = $cookies;
        $this->route = $route;
        $this->method = $method;
        $this->body = $body;
    }

    public static function constructEvent(EventModel $testModel)
    {
        if (is_array($testModel->body) || is_object($testModel->body)) {
            $body = json_encode($testModel->body);
        } else if (is_string($testModel->body)) {
            $body = json_decode($testModel->body, true);
            $body = json_encode($body);
        }

        $event = [
            "headers" => json_decode('{"access-token": "Fq0830jA9h5pEeAvdTW5wDglb9JFqBju5RDtls5xKGVVXJAPOwto3bB5ivvVU14E", "Cookie": "' . $testModel->cookies . '"}', true),
            "queryStringParameters" => json_decode('{"route": "' . $testModel->route . '","id": "' . $testModel->id . '"}', true),
            "requestContext" => json_decode('{"httpMethod":"' . $testModel->method . '"}', true),
            "body" => $body
        ];

        echo "\n Evento a ejecutar:" . json_encode($event) . "\n";

        return json_encode($event);
    }

    public static function executeEvent(EventModel $testModel)
    {
        $event = static::constructEvent($testModel);

        $result = main(json_decode($event, true));

        echo "\n Respuesta obtenida: " . $result;

        return $result;
    }
}