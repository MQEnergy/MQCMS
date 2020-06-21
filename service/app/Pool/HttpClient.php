<?php
declare(strict_types=1);

namespace App\Pool;

use GuzzleHttp\Client;
use Hyperf\Guzzle\HandlerStackFactory;

class HttpClient
{
    /**
     * @var array
     */
    public $option = [
        'max_connections' => 50
    ];

    /**
     * HttpClient constructor.
     * @param array $option
     */
    public function __construct($option = [])
    {
        $this->option = !empty($option) ? $option : $this->option;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        $factory = new HandlerStackFactory();
        $stack = $factory->create($this->option);

        $client = make(Client::class, [
            'config' => [
                'handler' => $stack
            ]
        ]);
        return $client;
    }
}