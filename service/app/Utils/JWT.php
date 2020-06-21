<?php
declare(strict_types=1);

/**
 * Jwt类
 */
namespace App\Utils;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Firebase\JWT\JWT as BaseJWT;

class JWT extends BaseJWT
{
    /**
     * 加密方式
     */
    const JWT_ALGORITHM_METHOD = 'HS256';

    /**
     * @var int
     */
    public static $leeway = 3600 * 24 * 2;

    /**
     * @param int $leeway
     */
    public static function setLeeway(int $leeway): void
    {
        self::$leeway = $leeway;
    }

    /**
     * get token info
     * @param $token
     * @return array|bool|object|string
     */
    public static function getTokenInfo($token, $jwt_config)
    {
        try {
            self::setLeeway((int)$jwt_config['exp']);
            $payLoad = self::decode($token, $jwt_config['key'], [self::JWT_ALGORITHM_METHOD]);
            return (array)$payLoad;

        } catch (\Exception $e) {
            throw new BusinessException(ErrorCode::UNAUTHORIZED, $e->getMessage());
        }
    }

    /**
     * create token
     * @param $info
     * @return string
     */
    public static function createToken($info, $jwt_config)
    {
        self::setLeeway((int)$jwt_config['exp']);
        $payload = [
            'iss' => $jwt_config['iss'],        // 签发人
            'aud' => $jwt_config['aud'],        // 接收方
            'iat' => time(),                    // 签发时间
            'exp' => time() + self::$leeway,    // 过期时间
            'sub' => $info,                     // 主题
        ];
        return self::encode($payload, $jwt_config['key'], self::JWT_ALGORITHM_METHOD);
    }
}