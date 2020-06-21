<?php
declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 业务错误码
 * @Constants
 */
class BusinessErrorCode extends AbstractConstants
{
    /**
     * @Message("Continue")
     */
    const CONTINUE = 10001;
}