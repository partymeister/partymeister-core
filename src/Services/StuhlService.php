<?php

namespace Partymeister\Core\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 *
 */
define('EVENT_LEVEL_GOOD', 'GOOD');
/**
 *
 */
define('EVENT_LEVEL_BAD', 'BAD');
/**
 *
 */
define('EVENT_LEVEL_BORING', 'BORING');
/**
 *
 */
define('EVENT_LEVEL_GAY', 'GAY');

/**
 *
 */
define('EVENT_CHANNEL_ORGA', 'orga');
/**
 *
 */
define('EVENT_CHANNEL_PUBLIC', 'public');
/**
 *
 */
define('EVENT_CHANNEL_ALL', 'all');

/**
 * Class StuhlService
 *
 * @package Partymeister\Core\Services
 */
class StuhlService
{
    /**
     * @var bool
     */
    public static $debug = false;

    /**
     * @var
     */
    public static $host;

    /**
     * @var
     */
    public static $password;

    /**
     * @param        $message
     * @param string $title
     * @param string $link
     * @param string $level
     * @param string $destination
     * @return int|string
     * @throws GuzzleException
     */
    public static function send(
        $message,
        $title = '',
        $link = '',
        $level = EVENT_LEVEL_BORING,
        $destination = EVENT_CHANNEL_ORGA
    ) {
        $config = config('partymeister-core-stuhl');

        self::$debug = Arr::get($config, 'debug', false);
        self::$host = Arr::get($config, 'server', '');
        self::$password = Arr::get($config, 'password', '');

        if (self::$debug) {
            $destination = 'testing';
        }

        $data_string = json_encode([
            'key'         => self::$password,
            'level'       => strtolower($level),
            'title'       => $title,
            'link'        => $link,
            'message'     => $message,
            'destination' => $destination,
        ]);

        $client = new Client();

        $request = new Request('POST', self::$host, ['content-type' => 'application/json'], $data_string);

        try {
            $response = $client->send($request);
        } catch (Exception $e) {
            Log::warning($e->getMessage());

            return $e->getMessage();
        }

        return $response->getStatusCode();
    }
}
