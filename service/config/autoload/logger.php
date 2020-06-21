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
use Monolog\Handler;
use Monolog\Formatter;
use Monolog\Logger;

$appEnv = env('APP_ENV', 'dev');

if ($appEnv === 'dev') {
    $debugFormatter = [
        'class' => Formatter\JsonFormatter::class,
        'constructor' => [
            'batchMode' => Formatter\JsonFormatter::BATCH_MODE_JSON,
            'appendNewline' => true,
        ],
    ];
    $errorFormatter = [
        'class' => Formatter\LineFormatter::class,
        'constructor' => [
            'allowInlineLineBreaks' => true,
            'includeStacktraces' => true,
        ]
    ];
    $infoFormatter = [
        'class' => Formatter\LineFormatter::class,
        'constructor' => [
            'allowInlineLineBreaks' => true,
            'includeStacktraces' => false,
        ]
    ];
    $debugHandler = [
        'class' => Handler\StreamHandler::class,
        'constructor' => [
            'stream' => BASE_PATH . '/runtime/logs/mqcms-debug-' . date('Y-m-d') . '.log',
            'level' => Logger::DEBUG,
        ],
        'formatter' => $debugFormatter,
    ];

    $infoHandler = [
        'class' => Handler\StreamHandler::class,
        'constructor' => [
            'stream' => BASE_PATH . '/runtime/logs/mqcms-info-' . date('Y-m-d') . '.log',
            'level' => Logger::INFO
        ],
        'formatter' => $infoFormatter
    ];

    return [
        'default' => [
            'handlers' => [
                $debugHandler,
                $infoHandler,
                [
                    'class' => Handler\StreamHandler::class,
                    'constructor' => [
                        'stream' => BASE_PATH . '/runtime/logs/mqcms-error-' . date('Y-m-d') . '.log',
                        'level' => Logger::ERROR
                    ],
                    'formatter' => $errorFormatter
                ]
            ]
        ],
    ];

} else {
    $errorFormatter = [
        'class' => Formatter\LineFormatter::class,
        'constructor' => [
            'allowInlineLineBreaks' => true,
            'includeStacktraces' => true,
        ]
    ];
    $infoFormatter = [
        'class' => Formatter\LineFormatter::class,
        'constructor' => [
            'allowInlineLineBreaks' => true,
            'includeStacktraces' => false,
        ],
    ];
    $infoHandler = [
        'class' => Handler\StreamHandler::class,
        'constructor' => [
            'stream' => BASE_PATH . '/runtime/logs/mqcms-info-' . date('Y-m-d') . '.log',
            'level' => Logger::INFO
        ],
        'formatter' => $infoFormatter
    ];

    return [
        'default' => [
            'handlers' => [
                $infoHandler,
                [
                    'class' => Handler\StreamHandler::class,
                    'constructor' => [
                        'stream' => BASE_PATH . '/runtime/logs/mqcms-error-' . date('Y-m-d') . '.log',
                        'level' => Logger::ERROR
                    ],
                    'formatter' => $errorFormatter
                ]
            ]
        ],
    ];
}

