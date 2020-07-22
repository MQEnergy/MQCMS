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
    // 错误日志
    $errorHandler = [
        'class' => Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/mqcms-error.log',
            'level' => Logger::ERROR
        ],
        'formatter' => [
            'class' => Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
                'includeStacktraces' => true,
            ],
        ]
    ];

    // debug日志
    $debugHandler = [
        'class' => Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/mqcms-debug.log',
            'level' => Logger::DEBUG,
        ],
        'formatter' => [
            'class' => Formatter\JsonFormatter::class,
            'constructor' => [
                'batchMode' => Formatter\JsonFormatter::BATCH_MODE_JSON,
                'appendNewline' => true,
            ],
        ],
    ];

    // 信息日志
    $infoHandler = [
        'class' => Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/mqcms-info.log',
            'level' => Logger::INFO
        ],
        'formatter' => [
            'class' => Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ]
        ]
    ];

    return [
        'default' => [
            'handlers' => [
                $debugHandler,
                $infoHandler,
                $errorHandler
            ]
        ],
    ];

} else {
    // 错误日志
    $errorHandler = [
        'class' => Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/mqcms-error.log',
            'level' => Logger::ERROR
        ],
        'formatter' => [
            'class' => Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
                'includeStacktraces' => true,
            ],
        ]
    ];

    // 信息日志
    $infoHandler = [
        'class' => Handler\RotatingFileHandler::class,
        'constructor' => [
            'filename' => BASE_PATH . '/runtime/logs/mqcms-info.log',
            'level' => Logger::INFO
        ],
        'formatter' => [
            'class' => Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ]
        ]
    ];

    return [
        'default' => [
            'handlers' => [
                $infoHandler,
                $errorHandler
            ]
        ],
    ];
}

