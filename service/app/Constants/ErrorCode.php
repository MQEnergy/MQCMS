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

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Continue")
     */
    const CONTINUE = 100;

    /**
     * @Message("Switching Protocols")
     */
    const SWITCHING_PROTOCOLS = 101;

    /**
     * @Message("OK")
     */
    const OK = 200;

    /**
     * @Message("Created")
     */
    const CREATED = 201;

    /**
     * @Message("Accepted")
     */
    const ACCEPTED = 202;

    /**
     * @Message("Non-Authoritative Information")
     */
    const NON_AUTHOR_INFO = 203;

    /**
     * @Message("No Content")
     */
    const NO_CONTENT = 204;

    /**
     * @Message("Reset Content")
     */
    const RESET_CONTENT = 205;

    /**
     * @Message("Partial Content")
     */
    const PARTIAL_CONTENT = 206;

    /**
     * @Message("Multiple Choices")
     */
    const MULTI_CHOICES = 300;

    /**
     * @Message("Moved Permanently")
     */
    const MOVED_PERMANENTLY = 301;

    /**
     * @Message("Found")
     */
    const FOUND = 302;

    /**
     * @Message("See Other")
     */
    const SEE_OTHER = 303;

    /**
     * @Message("not modified")
     */
    const NOT_MODIFIED = 304;

    /**
     * @Message("use proxy")
     */
    const USE_PROXY = 305;

    /**
     * @Message("unused")
     */
    const UNUSED = 306;

    /**
     * @Message("Temporary Redirect")
     */
    const TEMP_REDIRECT = 307;

    /**
     * @Message("Bad Request")
     */
    const BAD_REQUEST = 400;

    /**
     * @Message("Unauthorized")
     */
    const UNAUTHORIZED = 401;

    /**
     * @Message("Payment Required")
     */
    const PAYMENT_REQUIRED = 402;

    /**
     * @Message("Forbidden")
     */
    const FORBIDDEN = 403;

    /**
     * @Message("Not Found")
     */
    const HTTP_NOT_FOUND = 404;

    /**
     * @Message("Method Not Allowed")
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * @Message("Not Acceptable")
     */
    const NOT_ACCEPTABLE = 406;

    /**
     * @Message("Proxy Authentication Required")
     */
    const PROXY_AUTH_REQUIRED = 407;

    /**
     * @Message("Request Time-out")
     */
    const REQUEST_TIMEOUT = 408;

    /**
     * @Message("Conflict")
     */
    const CONFLICT = 409;

    /**
     * @Message("Gone")
     */
    const GONE = 410;

    /**
     * @Message("Length Required")
     */
    const LENGTH_REQUIRED = 411;

    /**
     * @Message("Precondition Failed")
     */
    const PRECONDITION_FAILED = 412;

    /**
     * @Message("Request Entity Too Large")
     */
    const REQUEST_ENTITY_TOO_LARGE = 413;

    /**
     * @Message("Request-URI Too Large")
     */
    const REQUEST_URI_TOO_LARGE = 414;

    /**
     * @Message("Unsupported Media Type")
     */
    const UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * @Message("Requested range not satisfiable")
     */
    const REQUEST_RANGE_NOT_SATIS = 416;

    /**
     * @Message("Expectation Failed	")
     */
    const EXPECTATION_FAILED = 417;

    /**
     * @Message("Internal Server Error")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("Not Implemented")
     */
    const NOT_IMPLEMENTED = 501;

    /**
     * @Message("Bad Gateway")
     */
    const BAD_GATEWAY = 502;

    /**
     * @Message("Service Unavailable")
     */
    const SERVICE_UNAVAILABLE = 503;

    /**
     * @Message("Gateway Time-out")
     */
    const GATEWAY_TIMEOUT = 504;

    /**
     * @Message("HTTP Version not supported")
     */
    const HTTP_VERSION_NOT_SUPPORTED = 505;
}
