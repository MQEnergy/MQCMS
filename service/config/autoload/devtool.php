<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'generator' => [
        'amqp' => [
            'consumer' => [
                'namespace' => 'App\\Amqp\\Consumer',
            ],
            'producer' => [
                'namespace' => 'App\\Amqp\\Producer',
            ],
        ],
        'aspect' => [
            'namespace' => 'App\\Aspect',
        ],
        'command' => [
            'namespace' => 'App\\Command',
        ],
        'controller' => [
            'namespace' => 'App\\Controller',
        ],
        'job' => [
            'namespace' => 'App\\Job',
        ],
        'listener' => [
            'namespace' => 'App\\Listener',
        ],
        'middleware' => [
            'namespace' => 'App\\Middleware',
        ],
        'Process' => [
            'namespace' => 'App\\Processes',
        ],
    ],
    'mqcms' => [
        'controller' => [
            'namespace' => 'App\\Controller\\Admin',
        ],
        'service' => [
            'namespace' => 'App\\Service\\Common',
        ],
        'logic' => [
            'namespace' => 'App\\Logic\\Admin',
        ],
        'plugin' => [
            'controllerNamespace' => 'App\\Controller\\Admin\\Plugins',
            'serviceNamespace' => 'App\\Service\\Plugins',
            'modelNamespace' => 'App\\Model\\Common',
        ],
        'init' => []
    ]
];
