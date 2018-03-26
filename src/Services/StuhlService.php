<?php

namespace Partymeister\Core\Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

define('EVENT_LEVEL_GOOD', 'GOOD');
define('EVENT_LEVEL_BAD', 'BAD');
define('EVENT_LEVEL_BORING', 'BORING');
define('EVENT_LEVEL_GAY', 'GAY');

define('EVENT_CHANNEL_ORGA', 'orga');
define('EVENT_CHANNEL_PUBLIC', 'public');
define('EVENT_CHANNEL_ALL', 'all');

class StuhlService
{

    public static $debug = false;

    public static $host;

    public static $password;


    public static function send(
        $message,
        $title = '',
        $link = '',
        $level = EVENT_LEVEL_BORING,
        $destination = EVENT_CHANNEL_ORGA
    ) {
        $config = config('partymeister-core-stuhl');

        self::$debug    = array_get($config, 'debug', false);
        self::$host     = array_get($config, 'server', '');
        self::$password = array_get($config, 'password', '');

        if (self::$debug) {
            $destination = 'testing';
        }

        $data_string = json_encode([
            'key'         => self::$password,
            'level'       => strtolower($level),
            'title'       => $title,
            'link'        => $link,
            'message'     => $message,
            'destination' => $destination
        ]);

        $client = new Client();

        $request = new Request('POST', self::$host, [ 'content-type' => 'application/json' ], $data_string);

        try {
            $response = $client->send($request);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return $e->getMessage();
        }

        return $response->getStatusCode();
    }
}
