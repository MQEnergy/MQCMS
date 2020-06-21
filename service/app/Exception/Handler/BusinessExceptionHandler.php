<?php


namespace App\Exception\Handler;


use App\Exception\BusinessException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class BusinessExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Throwable $throwable
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof BusinessException) {
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage()
            ], JSON_UNESCAPED_UNICODE);

            // $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
            // $this->logger->error($throwable->getTraceAsString());

            // 阻止异常冒泡
            $this->stopPropagation();
            return $response->withHeader('Content-Type', 'application/json')->withStatus($throwable->getCode())->withBody(new SwooleStream($data));
        }
        return $response;
    }

    /**
     * @param Throwable $throwable
     * @return bool
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}