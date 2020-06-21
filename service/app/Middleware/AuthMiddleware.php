<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware extends BaseAuthMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->challenge();
        $header = $request->getHeader($this->header);
        $tokenInfo = $this->authenticate($header);
        if (!$tokenInfo) {
            throw new BusinessException(ErrorCode::UNAUTHORIZED, 'Signature verification failed');
        }
        return $handler->handle($request);
    }
}