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

namespace App\Controller;

use App\Exception\BusinessException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * 全局参数验证
     * @param RequestInterface $request
     * @param array $valid_method
     * @param int $code
     * @param string $message
     */
    public function validateParam(RequestInterface $request, array $rules, array $messages=[], int $code=400)
    {
        $validator = $this->validationFactory->make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            throw new BusinessException((int) $code, $errorMessage);
        }
        return $validator->validated();
    }

    /**
     * @param $params
     * @param RequestInterface $request
     * @param array $rules
     * @param array $messages
     * @param int $code
     * @return array
     */
    public function validateRouteParam(RequestInterface $request, $params, array $rules, array $messages=[], int $code=400)
    {
        if (is_array($params)) {
            $validateParams = [];
            array_walk($params, function ($item) use (&$validateParams, $request) {
                $validateParams[$item] = $request->route($item);
            });
        } else {
            $validateParams = [$params => $request->route($params)];
        }
        $validator = $this->validationFactory->make($validateParams, $rules, $messages);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            throw new BusinessException((int) $code, $errorMessage);
        }
        return $validator->validated();
    }
}
